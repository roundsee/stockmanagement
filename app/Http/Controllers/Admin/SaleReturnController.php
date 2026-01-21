<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\SaleReturnItem;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleReturnController extends Controller
{
    public function index()
    {
        $allData = SaleReturn::orderBy('id', 'desc')->get();
        return view('admin.sale.sale-return.index', compact('allData'));
    }

    public function create()
    {
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.sale.sale-return.create', compact('customers', 'warehouses'));
    }

    public function saleReturnStore(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'warehouse_id' => 'required|exists:ware_houses,id',
            'customer_id'   => 'required|exists:customers,id',
            'discount' => 'nullable|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'status' => 'required|in:Return,Pending,Ordered',
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
            $saleReturn = SaleReturn::create([
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


            // Loop through products
            foreach ($request->products as $productId => $product) {
                $quantity = $product['quantity'];
                $cost = $product['cost'];
                $discount = $product['discount'] ?? 0;
                $subtotal = ($cost * $quantity) - $discount;

                // Create Purchase Item
                SaleReturnItem::create([
                    'sale_return_id' => $saleReturn->id,
                    'product_id' => $productId,
                    'net_unit_cost' => $cost,
                    'stock' => $quantity,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'subtotal' => $subtotal,
                ]);

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
                'message' => 'Sale Return saved successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Sale failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function saleReturnDetails($id)
    {
        $sales = SaleReturn::with(['customer', 'warehouse', 'saleReturnItems.product'])->find($id);
        // dd($sales);
        return view('admin.sale.sale-return.view', compact('sales'));
    }

    public function saleReturnInvoice($id)
    {
        $sales = SaleReturn::with(['warehouse', 'saleReturnItems.product', 'customer'])->find($id);
        // dd($sales);
        $pdf = Pdf::loadView('admin.sale.sale-return.invoice_pdf', compact('sales'));
        return $pdf->download('sales_return_' . $id . '.pdf');
    }

    public function saleReturnEdit($id)
    {
        $editData = SaleReturn::with('saleReturnItems', 'product')->findOrFail($id);
        $customers = Customer::all();
        $warehouses = WareHouse::all();
        return view('admin.sale.sale-return.edit', compact('editData', 'customers', 'warehouses'));
    }

    public function saleReturnUpdate(Request $request, $id)
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
            $sale = SaleReturn::findOrFail($id);

            // 1. Revert stock from previous sale return
            foreach ($sale->saleReturnItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                    // Add back the returned quantity (undo previous return)
                    $product->decrement('product_qty', $item->quantity);
                }
            }

            // 2. Delete old items
            $sale->saleReturnItems()->delete();

            // 3. Update sale return record
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

            // 4. Add new items and adjust stock
            foreach ($request->products as $productId => $productData) {
                $quantity = $productData['quantity'];
                $cost = $productData['net_unit_cost'];
                $discount = $productData['discount'] ?? 0;
                $subtotal = ($cost * $quantity) - $discount;

                // Create new item
                SaleReturnItem::create([
                    'sale_return_id' => $sale->id,
                    'product_id' => $productId,
                    'net_unit_cost' => $cost,
                    'stock' => $quantity,
                    'quantity' => $quantity,
                    'discount' => $discount,
                    'subtotal' => $subtotal,
                ]);

                // Update stock: Returned products increase stock
                $product = Product::findOrFail($productId);
                if ($quantity > $product->product_qty) {
                    throw new \Exception("Insufficient stock for product ID: $productId");
                }
                $product->increment('product_qty', $quantity);
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Sale Return updated successfully!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Update failed: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function saleReturnDelete($id)
    {
        $sale = SaleReturn::with('saleReturnItems')->findOrFail($id);

        foreach ($sale->saleReturnItems as $item) {

            $product = Product::find($item->product_id);
            if ($product) {
                $product->decrement('product_qty', $item->quantity);
            }
        }
        // Delete related purchase items
        $sale->saleReturnItems()->delete();

        // Delete the purchase itself
        $sale->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Sales Return and related items deleted successfully.'
        ]);
    }

    //Due Sale Manage

    public function dueSaleIndex()
    {

        $sales = Sale::with(['customer', 'warehouse'])->select('id', 'customer_id', 'warehouse_id', 'due_amount')->where('due_amount', '>', 0)->get();
        return view('admin.sale.due.sale_due', compact('sales'));
    }

    public function  dueSaleReturnIndex()
    {
        $sales = SaleReturn::with(['customer', 'warehouse'])->select('id', 'customer_id', 'warehouse_id', 'due_amount')->where('due_amount', '>', 0)->get();
        return view('admin.sale.due.sale_return', compact('sales'));
    }
}
