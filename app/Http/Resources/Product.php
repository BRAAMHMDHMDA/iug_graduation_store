<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $category = Category::find($this->category_id)->name;

        return [
            'id'=>$this->id,
            'name' => $this->name,
            'category' => $category,
            'stock' => $this->stock,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'sale_price' => $this->sale_price,
            'discount' => "$this->discount%",
            'price_after_discount' => $this->price_after_discount,
            'main_image' => $this->main_image_path,
            'extra_images_path' => $this->extra_images_path,
        ];
    }
}
