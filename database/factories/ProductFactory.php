<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return arrayy
     */
    public function definition()
    {
        return [
            "name" => $this->faker->monthName,
            'type' => 1,
            'description' => $this->faker->paragraph(1),
            'rental_price' => $this->faker->randomFloat(2,100.00,400.00),
            'term'  => $this->faker->randomDigit,
            'install'  => $this->faker->boolean,
            "created_at" => $this->faker->dateTime,
        ];
    }
}
