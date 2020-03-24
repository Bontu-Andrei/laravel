<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['title', 'rating', 'description', 'product_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
