<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "title" => $this->faker->name(),
            "image" => "products_image/product.jpg",
            "description" => $this->faker->paragraph(),
            "price" => $this->faker->numberBetween(0, 1000),
            "in_stock" => $this->faker->numberBetween(0, 1),
            "stock" => $this->faker->numberBetween(20, 100),
        ];
    }
}
