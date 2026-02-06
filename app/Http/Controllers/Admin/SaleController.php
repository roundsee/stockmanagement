<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\WareHouse;
use App\Services\StockService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Log;

class SaleController extends Controller
{
  public function index()
  {
    $allData = Sale::orderBy('id', 'desc')->get();
    return view('admin.sale.index', compact('allData'));
  }

  public function create()
  {
    $customers = Customer::all();
    $warehouses = WareHouse::all();
    return view('admin.sale.create', compact('customers', 'warehouses'));
  }

  public function saleStore(Request $request, StockService $stockService)
  {

    $validator = Validator::make($request->all(), [
      'date' => 'required|date',
      'warehouse_id' => 'required|exists:ware_houses,id',
      'customer_id'   => 'required|exists:customers,id',
      'discount' => 'nullable|numeric|min:0',
      'shipping' => 'nullable|numeric|min:0',
      'status' => 'required|in:Received,Pending,Ordered',
      'note' => 'nullable|string',
      'grand_total' => 'required|numeric|min:0',
      'paid_amount'   => 'nullable|numeric|min:0',
      'due_amount'    => 'nullable|numeric|min:0',
      'products' => 'required|array|min:1',
      'products.*.id' => 'required|exists:products,id',
      'products.*.quantity' => 'required|integer|min:1',
      'products.*.cost' => 'required|numeric|min:0',
      'products.*.discount' => 'nullable|numeric|min:0',
    ]);
    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }
    DB::beginTransaction();
    try {
      // Create sale
      $sale = Sale::create([
        'date' => $request->date,
        'warehouse_id' => $request->warehouse_id,
        'customer_id' => $request->customer_id,
        'discount' => $request->discount ?? 0,
        'shipping' => $request->shipping ?? 0,
        'status' => $request->status,
        'note' => $request->note,
        'grand_total' => $request->grand_total,
        'paid_amount' => $request->paid_amount,
        'due_amount' => $request->due_amount,
      ]);


      // Loop through products
      foreach ($request->products as $key => $productData) {
    // AMBIL DATA DARI ARRAY $product, BUKAN DARI $request
$currentProductId = $productData['id'];
    $currentQty       = $productData['quantity'];
    $currentCost      = $productData['cost'];
    $currentDiscount  = $productData['discount'] ?? 0;
            $subtotal = ($currentCost * $currentQty) - $currentDiscount;

        // Create Purchase Item
        SaleItem::create([
          'sale_id' => $sale->id,
          'product_id' => $currentProductId,
          'net_unit_cost' => $currentCost,
          'stock' => $currentQty,
          'quantity' => $currentQty,
          'discount' => $currentDiscount,
          'subtotal' => $subtotal,
        ]);

$stockService->updateStock(
        $currentProductId,      // Benar: pakai variabel lokal loop
        $request->warehouse_id, // Benar: warehouse sama untuk semua produk
        $currentQty,            // Benar: pakai variabel lokal loop
        'out',
        'Sale #' . $sale->id,
        'Penjualan barang'
    );

        // Update product stock (decrement if stock is used)
        $productModel = Product::where('id', $currentProductId)
          ->where('product_qty', '>=', $currentQty)
          ->first();

        if (!$productModel) {
          throw new \Exception("Insufficient stock for product ID: $currentProductId");
        }

        $productModel->decrement('product_qty', $currentQty);
      }

      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => 'Sale saved successfully!',
      ]);
    } catch (\Exception $e) {
      Log::error('Sale Error', [
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
      DB::rollBack();

      return response()->json([
        'status' => 'error',
        'message' => 'Sale failed: ' . $e->getMessage(),
      ], 500);
    }
  }

  public function saleEdit($id)
  {
    $editData = Sale::with('saleItems', 'product')->findOrFail($id);
    $customers = Customer::all();
    $warehouses = WareHouse::all();
    return view('admin.sale.edit', compact('editData', 'customers', 'warehouses'));
  }

  // Add Sale Update
  public function saleUpdate(Request $request, $id)
  {
    $validator = Validator::make($request->all(), [
      'date' => 'required|date',
      'warehouse_id' => 'required|exists:ware_houses,id',
      'customer_id' => 'required|exists:customers,id',
      'discount' => 'nullable|numeric|min:0',
      'shipping' => 'nullable|numeric|min:0',
      'status' => 'required|in:Received,Pending,Ordered',
      'note' => 'nullable|string',
      'grand_total' => 'required|numeric|min:0',
      'paid_amount' => 'nullable|numeric|min:0',
      'due_amount' => 'nullable|numeric|min:0',
      'products' => 'required|array|min:1',
      'products.*.quantity' => 'required|integer|min:1',
      'products.*.net_unit_cost' => 'required|numeric|min:0',
      'products.*.discount' => 'nullable|numeric|min:0',
    ]);

    if ($validator->fails()) {
      return response()->json(['errors' => $validator->errors()], 422);
    }

    DB::beginTransaction();
    try {
      $sale = Sale::findOrFail($id);

      // Reverse stock before update
      foreach ($sale->saleItems as $item) {
        $product = Product::find($item->product_id);
        if ($product) {
          $product->increment('product_qty', $item->quantity);
        }
      }

      // Delete existing sale items
      $sale->saleItems()->delete();

      // Update sale
      $sale->update([
        'date' => $request->date,
        'warehouse_id' => $request->warehouse_id,
        'customer_id' => $request->customer_id,
        'discount' => $request->discount ?? 0,
        'shipping' => $request->shipping ?? 0,
        'status' => $request->status,
        'note' => $request->note,
        'grand_total' => $request->grand_total,
        'paid_amount' => $request->paid_amount ?? 0,
        'due_amount' => $request->due_amount ?? 0,
      ]);

      // Re-create sale items
      foreach ($request->products as $productId => $productData) {
        $quantity = $productData['quantity'];
        $cost = $productData['net_unit_cost'];
        $discount = $productData['discount'] ?? 0;
        $subtotal = ($cost * $quantity) - $discount;

        SaleItem::create([
          'sale_id' => $sale->id,
          'product_id' => $productId,
          'net_unit_cost' => $cost,
          'stock' => $quantity,
          'quantity' => $quantity,
          'discount' => $discount,
          'subtotal' => $subtotal,
        ]);

        // Update product stock
        $product = Product::where('id', $productId)->first();
        if (!$product || $product->product_qty < $quantity) {
          throw new \Exception("Insufficient stock for product ID: $productId");
        }
        $product->decrement('product_qty', $quantity);
      }

      DB::commit();
      return response()->json([
        'status' => 'success',
        'message' => 'Sale updated successfully!',
      ]);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => 'Update failed: ' . $e->getMessage(),
      ], 500);
    }
  }

  public function saleDetails($id)
  {
    $sales = Sale::with('customer', 'saleItems.product')->find($id);
    return view('admin.sale.sale_view', compact('sales'));
  }
  public function saleDelete($id)
  {
    $sales = Sale::with('saleItems')->findOrFail($id);

    // Delete related purchase items
    $sales->saleItems()->delete();

    // Delete the purchase itself
    $sales->delete();

    return response()->json([
      'status' => 'success',
      'message' => 'Sales and related items deleted successfully.'
    ]);
  }

  // Invoice
  public function saleInvoice($id)
  {
    $sales = Sale::with(['customer', 'warehouse', 'saleItems.product'])->find($id);

    $pdf = Pdf::loadView('admin.sale.invoice_pdf', compact('sales'));
    return $pdf->download('sales_' . $id . '.pdf');
  }
}
