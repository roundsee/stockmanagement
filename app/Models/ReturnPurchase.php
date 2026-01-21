<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReturnPurchase extends Model
{
    protected $guarded = [];

    public function warehouse()
    {
        return $this->belongsTo(WareHouse::class, 'warehouse_id', 'id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
    public function return_purchase_items()
    {
        return $this->hasMany(ReturnPurchaseItem::class, 'return_purchase_id', 'id');
    }
}
