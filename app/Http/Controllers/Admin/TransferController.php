<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use App\Models\TransferItem;
use App\Models\Product;
use App\Models\WareHouse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransferController extends Controller
{
    public function index()
    {
      $allData = Transfer::with([
        'formWarehouse',
        'toWarehouse',
        'transferItems.product'
        ])->orderBy('id', 'desc')->get();

        return view('admin.transfer.index', compact('allData'));
    }

    public function create(){
        $warehouses = WareHouse::all();
        return view('admin.transfer.create',compact('warehouses'));
    }

    //Transfer Store....
    public function transferStore(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
        'date' => 'required|date',
        'form_warehouse_id' => 'required|exists:ware_houses,id',
        'to_warehouse_id'   => 'required|exists:ware_houses,id',
        'discount' => 'nullable|numeric|min:0',
        'shipping' => 'nullable|numeric|min:0',
        'status' => 'required|in:Transfer,Pending,Ordered',
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
        // Create Transfer
        $transfer = Transfer::create([
            'date' => $request->date,
            'form_warehouse_id' => $request->form_warehouse_id,
            'to_warehouse_id' => $request->to_warehouse_id,
            'discount' => $request->discount ?? 0,
            'shipping' => $request->shipping ?? 0,
            'status' => $request->status,
            'note' => $request->note,
            'grand_total' => $request->grand_total,
            'paid_amount' => $request->paid_amount,
            'due_amount' => $request->due_amount,
        ]);


        // Loop through products
        foreach ($request->products as $productId => $product) {
            $quantity = $product['quantity'];
            $cost = $product['cost'];
            $discount = $product['discount'] ?? 0;
            $subtotal = ($cost * $quantity) - $discount;

            // Create Purchase Item
            TransferItem::create([
            'transfer_id' => $transfer->id,
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

            $productModel->decrement('product_qty', $quantity);
        }

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Transfer saved successfully!',
        ]);
        } catch (\Exception $e) {
        DB::rollBack();

        return response()->json([
            'status' => 'error',
            'message' => 'Transfer failed: ' . $e->getMessage(),
        ], 500);
        }
    }

    //Transfer Details 
    public function transferDetails($id){
        $transfer = Transfer::with('formWarehouse','toWarehouse','transferItems.product')->find($id);
        return view('admin.transfer.transfer_view', compact('transfer'));
    }

    //Transfer Delete....
    public function transferDelete($id){
        $transfer = Transfer::with('TransferItems')->findOrFail($id);

        foreach ($transfer->TransferItems as $item) {

            $product = Product::find($item->product_id);
            if ($product) {
                $product->increment('product_qty', $item->quantity);
            }
        }
        // Delete related purchase items
        $transfer->TransferItems()->delete();

        // Delete the purchase itself
        $transfer->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'transfers  and related items deleted successfully.'
        ]);
    }

    //Transfer Edit..
    public function transferEdit(Request $request,$id){
       $transfer = Transfer::with('formWarehouse','toWarehouse','transferItems.product')->find($id);
        $warehouses = WareHouse::all();
        return view ('admin.transfer.edit', compact('transfer','warehouses'));
    }

    public function transferUpdate(Request $request,$id){
        // dd($request->all());
         $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'form_warehouse_id' => 'required|exists:ware_houses,id',
            'to_warehouse_id'   => 'required|exists:ware_houses,id',
            'discount' => 'nullable|numeric|min:0',
            'shipping' => 'nullable|numeric|min:0',
            'status' => 'required|in:Transfer,Pending,Ordered',
            'note' => 'nullable|string',
            'grand_total' => 'required|numeric|min:0',
            'paid_amount'   => 'nullable|numeric|min:0',
            'due_amount'    => 'nullable|numeric|min:0',
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
            $transfer = Transfer::findOrFail($id);

            // Reverse stock before update
            foreach ($transfer->transferItems as $item) {
                $product = Product::find($item->product_id);
                if ($product) {
                $product->increment('product_qty', $item->quantity);
                }
            }

            // Delete existing Transfer items
            $transfer->transferItems()->delete();

            // Update Transfer
            $transfer->update([
                'date' => $request->date,
                'form_warehouse_id' => $request->form_warehouse_id,
                'to_warehouse_id' => $request->to_warehouse_id,
                'discount' => $request->discount ?? 0,
                'shipping' => $request->shipping ?? 0,
                'status' => $request->status,
                'note' => $request->note,
                'grand_total' => $request->grand_total,
                'paid_amount' => $request->paid_amount,
                'due_amount' => $request->due_amount,
            ]);

            // Re-create Transfer items
            foreach ($request->products as $productId => $productData) {
        $quantity = $productData['quantity'];
        $cost = $productData['net_unit_cost'];
        $discount = $productData['discount'] ?? 0;
        $subtotal = ($cost * $quantity) - $discount;

           TransferItem::create([
            'transfer_id' => $transfer->id,
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
                'message' => 'Transfer updated successfully!',
            ]);
            } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'message' => 'Update failed: ' . $e->getMessage(),
            ], 500);
            }
    }

}
