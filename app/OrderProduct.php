<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $fillable = ['order_id', 'product_id'];

    protected $table = 'order_product';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
