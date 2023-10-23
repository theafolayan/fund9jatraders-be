<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOne extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    // credted function

    public static function boot()
    {
        // assign to order if there's an order without product one

        parent::boot();

        static::created(function ($productOne) {

            $order = Order::where('product_type', 'ONE')->whereNull('breached_at')->whereNull('product_id')->first();
            if ($order) {
                $productOne->order_id = $order->id;
                $productOne->save();
                // notify user
                $user = $order->user;
            }
        });
    }


    public function markAsBreached()
    {
        $this->status = "breached";
        $this->breached_at = now();
        $this->save();
    }

    public function markasPassed()
    {
        $this->status = "passed";
        $this->passed_at = now();
        $this->save();
    }
}
