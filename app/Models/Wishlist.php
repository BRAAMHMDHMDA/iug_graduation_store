<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Wishlist extends Pivot
{
    protected $table = 'wishlists';
    public $timestamps = false;
    protected $fillable = [
        'product_id' , 'customer_id'
    ];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    protected function setKeysForSaveQuery(Builder $query)
    {
        return $query->where('customer_id', '=', $this->attributes['customer_id'])
            ->where('product_id', '=', $this->attributes['product_id']);
    }

}
