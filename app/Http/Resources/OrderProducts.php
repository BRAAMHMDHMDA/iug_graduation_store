<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderProducts extends JsonResource
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
            'name' => $this->name,
            'category' => $category,
            'stock' => $this->stock,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'sale_price' => $this->order_products->price,
            'quantity' => $this->order_products->quantity,
            'total_price' => $this->order_products->price*$this->order_products->quantity,
            'main_image' => $this->main_image_path,
        ];
    }
}
