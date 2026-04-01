<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = ['whatsapp_number', 'name', 'slug', 'password', 'payment_gateway', 'trial_ends_at', 'is_subscribed'];

    protected $hidden = ['password'];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'is_subscribed' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
