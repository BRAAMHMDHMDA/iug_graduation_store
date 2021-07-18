<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories_count = Category::count();
        $products_count = Product::count();
        $customers_count=Customer::count();
        $orders_count=Order::count();

        $sales_data=Order::where('status','delivery_completed')->get();
        return view('dashboard.home', compact('categories_count', 'products_count', 'customers_count', 'orders_count', 'sales_data'));
    }
}
