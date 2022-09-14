<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Role;
use App\Models\Sale;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            "name" => "admin"
        ]);

        Role::factory(3)->create();
        \App\Models\User::factory(10)->create();
        Category::factory(10)->create();
        Product::factory(100)->create();
        Image::factory(10)->create();
        Sale::factory(10)->create();

        \App\Models\User::create([
            'name' => "camado",
            'email' => "camado@gmail.com",
            'password' => bcrypt("password"),
            "role_id" => 1
        ]);
    }
}
