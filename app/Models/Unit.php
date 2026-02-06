<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $guarded = []; // Mengizinkan semua field diisi (praktis)

    // Atau bisa gunakan fillable:
    // protected $fillable = ['name', 'short_name'];

    /**
     * Relasi ke Product (Satu satuan bisa digunakan oleh banyak produk)
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'unit_id');
    }
}