<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $fillable = [
        'product_id', 'cost', 'price', 'quantity', 'expiry_date', 'subtotal', 'orderable', 'orderable_type', 'orderable_id', 'orderable_type',
    ];

    public function orderable(){
        return $this->morphTo();
    }

    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
}
