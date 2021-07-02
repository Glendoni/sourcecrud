<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "quantity" => 1,
            "price" => $this->faker->randomFloat(2,100.00,400.00),
            "order_id" => 1,
            "product_id" => 1,
            "created_at" => $this->faker->dateTime,
        ];
    }
}
