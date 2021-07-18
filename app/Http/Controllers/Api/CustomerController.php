<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    public function update(Request $request){
        $customer = Auth::guard('api')->user();
//        $customer = Customer::find($id);
        if ($request->hasFile('image') && $request->file('image')->isValid()){
            $image = $request->image;
            Image::make($image)
                ->resize(null, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(base_path('public/media/customers/'. $request->image->hashName()));
            $data['image'] = $request->image->hashName() ;
        }

        $data['name'] = $request->name;
        $data['address'] = $request->address;
        $data['email'] = $request->email;
        $customer->update($data);

        return Response::json([
            'code' =>'1',
            'message' => 'updated successfully'
        ]);
    }

}
