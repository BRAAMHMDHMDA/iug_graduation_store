<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Order;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{

    public function index(){

        $customer = Auth::guard('api')->user();
        $orders =  $customer->orders()->with('products')->get();
//      $orders =  Order::where('customer_id', Auth::id())->get();
//        foreach ($orders as $i => $order){
//            dd($order->id,$order->status,$order->products,$order->orderProducts());
//            foreach ($order->products as $pro){
//                var_dump($order->id,$pro->name,$pro->order_products->quantity,$pro->order_products->price,$pro->order_products->price*$pro->order_products->quantity);
//            }
//            echo($order->products[$i]->id);
//            echo($order->products[$i]->name);
//            echo($order->order_product[$i]->quantity);
//        }
//        return Response::json($orders);
        return Order::collection($orders);
    }


}
