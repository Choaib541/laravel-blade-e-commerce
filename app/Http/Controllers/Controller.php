<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use \Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $categories = Category::withCount("products")->take(12)->get();
        $products = Product::orderBy("id", "desc")->take(8)->get();

        return view("public.index", [
            "categories" => $categories,
            "products" => $products,
        ]);
    }

    public function contact()
    {
        return view("public.contact");
    }

    public function products_index(Request $request)
    {

        $validated = $request->validate([
            "search" => ["nullable", "min:2"],
            "sort" => ["nullable", "in:title,price,created_at"],
            "direc" => ["nullable", "in:asc,desc"],
            "range_option" => ["nullable", "in:price,stock"],
            "range_from" => ["nullable", "integer"],
            "range_to" => ["nullable", "integer"],
        ]);

        $products = new Product();

        $products = $products->search($validated["search"] ?? "");

        $products = $products->sort($validated["sort"] ?? "title", $validated["direc"] ?? "desc");

        if (isset($validated["range_option"]) && isset($validated["range_from"]) && isset($validated["range_to"])) {
            $products = $products->range($validated["range_option"], $validated["range_from"], $validated["range_to"]);
        }

        return view("public.products", [
            "products" => $products->paginate(8)
        ]);
    }

    public function products_show($id)
    {
        $product = Product::with("categories")->findOrFail($id);

        $category = $product->categories->random()->name;

        $products = Product::whereHas("categories", function (Builder $query) use ($category) {
            $query->where("name", "like", "%$category%");
        })->take(12)->get();

        return view("public.show", ["product" => $product, "products" => $products]);
    }
}
