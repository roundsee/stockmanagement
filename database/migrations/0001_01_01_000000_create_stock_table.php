<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $col) {
    $col->id();
    $col->foreignId('product_id')->constrained('products')->onDelete('cascade');
    $col->foreignId('warehouse_id')->constrained('ware_houses')->onDelete('cascade');
    $col->integer('quantity')->default(0);
    $col->timestamps();
    
    // Mencegah duplikasi data produk yang sama di gudang yang sama
    $col->unique(['product_id', 'warehouse_id']);
});
    }
        
};
