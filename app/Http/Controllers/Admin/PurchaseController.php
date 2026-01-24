<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\Supplier;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use App\Services\StockService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;


class PurchaseController extends Controller
{
  public function index()
  {
    $allData = Purchase::orderBy('id', 'desc')->get();
    return view('admin.purchase.index', compact('allData'));
  }

  public function create()
  {
    $suppliers = Supplier::all();
    $warehouses = WareHouse::all();
    return view('admin.purchase.create', compact('suppliers', 'warehouses'));
  }



public function purchaseProductSearch(Request $request)
{
    $query = trim($request->input('query'));
    $warehouse_id = $request->input('warehouse_id');

    $products = Product::with(['unit' => function($query) {
        $query->select('id', 'short_name'); // Optimasi: ambil kolom yang perlu saja
    }])
    ->where(function ($q) use ($query) {
        $q->where('name', 'like', "%{$query}%")
          ->orWhere('code', 'like', "%{$query}%");
    })
    ->when($warehouse_id, function ($q) use ($warehouse_id) {
        $q->where('warehouse_id', $warehouse_id);
    })
    // PENTING: unit_id harus ada di sini agar relasi terpanggil
    ->select('id', 'name', 'code', 'price', 'product_qty', 'unit_id')
    ->orderBy('name')
    ->limit(10)
    ->get();

    return response()->json($products);
}

