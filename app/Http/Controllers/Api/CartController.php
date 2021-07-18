<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class CartController extends Controller
{
    public function index(){
        $cart= Cart::with(['product'])->where('customer_id', Auth::id())->get();

        return \App\Http\Resources\Cart::collection($cart);
    }

    public function store(Request $request){

        $request->validate([
            'product_id' => 'required|int|exists:products,id',
            'quantity' => 'int|min:1',
        ]);
        $product = Product::findOrFail($request->product_id);

        if ($product->status == 0){
            return Response::json([
                'code' => '0',
                'message' => 'product not found'
            ]);
        }
        /*if (!$product){
            return Response::json([
                'code' => '0',
                'message' => 'invalid add [product not found]'
            ]);
        }*/
        /*$cart = Cart::where([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ])->first();
        if ($cart) {
            //$cart->increment('quantity', $quantity);
            Cart::where([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
            ])->increment('quantity', $quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'price' => $product->price,
                'quantity' => $quantity,
            ]);
        }*/

         Cart::updateOrCreate([
            'customer_id' => Auth::id(),
            'product_id' => $product->id,
        ], [
            'quantity' => DB::raw("quantity + 1"),
        ]);

        $cart = Cart::where([
            'customer_id' => Auth::id(),
            'product_id' => $product->id,
        ])->first();

        return Response::json([
            'code' => '1',
//            'cart' => $cart,
            'data' =>new \App\Http\Resources\Cart($cart),
            'message' => 'added successfully'
        ]);
//        return new \App\Http\Resources\Cart($cart);
    }

    public function checkout(Request $request)
    {
        $cart = Cart::with('product')->where('customer_id', Auth::id())->get();

        foreach ($cart as $item) {
             if ($item->quantity > Product::find($item->product_id)->stock){
                 $name=Product::find($item->product_id)->name;
                return Response::json([
                    'code' => '0',
                    'messsage' => "The product { $name } is not available in the required quantity"
                ]);
             }
            }


        DB::beginTransaction();
        try {

            if ($cart->isEmpty()){
                return Response::json([
                    'code' => '0',
                    'message'=> 'no product in cart'
                ]);
            }

            $order = Order::create([
                'customer_id' => Auth::id(),
                'status' => 'pending', //default "pending"
            ]);


            foreach ($cart as $index => $item) {
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $cart[$index]->product->price_after_discount
                ]);
                $stock = Product::find($item->product_id)->stock;
                $new_stock = $stock - $item->quantity;
                Product::find($item->product_id)->update(['stock' => $new_stock]);
            }

            $request->user()->cart()->delete();
            //Cart::where('customer_id', Auth::id())->delete();

            DB::commit();

            return Response::json([
                'code' => '1',
//                'data' => [$order,$order->orderProducts()->get()],
                'data' =>new \App\Http\Resources\Order($order),
                'message' => 'added successfully',
            ]);

        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function quantity_decrement(Product $product){


        $cart = Cart::where([
            'customer_id' => Auth::id(),
            'product_id' => $product->id,
        ])->first();


        if ($cart==null){
            return Response::json([
                'code' => '0',
                'message' => 'product not found in the cart'
            ]);
        }

        $cart = Cart::where([
            'customer_id' => Auth::id(),
            'product_id' => $product->id,
        ])->first();
        if ($cart->quantity==1){
            $cart = Cart::where([
                'customer_id' => Auth::id(),
                'product_id' => $product->id,
            ])->delete();
        }else{
        DB::table('carts')
            ->where('customer_id', Auth::id())
            ->where('product_id' , $product->id)
            ->decrement('quantity');
        }


        return Response::json([
            'code' => '1',
            'message' => 'success delete'
        ]);
    }

    public function delete_product(Product $product){
        $cart = Cart::where([
            'customer_id' => Auth::id(),
            'product_id' => $product->id,
        ])->first();


         if ($cart==null){
            return Response::json([
               'code' => '0',
                'message' => 'product not found in the cart'
            ]);
        }
        Cart::where([
            'customer_id' => Auth::id(),
            'product_id' => $product->id,
        ])->delete();

        return Response::json([
           'code' => '1',
           'message' => 'deleted success'
        ]);
    }
}
