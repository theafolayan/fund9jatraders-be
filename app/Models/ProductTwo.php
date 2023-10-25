<?php

namespace App\Models;

use App\Notifications\ProductPurchaseNotification;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTwo extends Model
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

    public static function boot()
    {
        // assign to order if there's an order without product one

        parent::boot();

        static::created(function ($product) {

            $order = $product->mode == "demo" ? Order::where('product_type', 'TWO')->whereNull('breached_at')->whereNull('product_id')->first() : Order::where('product_type', 'TWO')->whereNull('breached_at')->whereNull('product_id')->where('phase', 3)->first();

            if ($order) {
                $product->order_id = $order->id;
                $product->user_id = auth()->user()->id;
                $product->save();

                $order->product_id = $product->id;
                $product->status = 'active';
                $product->is_assigned = !$order->phase == 3;
                $product->purchased_at = now();
                $product->save();
                $order->save();

                auth()->user()->notify(new ProductPurchaseNotification($product, $order));

                Notification::make()
                    ->success()
                    ->title('Product created and assigned to {$order->user->name}')
                    ->send();
            }

            // if ($order) {
            //     $productOne->order_id = $order->id;
            //     $productOne->save();
            //     // notify user
            //     $user = $order->user;
            // }
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
