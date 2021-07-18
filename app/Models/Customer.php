<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    protected $table = 'customers';
    protected $fillable = ['name', 'phone_number', 'password', 'email', 'address', 'image'];

    protected $hidden = [
        'password', 'api_token'
    ];
    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('media/customers/' . $this->image);
    }//end of get image path


    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function fav_products()
    {
        return $this->belongsToMany(Product::class, 'wishlists');
    }


}
