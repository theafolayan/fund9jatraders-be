<?php

namespace App\Models;

use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'breached_at' => 'datetime',
    ];
    protected $fillables = [
        'user_id',
        'product_type',
        'product_id',
        'cost',
        'phase',
        'breached_at',
    ];

    public function isActive()
    {
        return !$this->isBreached();
    }

    public function getAllProductsAttribute()
    {
        if ($this->product_type == "ONE") {
            return ProductOne::where('order_id', $this->id)->get();
        }
        if ($this->product_type == "TWO") {
            return ProductTwo::where('order_id', $this->id)->get();
        }
        if ($this->product_type == "THREE") {
            return ProductThree::where('order_id', $this->id)->get();
        }
    }

    public function getLastAssignedAttribute()
    {
        if ($this->product_type == "ONE") {
            return ProductOne::where('order_id', $this->id)->where('status', 'active')->latest()->first();
        }
        if ($this->product_type == "TWO") {
            return ProductTwo::where('order_id', $this->id)->where('status', 'active')->latest()->first();
        }
        if ($this->product_type == "THREE") {
            return ProductThree::where('order_id', $this->id)->where('status', 'active')->latest()->first();
        }
    }

    public $appends = ['all_products', 'last_assigned'];

    public function products()
    {
        if ($this->product_type == "ONE") {
            return $this->hasMany(ProductOne::class);
        }
        if ($this->product_type == "TWO") {
            return $this->hasMany(ProductTwo::class);
        }
        if ($this->product_type == "THREE") {
            return $this->hasMany(ProductThree::class);
        }
    }



    public function product()
    {

        if ($this->product_type == "ONE") {
            return $this->hasMany(ProductOne::class);
        }
        if ($this->product_type == "TWO") {
            return $this->hasMany(ProductTwo::class);
        }
        if ($this->product_type == "THREE") {
            return $this->hasMany(ProductThree::class);
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    function getPhase()
    {
        return count($this->products);
    }

    public function promote()
    {


        $last_assigned = $this->last_assigned;
        if ($last_assigned) {
            $last_assigned->markasPassed();
        }

        // assign another product

        function getProductType($order)
        {
            if ($order->phase < 3) {
                return 'demo';
            } else {
                return 'real';
            }
        }


        $type = $this->product_type;
        if ($type == "ONE") {
            $product = $this->phase < 2 ? ProductOne::where('order_id', null)->where('mode', 'demo')->where('status', 'inactive')->first() : ProductOne::where('order_id', null)->where('mode', 'real')->where('status', 'inactive')->first();

            // dd($product);
            if (!$product) {
                return false;
            }
            $product->order_id = $this->id;
            $product->user_id = $this->user_id;
            $product->status = 'active';
            $product->save();
            $this->product_id = $product->id;

            $this->save();
        } else if ($type == "TWO") {
            $product = ProductTwo::where('order_id', null)->first();
            if (!$product) {
                return Notification::make()->title('No available product, please add an account manually')->error()->send();
            }
            $product->order_id = $this->id;
            $product->user_id = $this->user_id;
            $product->status = 'active';

            $product->save();
            $this->product_id = $product->id;
            $this->save();
        } else {
            $product = ProductThree::where('order_id', null)->first();
            if (!$product) {
                return Notification::make()->title('No available product, please add an account manually')->error()->send();
            }
            $product->order_id = $this->id;
            $product->user_id = $this->user_id;
            $product->status = 'active';

            $product->save();
            $this->product_id = $product->id;
            $this->save();
        }

        return $this->update([
            "phase" => $this->phase + 1,
        ]);
    }

    public function markAsBreached()
    {

        $this->update([
            "breached_at" => now(),
        ]);

        // check assigned product
        $product = $this->last_assigned;
        if ($product) {
            $product->markAsBreached();
        }
    }

    public function isBreached()
    {
        return $this->breached_at != null;
    }

    public function productOnes()
    {
        return $this->hasMany(ProductOne::class);
    }

    public function productTwos()
    {
        return $this->hasMany(ProductTwo::class);
    }

    public function productThrees()
    {
        return $this->hasMany(ProductThree::class);
    }
}
