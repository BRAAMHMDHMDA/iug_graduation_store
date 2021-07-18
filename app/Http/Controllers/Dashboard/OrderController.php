<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::whereHas('customer', function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(8);

        return view('dashboard.orders.index', compact('orders'));
    }//end of index

    public function products(Order $order)
    {
        $products = $order->products;
        return view('dashboard.orders._products', compact('order', 'products'));

    }//end of products
    public function update_status(Order $order)
    {
        $products = $order->products;
        return view('dashboard.orders._products', compact('order', 'products'));

    }

    public function show_status(Order $order)
    {
        return view('dashboard.orders._status', compact('order'));
    }

    public function update(Request $request, Order $order){
        $request->validate([
            'new_status' => ["required" , Rule::in(['pending','cancelled','in_delivery','delivery_completed'])],
        ]);
        $order->update([
            'status' => $request->new_status
        ]);
        session()->flash('success', 'Update Status Successfully');
        return redirect()->route('orders.index');
    }


    public function destroy(Order $order)
    {
        foreach ($order->products as $product) {

            $product->update([
                'stock' => $product->stock + $product->order_products->quantity
            ]);

        }//end of for each

        $order->delete();
        session()->flash('success', 'deleted successfully');
        return redirect()->route('orders.index');

    }//end of order
}
