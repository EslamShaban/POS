<?php

namespace App\Http\Controllers\Dashboard;

use App\Product;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
   
    public function index(Request $request)
    {
        $categories = Category::all();

        $products = Product::when($request->search, function($q) use ($request){

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->when($request->category_id, function($q) use ($request){

            return $q->where('category_id', $request->category_id);

        })->latest()->paginate(5);

        return view('dashboard.products.index', compact('categories','products'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }


    public function store(Request $request)
    {
        $rules = [
            'category_id' => 'required'
        ];

        foreach(config('translatable.locales') as $locale){
            $rules+=[$locale . '.name' =>'required|unique:product_translations,name'];
            $rules+=[$locale . '.description' =>'required'];
        }
        $rules+=[
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required'
        ];
        
        $request->validate($rules);

        $request_data = $request->all();

        if($request->image){

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_image/' . $request->image->hashName()));  
            
            $request_data['image'] =  $request->image->hashName();
        }

        

        Product::create($request_data);

        
        return redirect()->route('dashboard.products.index');

    }

   
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit', compact('categories', 'product'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'category_id' => 'required'
        ];

        foreach(config('translatable.locales') as $locale){
            $rules+=[$locale . '.name' =>'required|unique:product_translations,name,' . $product->id . ',product_id'];
            $rules+=[$locale . '.description' =>'required'];
        }
        $rules+=[
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required'
        ];
        
        $request->validate($rules);

        $request_data = $request->all();

        if($request->image){

            
            if($user->image != 'default.png'){

                File::delete('uploads/products_image/' . $product->image);
            }

            Image::make($request->image)->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_image/' . $request->image->hashName()));  
            
            $request_data['image'] =  $request->image->hashName();
        }

        
        $product->update($request_data);
        
        return redirect()->route('dashboard.products.index');
    }

   
    public function destroy(Product $product)
    {
        if($product->image != 'default.png'){

            File::delete('uploads/products_image/' . $product->image);
        }
    
        $product->delete();

        return redirect()->route('dashboard.products.index');
    }
}
