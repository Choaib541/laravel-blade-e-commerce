<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = new Product();
        $sort = request()->sort ?? "id";
        $desc = request()->desc ?? "";
        $search = request()->search ?? "";
        $range = request()->range ?? false;
        $range_from = request()->range_from ?? false;
        $range_to = request()->range_to ?? false;

        $products = $products->search($search, [
            "range" => $range,
            "range_from" => $range_from,
            "range_to" => $range_to,
        ]);

        $products = $products->orderBy($sort,  $desc === "true" ? "desc" : "asc");

        $products = $products->paginate(8);


        return view("dashboard.products.index", ["products" => $products, "sort" => $sort]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("dashboard.products.create");
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
            "title" => ["nullable", "min:3"],
            "image" => ["nullable"],
            "description" => ["nullable", "min:20"],
            "price" => ["nullable", "gt:0", "regex:/[0-9]+/"],
            "in_stock" => ["nullable", "bool"],
            "stock" => ["nullable", "gt:0"],
        ]);


        if ($request->hasFile("image")) {
            $validated["image"] = $request->file("image")->store("products_image", "public");
        }

        $product = Product::create($validated);


        return back()->with("success", "Product Added Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // return view("dashboard.show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->id ?? false;

        try {
            $product = Product::findOrFail($id);
        } catch (\Exception $err) {
            $product = false;
        }

        // $request->session()->regenerate();

        return view("dashboard.products.edit", ["product" => $product]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            "title" => ["nullable", "min:3"],
            "description" => ["nullable", "min:20"],
            "in_stock" => ["nullable", "bool"],
            "stock" => ["nullable", "gt:0", "integer"],
            "price" => ["nullable", "gt:0", "regex:/[0-9]+/"],
        ]);

        if ($request->hasFile("image")) {
            File::delete(public_path($product->image));
            $validated["image"] = $request->file("image")->store("products_image", "public");
        }

        $product->update($validated);

        return back()->with("success", "Product Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with("success", "Product removed successfully");
    }
}
