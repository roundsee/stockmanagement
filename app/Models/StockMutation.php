<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMutation extends Model
{
    protected $fillable = [
        'product_id', 'warehouse_id', 'type', 'quantity',
        'reference', 'note', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}