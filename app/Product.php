<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title', 'description', 'price', 'image_path'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id');
    }
}
