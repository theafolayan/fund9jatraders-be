<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAvailableProducts()
    {

        $productOne = \App\Models\ProductOne::where('status', 'inactive')->get();
        $productTwo = \App\Models\ProductTwo::where('status', 'inactive')->get();
        $productThree = \App\Models\ProductThree::where('status', 'inactive')->get();

        return response()->json([
            'product_one' => $productOne,
            'product_two' => $productTwo,
            'product_three' => $productThree,
        ], 200);
    }
}
