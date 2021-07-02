<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
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
         Customer::factory(1)->create();
         Product::factory(3)->create();
         Order::factory(1)->create();
         OrderItem::factory(1)->create();

    }
}
