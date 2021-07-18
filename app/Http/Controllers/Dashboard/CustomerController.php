<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request){
        $customers = Customer::when($request->search,function ($q) use ($request){
            return $q->where('phone_number', 'like', '%' .$request->search.'%');
        })->latest()->paginate(5);
//        $customers = Customer::latest()->paginate();
        return view('dashboard.customers.index', compact('customers'));
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();
        session()->flash('success', 'Customer Deleted Successfully');
        return redirect()->route('customers.index');
    }}
