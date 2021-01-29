<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create_categories'])->only(['create','store']);
        $this->middleware(['permission:update_categories'])->only(['edit','update']);
        $this->middleware(['permission:read_categories'])->only('index');
        $this->middleware(['permission:delete_categories'])->only('destroy');
    }

    public function index(Request $request)
    {

        $categories = Category::when($request->search,function($q) use ($request){
            return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->latest()->paginate(5);
        return view('dashboard.categories.index',compact('categories'));
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {
        $rules = [];
        foreach (config('translatable.locales') as $local) {
            $rules[$local.'.name'] ='required|unique:category_translations,name';
        }

        $request->validate($rules);

        Category::create($request->all());

        return redirect()->route('dashboard.categories.index')->with([
            'success' => __('site.added_seccessfully'),
        ]);
    }

    public function edit(Category $category)
    {
        // dd($category);
        return view('dashboard.categories.edit',compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $rules = [];
        $data = [];
        foreach (config('translatable.locales') as $local) {
            $rules[$local.'.name'] ='required|unique:category_translations,name,'.$category->id.',category_id';
        }

        $request->validate($rules);

        foreach (config('translatable.locales') as $local) {
            $data[$local] =['name' =>$request->$local['name']];
        }

        $category->update($data);

        return redirect()->route('dashboard.categories.index')->with([
            'success' => __('site.added_seccessfully'),
        ]);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('dashboard.categories.index')->with([
            'success' => __('site.deleted_seccessfully'),
        ]);
    }
}
