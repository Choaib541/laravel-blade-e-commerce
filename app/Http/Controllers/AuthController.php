<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view("auth.login");
    }

    public function register()
    {
        return view("auth.register");
    }

    public function auth(Request $request)
    {

        $formFields = $request->validate([
            "email" => ["required", "email", "exists:users,email"],
            "password" => ["required", "min:8"]
        ]);

        if (auth()->attempt($formFields)) {
            $request->session()->regenerate();
            return redirect(route("dashboard"))->with("success", "Welcome To YOKO Have a goos time");
        }

        return back()->withErrors(["email" => "invalide entry"])->onlyInput("email");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "min:3"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "min:8", "confirmed"],
        ]);

        $validated["password"] = bcrypt($validated["password"]);

        if ($request->hasFile("picture")) {
            $validated["picture"] = $request->file("picture")->store("users_avatar", "public");
        }


        $validated["role_id"] = 2;

        $user = User::create($validated);


        Auth::login($user);
        return redirect(route("dashboard"))->with("success", "Welcome");
    }

    public function logout(Request $request)
    {
        auth()->logout();
        return redirect(route("login"));
    }
}
