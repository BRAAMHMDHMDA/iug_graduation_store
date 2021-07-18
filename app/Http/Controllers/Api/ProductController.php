<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $products = Product::published()->when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' .$request->search.'%');
        })->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        })->latest()->paginate();

//        $products = Product::published()
//                            ->latest()
//                            ->paginate();
        return Resources\Product::collection($products);
    }

    public function show($id)
    {
        $product = Product::find($id);
        if (!$product){
            return response()->json([
                'code' => 404,
                'message' => 'Product Not Found.'
            ],404);
        }
        return $product->load('category');
    }

}
