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
Schema::create('stock_mutations', function (Blueprint $col) {
    $col->id();
    $col->foreignId('product_id')->constrained('products')->onDelete('cascade');
    $col->foreignId('warehouse_id')->constrained('ware_houses')->onDelete('cascade');
    
    // Tipe: 'in' (masuk), 'out' (keluar)
    $col->enum('type', ['in', 'out']);
    
    $col->integer('quantity');
    
    // Referensi asal perubahan (misal: "Purchase #101", "Sale #202", "Initial Stock")
    $col->string('reference')->nullable(); 
    
    // Deskripsi tambahan
    $col->text('note')->nullable();
    
    $col->foreignId('user_id')->constrained('users'); // Siapa yang melakukan perubahan
    $col->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_mutations');
    }
};
