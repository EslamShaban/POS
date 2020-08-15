<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Order;
use App\Client;
use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {
        

    }//end of index

    public function create(Client $client)
    {
        $categories = Category::with('products')->get();

        return view('dashboard.clients.orders.create', compact('client', 'categories'));

    }//end of create

    public function store(Request $request, Client $client)
    {
        
        $this->attach_order($request, $client);

        return redirect()->route('dashboard.orders.index');

    }//end of store

    public function edit(Client $client, Order $order)
    {
        $categories = Category::with('products')->get();

        return view('dashboard.clients.orders.edit', compact('client', 'order', 'categories'));

    }//end of edit

    public function update(Request $request, Client $client, Order $order)
    {
        
        $request->validate([

            'product_ids' => 'required|array',
            'quanities' => 'required|array'

        ]);

        $this->detach_order($order);

        $this->attach_order($request, $client);

        return redirect()->route('dashboard.orders.index');


    }//end of update

    public function destroy(Client $client, Order $order)
    {
        # code...
    }//end of destroy

    private function attach_order($request, $client)
    {
        $request->validate([

            'product_ids' => 'required|array',
            'quanities' => 'required|array'

        ]);

        $order = $client->orders()->create([]);

        $total_price = 0;

        foreach($request->product_ids as $index=> $product_id){

            $product = Product::FindOrFail($product_id);

            $total_price += $product->sale_price * $request->quanities[$index];

            $order->products()->attach($product_id, [ 'quantity'=> $request->quanities[$index]]);

            $product->update([
                'stock' => $product->stock - $request->quanities[$index]
            ]);
        }

        $order->update([
            'total_price' => $total_price
        ]);
    }

    private function detach_order($order){

        foreach($order->products as $product){

            $product->update([

                'stock' => $product->stock + $product->pivot->quantity

            ]);

        }

        $order->delete();
    }
}
