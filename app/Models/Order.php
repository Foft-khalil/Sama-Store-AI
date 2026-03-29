<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'store_id', 'product_id', 'customer_name', 'customer_phone', 
        'delivery_address', 'status', 'payment_provider', 
        'payment_reference', 'total_amount'
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
