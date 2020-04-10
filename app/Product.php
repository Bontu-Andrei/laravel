<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $fillable = ['title', 'description', 'price', 'image_path'];

    public $appends = ['image_url', 'encoded_image'];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_product', 'product_id', 'order_id');
    }

    public function getImageUrlAttribute()
    {
        return url('/storage').'/'.($this->image_path ?: 'default.jpg');
    }

    public function getEncodedImageAttribute()
    {
        if (Storage::exists('images/')) {
            $file = Storage::get($this->image_path);

            if ( ! $file) {
                return '';
            }

            return 'data:image/jpg;base64,'.base64_encode($file);
        }

        return '';
    }
}
