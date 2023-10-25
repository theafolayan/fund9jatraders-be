<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Models\ProductOne;
use App\Models\ProductThree;
use App\Models\ProductTwo;
use App\Models\User;
use App\Notifications\ProductLowStockNotification;
use App\Notifications\ProductPurchaseNotification;
use App\Settings\PlatformSettings;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $orders = $user->orders()->get();

        return response()->json([
            'orders' => $orders,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, $type, PlatformSettings $settings)
    {

        // return response()->json([
        //     'type' => $type,
        // ]);
        // create an order


        $order =  Order::create([
            'user_id' => auth()->user()->id,
            'product_type' => $type == "one" ? 'ONE' : ($type == 'two' ? 'TWO' : 'THREE'),
            'phase' => 1,
            'cost' => $type ==  "one" ? $settings->product_one_price : ($type == "two" ? $settings->product_two_price : $settings->product_three_price),
        ]);


        // assign a product to the order

        if (true) {
            // check for available product one
            $product = ProductOne::where('order_id', null)->where('mode', 'demo')->where('status', 'inactive')->first();

            $productCount = ProductOne::where('order_id', null)->where('mode', 'demo')->where('status', 'inactive')->count();

            // check if product count is less than 10 and if it is, alert the admin

            if ($productCount < 10) {
                // notify admin
                $admin = User::where('role', 'admin')->first();
                $admin->notify(new ProductLowStockNotification($productCount, app(PlatformSettings::class)->product_one_title));
            }

            if (!$product) {
                return response()->json([
                    'message' => 'No available product, a product will be assigned to you as soon as there is one available',
                ], 400);
            }

            $product->order_id = $order->id;
            $product->user_id = auth()->user()->id;
            $product->save();

            $order->product_id = $product->id;
            $product->status = 'active';
            $product->purchased_at = now();
            $product->save();
            $order->save();

            auth()->user()->notify(new ProductPurchaseNotification($product, $order));


            return response()->json([
                'message' => 'Product assigned successfully',
                'product' => $product,
            ], 201);
        }

        // if ($type == 'two') {

        //     // check for available product one
        //     $product = ProductTwo::where('order_id', null)->first();

        //     if (!$product) {
        //         return response()->json([
        //             'message' => 'No available product',
        //         ], 400);
        //     }

        //     $product->order_id = $order->id;
        //     $product->user_id = auth()->user()->id;
        //     $product->save();

        //     $order->product_id = $product->id;
        //     $order->save();

        //     return response()->json([
        //         'message' => 'Product assigned successfully',
        //         'product' => $product,
        //     ], 201);
        // }

        // if ($type == 'three') {

        //     // check for available product one
        //     $product = ProductThree::where('order_id', null)->first();

        //     if (!$product) {
        //         return response()->json([
        //             'message' => 'No available product',
        //         ], 400);
        //     }

        //     $product->order_id = $order->id;
        //     $product->user_id = auth()->user()->id;
        //     $product->save();

        //     $order->product_id = $product->id;
        //     $order->save();

        //     return response()->json([
        //         'message' => 'Product assigned successfully',
        //         'product' => $product,
        //     ], 201);
        // }



        // assign a user to the order

        // return the order

        // return the product
    }


    public function assignProduct($tier)
    {
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
