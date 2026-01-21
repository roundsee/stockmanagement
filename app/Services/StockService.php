<?php

namespace App\Services;

use App\Models\Stock;
use App\Models\StockMutation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockService
{
    /**
     * Update stok dan catat mutasinya dalam satu transaksi database
     */
    public function updateStock($productId, $warehouseId, $quantity, $type, $reference = null, $note = null)
    {
        return DB::transaction(function () use ($productId, $warehouseId, $quantity, $type, $reference, $note) {
            
            // 1. Update atau Buat data stok di tabel 'stocks'
            $stock = Stock::firstOrNew([
                'product_id' => $productId,
                'warehouse_id' => $warehouseId
            ]);

            if ($type === 'in') {
                $stock->quantity += $quantity;
            } else {
                $stock->quantity -= $quantity;
            }
            
            $stock->save();

            // 2. Catat riwayat ke tabel 'stock_mutations'
            return StockMutation::create([
                'product_id'   => $productId,
                'warehouse_id' => $warehouseId,
                'type'         => $type,
                'quantity'     => $quantity,
                'reference'    => $reference,
                'note'         => $note,
                'user_id'      => Auth::id(),
            ]);
        });
    }
}