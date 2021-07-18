<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['image_path'];


    public function getImagePathAttribute()
    {
        return asset('media/categories/images/'.$this->image);
    }//end of get image path
    public function products()
    {
        return $this->hasMany(Product::class);
    }//end of products
}
