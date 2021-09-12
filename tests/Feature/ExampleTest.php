<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use WithoutMiddleware, RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
     $order =   $this->seed('DatabaseSeeder');
        $response = $this->get('/api/orders');

        $response->assertJsonStructure([
          [  'cost' => [],
                'data' => []
          ]
        ]);


      $response->assertSeeText( 'Connectivity');
    }
}
