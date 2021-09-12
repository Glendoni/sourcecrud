<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource and claffcheckDeleteAmend.
     *
     * @return \Illuminate\Http\Response
     * @todo  Replace $user_id with auth::id() when using auth middleware
     */
    public function index()
    {

       // return ['Hello world'];
        try {
            $user_id = 1; // Replace with user auth id when using auth middleware
            $orders =   Order::JoinOrderItems()
                ->JoinProducts()
                ->select('name', 'ot.price', 'products.name', 'description', 'type', 'ot.id',
                    DB::raw('(CASE
               WHEN type = 1 THEN "Connectivity"
               WHEN type = 2 THEN "Security"
               WHEN type = 3 THEN "DNS"
               WHEN type = 4 THEN "Hosting"
               ELSE "" END) AS type'))
                ->whereNotNull('ot.id')
                ->where('customer_id', $user_id)
                ->get();

            $ord['cost'] = [number_format($orders->sum('price'), 2, ',', ' ')];
            $ord['data'] = $orders;
            return [$ord];
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|int',
            'item' => 'required|array'
        ]);

        if ($validator->fails()) {
            return  response()->json(['error' => $validator->errors()], 422);
        }
        try {
            $customer_id = $request->customer_id;
            $order = Order::updateOrCreate(['customer_id' => (int)$customer_id,'status' => 1]);
            $this->orderId = (int)$order->id;
            $this->customer_id = (int)$customer_id;

            //get client orders
            $collection = collect((array)$request->item);
            $this->collect_qty = $collection;

            $keys = $collection
                ->keys();

            //Get keys
            $pords = $keys->values()
                ->all();

            //retrieve all products where product names equal to $keys
            $prod = Product::Product($pords)
                ->SelectProduct(['name', 'id', 'rental_price as price'])
                ->get();

            // build array
            $collection = collect($prod);
            $preparedOrders = $collection->map(function ($item, $key) {
                return [
                    'price' => (int)$item->price,
                    'product_id' => (int)$item->id,
                    'order_id' => (int)$this->orderId,
                    // retrieve  qty from original request array
                    'quantity' => (int)$this->collect_qty[$item->name]['qty'],
                    'created_at' => Carbon::now()->toDateTimeString()
                ];
            });

            // convert to array for insert
            $row_array = $preparedOrders->toArray();
            if (OrderItem::upsert($row_array, ['product_id', 'order_id'], ['price'])) {
                return response()->json(['success' => ''], 201);
            } else {
                return response()->json(['error' => 'Unable to process request'], 422);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 422);
        }
    }
}
