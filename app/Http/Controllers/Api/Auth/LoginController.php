<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'phone_number' => 'required',
                'password' => ['required', 'string', 'min:6'],
            ],
            [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute must be At least six letters or numbers',
            ]);
        if ($validator->fails()) {
            return Response::json([
                'code' => '0',
                'message' => $validator->errors()
            ]);
        }


        $customer = Customer::where('phone_number', $request->phone_number)->first();

        if ($customer && Hash::check($request->password, $customer->password))
        {
            if (!$customer->api_token) {
                $token = Str::random(32);
                $customer->api_token = $token;
                $customer->save();
            }
            return response()->json([
                'code' => 1,
                'message' => 'Login Successful!',
                'token' => $customer->api_token,
            ]);
        }

        return response()->json([
            'code' => 0,
            'message' => 'Invalid Phone Number or Password!',
        ]);

    }

    public function logout(Request $request)
    {
        $customer = Auth::guard('api')->user();
        $customer->api_token = null;
        $customer->save();

        return response()->json([
            'code' => 1,
            'message' => 'Logout Successfully!!',
        ]);
    }
}
