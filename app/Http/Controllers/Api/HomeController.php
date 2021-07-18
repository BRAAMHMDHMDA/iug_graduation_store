<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources;


class HomeController extends Controller
{
    public function new_arrival(){
        $new_products = Product::published()->latest()->take(15)->get();
        return Resources\Product::collection($new_products);
    }

    public function hot_offers(){
        $products = Product::published()->where('discount','>=','40')->get();
        return Resources\Product::collection($products);
    }


}
