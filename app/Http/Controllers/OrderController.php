<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Settings\PlatformSettings;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, $type, PlatformSettings $settings)
    {
        // create an order

        $order =  Order::create([
            'user_id' => auth()->user()->id,
            'product_type' => $type == 1 ? 'ONE' : ($type == 2 ? 'TWO' : 'THREE'),
            'phase' => 1,
            'cost' => $type ==  1 ? $settings->product_one_price : ($type == 2 ? $settings->product_two_price : $settings->product_three_price),
        ]);


        // assign a product to the order

        if ($type == 1) {
            $order->products()->create([
                'user_id' => auth()->user()->id,
                'status' => 'active',
                // 'cost' => 100,
            ]);
        }



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