  // Store Data
  public function purchaseStore(Request $request,StockService $stockService)
  {
    // dd($request->all());
    $validator = Validator::make($request->all(), [
      'date' => 'required|date',
      'warehouse_id' => 'required|exists:ware_houses,id',
      'supplier_id' => 'required|exists:suppliers,id',
      'discount' => 'nullable|numeric|min:0',
      'shipping' => 'nullable|numeric|min:0',
      'status' => 'required|in:Received,Pending,Ordered',
      'note' => 'nullable|string',
      'grand_total' => 'required|numeric|min:0',
      'products' => 'required|array|min:1',
      'products.*.id' => 'required|exists:products,id',
      'products.*.quantity' => 'required|integer|min:1',
      'products.*.cost' => 'required|numeric|min:0',
      'products.*.discount' => 'nullable|numeric|min:0',
    ]);

    // Return validation errors
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    DB::beginTransaction();

    try {
      // Create Purchase
      $purchase = Purchase::create([
        'date' => $request->date,
        'warehouse_id' => $request->warehouse_id,
        'supplier_id' => $request->supplier_id,
        'discount' => $request->discount ?? 0,
        'shipping' => $request->shipping ?? 0,
        'status' => $request->status,
        'note' => $request->note,
        'grand_total' => $request->grand_total,
      ]);


      // Loop through products
      foreach ($request->products as $productId => $product) {
        $quantity = $product['quantity'];
        $cost = $product['cost'];
        $discount = $product['discount'] ?? 0;
        $subtotal = ($cost * $quantity) - $discount;

        // Create Purchase Item
        PurchaseItem::create([
          'purchase_id' => $purchase->id,
          'product_id' => $productId,
          'net_unit_cost' => $cost,
          'stock' => $quantity,
          'quantity' => $quantity,
          'discount' => $discount,
          'subtotal' => $subtotal,
        ]);


$stockService->updateStock(
        $productId,      // Benar: pakai variabel lokal loop
        $request->warehouse_id, // Benar: warehouse sama untuk semua produk
        $quantity,            // Benar: pakai variabel lokal loop
        'in',
        'Purchase #' . $purchase->id,
        'Pembelian barang'
    );
        // Update product stock (decrement if stock is used)
        $productModel = Product::where('id', $productId)
          ->where('product_qty', '>=', $quantity)
          ->first();

        if (!$productModel) {
          throw new \Exception("Insufficient stock for product ID: $productId");
        }

        $productModel->increment('product_qty', $quantity);
      }

      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => 'Purchase saved successfully!',
      ]);
    } catch (\Exception $e) {
            Log::error('Purchase Error', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);

      DB::rollBack();

      return response()->json([
        'status' => 'error',
        'message' => 'Purchase failed: ' . $e->getMessage(),
      ], 500);
    }
  }

  // Purchase_Details
  public function detailsPurchase($id)
  {
    $purchase = Purchase::with(['supplier', 'purchaseItems.product'])->find($id);
    return view('admin.purchase.purchase_view', compact('purchase'));
  }

  public function deletePurchase($id)
  {
    $purchase = Purchase::with('purchaseItems')->findOrFail($id);

    // Delete related purchase items
    $purchase->purchaseItems()->delete();

    // Delete the purchase itself
    $purchase->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Purchase and related items deleted successfully.'
    ]);
  }
  public function EditPurchase($id)
  {
    $editData = Purchase::with('purchaseItems.product')->findOrFail($id);
    $suppliers = Supplier::all();
    $warehouses = WareHouse::all();
    return view('admin.purchase.edit', compact('editData', 'suppliers', 'warehouses'));
  }

  public function purchaseUpdate(Request $request, $id)
  {
    // dd($request->all());
    $validator = Validator::make($request->all(), [
      'date' => 'required|date',
      'warehouse_id' => 'required|exists:ware_houses,id',
      'supplier_id' => 'required|exists:suppliers,id',
      'discount' => 'nullable|numeric|min:0',
      'shipping' => 'nullable|numeric|min:0',
      'status' => 'required|in:Received,Pending,Ordered',
      'note' => 'nullable|string',
      'grand_total' => 'required|numeric|min:0',
      'products' => 'required|array|min:1',
      'products.*.quantity' => 'required|integer|min:1',
      'products.*.net_unit_cost' => 'required|numeric|min:0',
      'products.*.discount' => 'nullable|numeric|min:0',
      'products.*.subtotal' => 'required|numeric|min:0',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    DB::beginTransaction();

    try {
      $purchase = Purchase::findOrFail($id);

      // Revert product stock first (add back previous quantities)
      foreach ($purchase->purchaseItems as $oldItem) {
        $product = Product::find($oldItem->product_id);
        if ($product) {
          $product->increment('product_qty', $oldItem->quantity);
        }
      }

      // Delete old items
      $purchase->purchaseItems()->delete();

      // Update purchase
      $purchase->update([
        'date' => $request->date,
        'warehouse_id' => $request->warehouse_id,
        'supplier_id' => $request->supplier_id,
        'discount' => $request->discount ?? 0,
        'shipping' => $request->shipping ?? 0,
        'status' => $request->status,
        'note' => $request->note,
        'grand_total' => $request->grand_total,
      ]);

      // Add updated items
      foreach ($request->products as $productId => $productData) {
        $quantity = $productData['quantity'];
        $cost = $productData['net_unit_cost'];
        $discount = $productData['discount'] ?? 0;
        $subtotal = $productData['subtotal'];

        PurchaseItem::create([
          'purchase_id' => $purchase->id,
          'product_id' => $productId,
          'net_unit_cost' => $cost,
          'stock' => $quantity,
          'quantity' => $quantity,
          'discount' => $discount,
          'subtotal' => $subtotal,
        ]);

        // Decrease product stock again with new values
        $productModel = Product::where('id', $productId)
          ->where('product_qty', '>=', $quantity)
          ->first();

        if (!$productModel) {
          throw new \Exception("Insufficient stock for product ID: $productId");
        }

        $productModel->decrement('product_qty', $quantity);
      }

      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => 'Purchase updated successfully!',
      ]);
    } catch (\Exception $e) {
      DB::rollBack();

      return response()->json([
        'status' => 'error',
        'message' => 'Update failed: ' . $e->getMessage(),
      ], 500);
    }
  }


  // Purchase Invoice
  public function purchaseInvoice($id)
  {
    $purchase = Purchase::with(['supplier', 'warehouse', 'purchaseItems', 'product'])->find($id);
    $pdf = Pdf::loadView('admin.purchase.invoice_pdf', compact('purchase'));
    return $pdf->download('purchase_' . $id);
  }
}
