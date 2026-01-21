<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SaleReturn;
use App\Models\ReturnPurchase;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['purchaseItems.product', 'supplier', 'warehouse'])->get();
        return view('admin.report.index', compact('purchases'));
    }

    // Filter Purchase
    public function filterPurchase(Request $request)
    {
        $query  = Purchase::with(['supplier', 'warehouse', 'purchaseItems.product']);
        $filter = $request->input('filter');

        switch ($filter) {
            case 'today':
                $start = Carbon::today()->startOfDay();
                $end   = Carbon::today()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'this_week':
                $start = Carbon::now()->startOfWeek()->startOfDay();
                $end   = Carbon::now()->endOfWeek()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'last_week':
                $start = Carbon::now()->subWeek()->startOfWeek()->startOfDay();
                $end   = Carbon::now()->subWeek()->endOfWeek()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'this_month':
                $start = Carbon::now()->startOfMonth()->startOfDay();
                $end   = Carbon::now()->endOfMonth()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'last_month':
                $start = Carbon::now()->subMonth()->startOfMonth()->startOfDay();
                $end   = Carbon::now()->subMonth()->endOfMonth()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'custom':
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end   = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;
        }

        $purchases = $query->orderByDesc('date')->get();

        $data = [];
        foreach ($purchases as $purchase) {
            foreach ($purchase->purchaseItems as $item) {
                $data[] = [
                    'date'          => $purchase->date instanceof \Carbon\Carbon
                        ? $purchase->date->toDateString()
                        : (string) $purchase->date,
                    'supplier'      => optional($purchase->supplier)->name ?? 'N/A',
                    'warehouse'     => optional($purchase->warehouse)->name ?? 'N/A',
                    'product'       => optional($item->product)->name ?? 'N/A',
                    'quantity'      => $item->quantity ?? 0,
                    'net_unit_cost' => '₹' . number_format((float)($item->net_unit_cost ?? 0), 2, '.', ','),
                    'status'        => $purchase->status ?? 'N/A',
                    'grand_total'   => '₹' . number_format((float)($purchase->grand_total ?? 0), 2, '.', ','),
                ];
            }
        }

        return response()->json(['data' => $data]);
    }

    public function purchaseReturn()
    {
        $returnPurchases = ReturnPurchase::with(['return_purchase_items.product', 'supplier', 'warehouse'])->get();
        return view('admin.report.purchase_return', compact('returnPurchases'));
    }

    public function filterPurchaseReturn(Request $request)
    {
        $query  = ReturnPurchase::with(['return_purchase_items.product', 'supplier', 'warehouse']);
        $filter = $request->input('filter');

        switch ($filter) {
            case 'today':
                $start = Carbon::today()->startOfDay();
                $end   = Carbon::today()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'this_week':
                $start = Carbon::now()->startOfWeek()->startOfDay();
                $end   = Carbon::now()->endOfWeek()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'last_week':
                $start = Carbon::now()->subWeek()->startOfWeek()->startOfDay();
                $end   = Carbon::now()->subWeek()->endOfWeek()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'this_month':
                $start = Carbon::now()->startOfMonth()->startOfDay();
                $end   = Carbon::now()->endOfMonth()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'last_month':
                $start = Carbon::now()->subMonth()->startOfMonth()->startOfDay();
                $end   = Carbon::now()->subMonth()->endOfMonth()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'custom':
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end   = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;
        }

        $purchaseReturns = $query->orderByDesc('date')->get();

        $data = [];
        foreach ($purchaseReturns as $purchaseReturn) {
            foreach ($purchaseReturn->return_purchase_items as $item) {
                $data[] = [
                    'date'          => $purchaseReturn->date instanceof \Carbon\Carbon
                        ? $purchaseReturn->date->toDateString()
                        : (string) $purchaseReturn->date,
                    'supplier'      => optional($purchaseReturn->supplier)->name ?? 'N/A',
                    'warehouse'     => optional($purchaseReturn->warehouse)->name ?? 'N/A',
                    'product'       => optional($item->product)->name ?? 'N/A',
                    'quantity'      => $item->quantity ?? 0,
                    'net_unit_cost' => '₹' . number_format((float)($item->net_unit_cost ?? 0), 2, '.', ','),
                    'status'        => $purchaseReturn->status ?? 'N/A',
                    'grand_total'   => '₹' . number_format((float)($purchaseReturn->grand_total ?? 0), 2, '.', ','),
                ];
            }
        }

        return response()->json(['data' => $data]);
    }

    public function saleReport()
    {
        $sales = Sale::with(['saleItems.product', 'customer', 'warehouse'])->get();
        return view('admin.report.sale', compact('sales'));
    }
    public function filterSale(Request $request)
    {
        $query = Sale::with(['saleItems.product', 'customer', 'warehouse']);
        $today = Carbon::today();
        $filter = $request->input('filter');
        switch ($filter) {
            case 'today':
                $query->whereDate('date', $today);
                break;
            case 'this_week':
                $query->whereBetween('date', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'last_week':
                $query->whereBetween('date', [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()]);
                break;
            case 'this_month':
                $query->whereMonth('date', Carbon::now()->month);
                break;
            case 'last_month':
                $query->whereMonth('date', Carbon::now()->subMonth()->month);
                break;
            case 'custom':
                $start = Carbon::parse($request->start_date);
                $end = Carbon::parse($request->end_date);
                $query->whereBetween('date', [$start, $end]);
                break;
        }

        $sales = $query->get();

        $data = [];

        foreach ($sales as $sale) {
            foreach ($sale->saleItems as $item) {
                $data[] = [
                    'date'          => $sale->date,
                    'customer'      => $sale->customer->name ?? ' ',
                    'warehouse'     => $sale->warehouse->name ?? ' ',
                    'product'       => $item->product->name ?? ' ',
                    'quantity'      => $item->quantity ?? ' ',
                    'net_unit_cost' => '₹' . number_format((float)($item->net_unit_cost ?? 0), 2, '.', ','),
                    'status'        => $sale->status ?? ' ',
                    'grand_total'   => '₹' . number_format((float)($sale->grand_total ?? 0), 2, '.', ','),
                ];
            }
        }

        return response()->json(['data' => $data]);
    }

    public function saleReturnReports()
    {
        $returnSales = SaleReturn::with(['saleReturnItems.product', 'customer', 'warehouse'])->get();
        return view('admin.report.sale_return', compact('returnSales'));
    }
    public function saleReturnFilter(Request $request)
    {
        $query  = SaleReturn::with(['saleReturnItems.product', 'customer', 'warehouse']);
        $filter = $request->input('filter');

        switch ($filter) {
            case 'today':
                $start = Carbon::today()->startOfDay();
                $end   = Carbon::today()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'this_week':
                $start = Carbon::now()->startOfWeek()->startOfDay();
                $end   = Carbon::now()->endOfWeek()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'last_week':
                $start = Carbon::now()->subWeek()->startOfWeek()->startOfDay();
                $end   = Carbon::now()->subWeek()->endOfWeek()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'this_month':
                $start = Carbon::now()->startOfMonth()->startOfDay();
                $end   = Carbon::now()->endOfMonth()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'last_month':
                $start = Carbon::now()->subMonth()->startOfMonth()->startOfDay();
                $end   = Carbon::now()->subMonth()->endOfMonth()->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;

            case 'custom':
                $start = Carbon::parse($request->start_date)->startOfDay();
                $end   = Carbon::parse($request->end_date)->endOfDay();
                $query->whereBetween('date', [$start, $end]);
                break;
        }

        $saleReturns = $query->orderByDesc('date')->get();

        $data = [];
        foreach ($saleReturns as $saleReturn) {
            foreach ($saleReturn->saleReturnItems as $item) {
                $data[] = [
                    'date'          => $saleReturn->date instanceof \Carbon\Carbon
                        ? $saleReturn->date->toDateString()
                        : (string) $saleReturn->date,
                    'customer'      => optional($saleReturn->customer)->name ?? 'N/A',
                    'warehouse'     => optional($saleReturn->warehouse)->name ?? 'N/A',
                    'product'       => optional($item->product)->name ?? 'N/A',
                    'quantity'      => $item->quantity ?? 0,
                    'net_unit_cost' => '₹' . number_format((float)($item->net_unit_cost ?? 0), 2, '.', ','),
                    'status'        => $saleReturn->status ?? 'N/A',
                    'grand_total'   => '₹' . number_format((float)($saleReturn->grand_total ?? 0), 2, '.', ','),
                ];
            }
        }

        return response()->json(['data' => $data]);
    }


    public function stockReport()
    {
        $stockReports = Product::with(['category', 'warehouse'])->get();
        return view('admin.report.stock_report', compact('stockReports'));
    }


    public function filterStockReport(Request $request)
    {
        $filter = $request->input('filter');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Product::with(['category', 'warehouse']);

        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', Carbon::today());
                break;

            case 'this_week':
                $query->whereBetween('created_at', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;

            case 'last_week':
                $query->whereBetween('created_at', [
                    Carbon::now()->subWeek()->startOfWeek(),
                    Carbon::now()->subWeek()->endOfWeek()
                ]);
                break;

            case 'this_month':
                $query->whereMonth('created_at', Carbon::now()->month)
                    ->whereYear('created_at', Carbon::now()->year);
                break;

            case 'last_month':
                $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                    ->whereYear('created_at', Carbon::now()->subMonth()->year);
                break;

            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [
                        Carbon::parse($startDate)->startOfDay(),
                        Carbon::parse($endDate)->endOfDay()
                    ]);
                }
                break;
        }

        $products = $query->get();


        $data = $products->map(function ($item, $index) {
            return [
                $index + 1,
                $item->name,
                $item->category->name ?? '',
                $item->warehouse->name ?? '',
                $item->product_qty ?? 0
            ];
        });

        return response()->json(['data' => $data]);
    }
}
