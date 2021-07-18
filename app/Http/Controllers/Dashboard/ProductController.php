<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('CheckCategory')->only('create');
    }
    public function index(Request $request)
    {
        $categories = Category::all();
//      $products = Product::all();
        $products = Product::when($request->search, function ($q) use ($request) {

            return $q->where('name', 'like', '%' .$request->search.'%');

        })->when($request->category_id, function ($q) use ($request) {
            return $q->where('category_id', $request->category_id);
        })->latest()->paginate(8);
        return view('dashboard.products.index', compact('categories','products'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }
    public function show(Product $product)
    {
        return view('dashboard.products.show', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products',
            'category_id' => 'required',
            'main_image' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
            'status' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
        ]);
        $data = $request->except('main_image');
        if ($request->hasFile('main_image') && $request->file('main_image')->isValid()){
            $main_image = $request->main_image;
            Image::make($main_image)
                ->resize(null, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('media/products/main_images/'. $request->main_image->hashName()));
        }
        $data['main_image'] = $request->main_image->hashName() ;

        $images = $request->file('images');
        mkdir(public_path("media\\products\\extra_images\\$request->name"));
        foreach ($images as $image){
            Image::make($image)
                ->resize(null, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path("media\\products\\extra_images\\$request->name\\". $image->hashName()));
        }

        Product::create($data);
        session()->flash('success', 'Product Created Successfuly');
        return redirect()->route('products.index');
    }


    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('product' , 'categories'));

    }


    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => ['required',Rule::unique('products','name')->ignore($product->id)],
            'category_id' => 'required',
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
        ]);
        $data = $request->except('main_image');
        if ($request->hasFile('main_image') && $request->file('main_image')->isValid()){
            $main_image = $request->main_image;
            Image::make($main_image)
                ->resize(null, 250, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('media/products/main_images/'. $request->main_image->hashName()));
            $data['main_image'] = $request->main_image->hashName() ;

        }

        if ($request->has('images')){
            File::deleteDirectory(public_path('media\\products\\extra_images\\'.$product->name));
            $images = $request->file('images');
            mkdir(public_path("media\\products\\extra_images\\$request->name"));
            foreach ($images as $image){
                Image::make($image)
                    ->resize(null, 250, function ($constraint) {
                        $constraint->aspectRatio();
                    })->save(public_path("media\\products\\extra_images\\$request->name\\". $image->hashName()));
            }
        }

        $product->update($data);
        session()->flash('success', 'Product Updated Successfuly');
        return redirect()->route('products.index');
    }


    public function destroy(Product $product)
    {
        if (OrderProduct::where('product_id', $product->id)->first()) {
            session()->flash('error', 'You cannot delete this product, because it is in orders');
            return redirect()->route('products.index');
        }else {
            Storage::disk('products')->delete('/main_images/' . $product->main_image);
            File::deleteDirectory(base_path('/public/media/products/extra_images/' . $product->name));
            $product->delete();
            session()->flash('success', 'Product Deleted Successfully');
            return redirect()->route('products.index');
        }
    }
}
