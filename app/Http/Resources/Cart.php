<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Cart extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $product = \App\Models\Product::find($this->product_id);
        $category = \App\Models\Category::find($product->category_id)->name;
        return [
            'product' => $product->name,
            'category' => $category,
            'quantity' => $this->quantity,
            'product_image' => $product->main_image_path,
            'price' => $product->price_after_discount,
        ];
    }
}
