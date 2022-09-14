<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view("public.cart");
    }

    public function checkout()
    {
        return view("public.checkout");
    }
}
