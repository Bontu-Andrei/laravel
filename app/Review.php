<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = ['id', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
