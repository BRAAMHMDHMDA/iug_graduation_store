<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class WishlistController extends Controller
{

    public function index(Request $request)
    {
        $customer = Auth::guard('api')->user();
        $wishlist = $customer->fav_products()->get();
        return Product::collection($wishlist);
    }


    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $customer_id = Auth::guard('api')->id();
        $product_id = $request->product_id;
        if (Wishlist::where('customer_id',$customer_id)->where('product_id',$product_id)->count()!=0)
        {
            return response()->json([
               'code' => 0,
               'massege' => 'this product in wishlist..'
            ]);
        }

        Wishlist::create([
            'product_id' => $product_id,
            'customer_id' => $customer_id,
        ]);

        return response()->json([
           'code' => 1,
           'massege' => 'successfully added'
        ]);
    }


    public function edit(Wishlist $wishlist)
    {
        //
    }


    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }


    public function destroy($id)
    {

        $customer_id = Auth::guard('api')->id();
        $product_id = $id;
        if (Wishlist::where('customer_id',$customer_id)->where('product_id',$product_id)->get()->count()==0)
        {
            return response()->json([
                'code' => 0,
                "massege" => "this product not found in wishlist.."
            ]);
        }

        if (Wishlist::where('customer_id',$customer_id)->where('product_id',$product_id)->get())
        {
            Wishlist::where('customer_id',$customer_id)->where('product_id',$product_id)->delete();
            return response()->json([
                'code' => 1,
                'massege' => 'Deleted succcessfully.'
            ]);
        }


    }
}
