<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::when($request->search,function ($q) use ($request){
            return $q->where('name', 'like', '%' .$request->search.'%');
        })->latest()->paginate();
        return Response::json([
            'code' => '1',
            'data' => \App\Http\Resources\Category::collection($categories),
        ]);
    }


    public function show($id)
    {
        $category = Category::find($id);
        if (!$category){
            return response()->json([
                'code' => 404,
                'message' => 'Category Not Found.'
            ],404);
        }
        return new \App\Http\Resources\Category($category);
    }

}
