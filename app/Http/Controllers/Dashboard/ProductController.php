<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:create_products'])->only(['create','store']);
        $this->middleware(['permission:update_products'])->only(['edit','update']);
        $this->middleware(['permission:read_products'])->only('index');
        $this->middleware(['permission:delete_products'])->only('destroy');
    }

    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::when($request->search,function($q) use ($request){
            return $q->whereTranslationLike('name','%'.$request->search.'%')
            ->orWhereTranslationLike('description','%'.$request->search.'%');
        })->when($request->category_id,function($query) use ($request){
            return $query->where('category_id',$request->category_id);
        })->latest()->paginate(5);;
        return view('dashboard.products.index',compact('products','categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create',compact('categories'));

    }

    public function store(Request $request)
    {
        // dd($request->all());
        $rules = ['category_id' => 'required'];
        foreach (config('translatable.locales') as $local) {
            $rules[$local.'.name'] ='required|unique:category_translations,name';
            $rules[$local.'.description'] ='required';
        }

        $rules += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required'
        ];

        $request->validate($rules);

        $product = Product::create($request->all());

        return redirect()->route('dashboard.products.index')->with([
            'success' => __('site.added_seccessfully'),
        ]);
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('dashboard.products.edit',compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $rules = ['category_id' => 'required'];
        foreach (config('translatable.locales') as $local) {
            $rules[$local.'.name'] ='required|unique:category_translations,name';
            $rules[$local.'.description'] ='required';
        }

        $rules += [
            'purchase_price' => 'required',
            'sale_price' => 'required',
            'stock' => 'required'
        ];

        $request->validate($rules);

        $product->update($request->all());

        return redirect()->route('dashboard.products.index')->with([
            'success' => __('site.updaded_seccessfully'),
        ]);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.products.index')->with([
            'success' => __('site.deleted_seccessfully'),
        ]);
    }
}
