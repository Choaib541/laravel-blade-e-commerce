<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(["auth"])->group(function () {

    Route::prefix("/dashboard")->group(function () {

        /*_________ Dashboard _________*/
        Route::get("/", [DashboardController::class, "index"])->name("dashboard");

        /*_________ Products _________*/
        Route::get("/products", [ProductController::class, "index"])->name("dashboard.products");
        Route::get("/products/create", [ProductController::class, "create"])->name("dashboard.products.create");
        Route::get("/products/edit/{id?}", [ProductController::class, "edit"])->name("dashboard.products.edit");

        Route::resource("/products", ProductController::class)->only(
            [
                "destroy",
                "store",
                "update",
                "destroy",
            ]
        );

        /*_________ categories _________*/
        Route::get("/categories", [CategoryController::class, "index"])->name("dashboard.categories");
        Route::get("/categories/create", [CategoryController::class, "create"])->name("dashboard.categories.create");
        Route::get("/categories/edit", [CategoryController::class, "edit"])->name("dashboard.categories.edit");

        Route::resource("/categories", CategoryController::class)->only(
            [
                "destroy",
                "store",
                "update",
                "destroy",
            ]
        );

        /*_________ Users _________*/
        Route::get("/users", [UserController::class, "index"])->name("dashboard.users");
        Route::get("/users/create", [UserController::class, "create"])->name("dashboard.users.create");
        Route::get("/users/edit", [UserController::class, "edit"])->name("dashboard.users.edit");

        Route::resource("/users", UserController::class)->only(
            [
                "destroy",
                "store",
                "update",
                "destroy",
            ]
        );
    });
    /*___________________ logout ___________________*/
    Route::post("/logout", [AuthController::class, "logout"])->name("logout");
});

Route::get("/", [Controller::class, "index"])->name("home");
Route::get("/contact", [Controller::class, "contact"])->name("contact");
Route::get("/products", [Controller::class,      "products_index"])->name("products");
Route::get("/products/{id}", [Controller::class, "products_show"])->name("products.show");
Route::get("/cart", [CartController::class, "index"])->name("cart");
Route::get("/cart/checkout", [CartController::class, "checkout"])->name("cart.checkout");


Route::get("/login", [AuthController::class, "login"])->name("login");
Route::post("/login", [AuthController::class, "auth"])->name("auth");
Route::get("/register", [AuthController::class, "register"])->name("register");
Route::post("/register", [AuthController::class, "store"])->name("store");
