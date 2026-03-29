<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['store_id', 'name', 'category', 'description', 'price', 'image_url', 'is_active'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
