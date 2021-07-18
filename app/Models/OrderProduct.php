<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderProduct extends Pivot
{
    protected $table = 'order_products';
    public $timestamps = false;

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function customers()
    {
        return $this->belongsTo(Customer::class);
    }
}
