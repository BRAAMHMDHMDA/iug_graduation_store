<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
//        $categories = Category::all();
        $categories = Category::when($request->search,function ($q) use ($request){
            return $q->where('name', 'like', '%' .$request->search.'%');
        })->latest()->paginate(5);
        return view('dashboard.categories.index', compact('categories'));
    }


    public function create()
    {
        return view('dashboard.categories.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|min:3',
            'image' => 'required'
        ]);


        if ($request->hasFile('image') && $request->file('image')->isValid()){
            $image = $request->file('image');
            $image = $image->store('/', 'categories');
        }
        $data = $request->all();
        $data['image'] = $image;
        Category::create($data);

        session()->flash('success', 'Category Created Successfuly');
        return redirect()->route('categories.index');
    }


    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }


    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|min:3',Rule::unique('categories', 'name')->ignore($category->id),
        ]);
        if ($request->hasFile('image') && $request->file('image')->isValid())
        {
            $image = $request->file('image');
            $image = $image->storeAs('/', basename($category->image_path) ,'customers');
            $data['image'] = $image;
        }

//        if ($request->hasFile('image') && $request->file('image')->isValid())
//        {
////          unlink(public_path('media\categories\images\\'.$category->image)); // php way for delete img
//            Storage::disk('categories')->delete('$category->image'); // laravel way
//            $image = $request->file('image');
//            $image = $image->store('/','categories');
//            $data['image'] = $image;
//        }

        $data['name'] = $request->name;
        $category->update($data);
        session()->flash('success' , 'Category Updated Successfuly');

        return redirect(route('categories.index')) ;
    }


    public function destroy(Category $category)
    {
        $products = Product::all();

        foreach ($products as $product) {
            if ($product->category_id == $category->id) {
                session()->flash('warning','First You Need To Delete a Product Linked With The Category');
                session()->flash('linked-product',$product->id);
                return redirect(route('products.index')) ;
            }
        }

        Storage::disk('categories')->delete($category->image);
        $category->delete();
        session()->flash('success', 'Category Deleted Successfully');
        return redirect()->route('categories.index');

    }
}
