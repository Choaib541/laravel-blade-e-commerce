<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $rand_categories = Category::inRandomOrder()->take(3)->get();
        $categories = Category::take(12)->get();
        // dd($categories);

        return view("public.index");
    }

    public function contact()
    {
        return view("public.contact");
    }

    public function products_index()
    {
        return view("public.products");
    }

    public function products_show()
    {
        return view("public.show");
    }
}
