<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("public.cart", ["products" => auth()->user()->cart_items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            "quantity" => ["required", "integer"],
            "product_id" => ["required", "exists:products,id"]
        ]);

        $product = Product::find($validated["product_id"]);

        $item = [
            "user_id" => auth()->user()->id,
            "product_id" => $validated["product_id"],
            "quantity" => $validated["quantity"],
            "price" => $product->price * $validated["quantity"]
        ];

        Cart::create($item);

        return back()->with("success", "Product added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            "quantity" => ["required", "integer"]
        ]);

        auth()->user()->cart_items()->updateExistingPivot($id, [
            "quantity" => $validated["quantity"],
            "price" =>  $validated["quantity"] * auth()->user()->cart_items->find($id)->price
        ]);

        return back()->with("success", "updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        auth()->user()->cart_items()->detach([$product->id]);

        return back()->with("success", "Created successfully");
    }

    public function checkout()
    {
        $orders = auth()->user()->cart_items;

        if (count($orders) === 0) {
            return back()->with("warning", "Shop First / Pay later");
        }

        foreach ($orders as $order) {
            Sale::create([
                "user_id" => $order->pivot->user_id,
                "product_id" => $order->pivot->product_id,
                "quantity" => $order->pivot->quantity,
                "price" => $order->pivot->price
            ]);
        }

        auth()->user()->cart_items()->sync([]);

        return back()->with("success", "Enjoy your products");
    }
}
