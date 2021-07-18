<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    protected function create(Request $request)
    {

        $validator = Validator::make($request->all(),
            [
                'phone_number' => 'required|unique:customers',
                'password' => ['required', 'string', 'min:6'],
                'name' => 'required',
                'email' => 'required|unique:customers',
                'address' => 'required',
            ],
            [
                'required' => 'The :attribute field is required.',
                'unique' => 'The :attribute  is pre-registered.',
                'min' => 'The :attribute must be At least six letters or numbers',
            ]);

        if ($validator->fails()) {
            return Response::json([
                'code' => '0',
                'message' => $validator->errors()
            ]);
        }

//        if ($request->phone_number)
        $data = [
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
        ];
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $image = $request->file('image');
            $image = $image->store('/', 'customers');
            $data['image'] = $image;
        }
        $customer = Customer::create($data);

        if ($customer) {
            $token = Str::random(32);
            $customer->api_token = $token;
            $customer->save();
            return response()->json([
                'code' => 1,
                'token' => $token,
                'message' => 'Register Successful!',
            ]);
        }
        return response()->json([
            'code' => 0,
            'message' => 'Invalid Register!!',
        ]);

    }
}
