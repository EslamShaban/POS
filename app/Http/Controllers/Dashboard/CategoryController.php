<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\CategoryTranslation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        
        $categories = Category::when($request->search, function($q) use ($request){

            return $q->whereTranslationLike('name', '%' . $request->search . '%');

        })->latest()->paginate(5);

        return view('dashboard.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];

        foreach(config('translatable.locales') as $locale){
            $rules+=[$locale . '.name' =>'required|unique:category_translations,name'];
        }

        $request->validate($rules);

        Category::create($request->all());

        return redirect()->route('dashboard.categories.index');
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', compact('category'));
    }

    
    public function update(Request $request, Category $category)
    {
        $rules = [];
        
        $category_translations = new CategoryTranslation;
        
        foreach(config('translatable.locales') as $locale){
            $rules+=[$locale . '.name' =>'required|unique:category_translations,name,' . $category->id . ',category_id'];
        }

        $request->validate($rules);
        $category->update($request->all());

        return redirect()->route('dashboard.categories.index');
    }

   
    public function destroy(Category $category)
    {
            
        $category->delete();

        return redirect()->route('dashboard.categories.index');
    }
}
