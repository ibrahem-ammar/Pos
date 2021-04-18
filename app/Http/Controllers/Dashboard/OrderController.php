<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::whereHas('client',function ($q) use ($request)
        {
            return $q->where('name','like','%' . $request->search . '%');
        })->paginate(10);

        return view('dashboard.orders.index',compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $client = $request->client;
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.create',compact('client','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'quantity' => 'required|array',
            'client' => 'required'
        ]);

        $client = Client::find($request->client);

        $order = $client->orders()->create(['price'=>0]);

        $total_price = 0 ;


        foreach ($request->quantity as $product_id => $quantity) {

            $product = Product::findOrFail($product_id);

            $total_price += $product->sale_price * $quantity;

            $order->products()->attach($product_id,['quantity'=>$quantity]);

            $product->update([
                'stock' => $product->stock - $quantity
            ]);

        }

        $order->update(['price'=>$total_price]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        // dd($order);

        // $products = $order->products;
        return view('dashboard.orders._products',compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Order $order)
    {
        $client = $request->client;
        $categories = Category::with('products')->get();
        return view('dashboard.clients.orders.edit',compact('client','categories','order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'quantity' => 'required|array',
            'client' => 'required'
        ]);

        $client = Client::find($request->client);


        $order->products()->detach();

        $total_price = 0 ;


        foreach ($request->quantity as $product_id => $quantity) {

            $product = Product::findOrFail($product_id);

            $total_price += $product->sale_price * $quantity;

            $order->products()->attach($product_id,['quantity'=>$quantity]);

            $product->update([
                'stock' => $product->stock - $quantity
            ]);

        }

        $order->update(['price'=>$total_price]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        // dd($order->products()->first()->pivot->quantity);
        foreach ($order->products as $product) {
            $stock = $product->stock + $product->pivot->quantity;
            $product->update([
                'stock'=> $stock
            ]);
        }

        $order->delete();
    }
}
