<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    protected $guarded = ['id'];
    protected $appends = ['main_image_path','price_after_discount','net_profit','extra_images_path'];


    public function getMainImagePathAttribute()
    {
        return asset('media/products/main_images/'.$this->main_image);

    }//end of image path attribute

    public function getExtraImagesPathAttribute()
    {
        $images_path = array();
        $folder_path = 'media/products/extra_images/'.$this->name;
        $path = public_path($folder_path);
        $images = File::files($path);
        $replaceDocPath = str_replace( public_path(),'',$folder_path );
        foreach( $images as $image ) {
            $image_name = $image->getBasename();
            $images_path[] = asset("$replaceDocPath/$image_name");
        }
        return $images_path ;
    }//end of extra images path attribute

    public function getPriceAfterDiscountAttribute()
    {
        if ($this->discount==0){
            return $this->sale_price;
        } else {
            return $this->sale_price-($this->sale_price*$this->discount/100);
        }
    }

    public function getNetProfitAttribute()
    {
        return $this->price_after_discount - $this->purchase_price;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }//end fo category

    public function scopePublished($query)
    {
        return $query->whereStatus(1);
    }

    public function orders(){
        return $this->belongsToMany(Order::class , 'order_products');
    }

}
