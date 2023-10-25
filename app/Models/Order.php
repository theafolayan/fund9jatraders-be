<?php

namespace App\Models;

use App\Notifications\AccountPromotionNotification;
use App\Notifications\BreachedAccountNotification;
use App\Notifications\ProductLowStockNotification;
use App\Settings\PlatformSettings;
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
            return $this->productOnes()->get();
        }
        if ($this->product_type == "TWO") {
            return $this->productTwos()->get();
        }
        if ($this->product_type == "THREE") {
            return $this->productThrees()->get();
        }
    }

    public function getLastAssignedAttribute()
    {
        if ($this->product_type == "ONE") {
            return $this->productOnes()->where('status', 'active')->latest('purchased_at')->first();
        }
        if ($this->product_type == "TWO") {
            return $this->productTwos()->where('status', 'active')->latest('purchased_at')->first();
        }
        if ($this->product_type == "THREE") {
            return $this->productThrees()->where('status', 'active')->latest('purchased_at')->first();
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
            $this->update(['phase' => $this->phase + 1]);
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
            $product = $this->phase < 3 ? ProductOne::where('order_id', null)->where('mode', 'demo')->where('status', 'inactive')->first() : ProductOne::where('order_id', null)->where('mode', 'real')->where('status', 'inactive')->first();

            $productCount = $this->phase < 3 ? ProductOne::where('order_id', null)->where('mode', 'demo')->where('status', 'inactive')->count() : ProductOne::where('order_id', null)->where('mode', 'real')->where('status', 'inactive')->count();

            if ($productCount < 10) {
                // notify admin
                $admin = User::where('role', 'admin')->first();
                $admin->notify(new ProductLowStockNotification($productCount, app(PlatformSettings::class)->product_one_title));
            }


            // dd($product);
            if (!$product) {
                $this->product_id = null;
                $this->save();
                return false;
            }
            $product->order_id = $this->id;
            $product->user_id = $this->user_id;
            $product->is_assigned = !$this->phase == 3;
            $product->status = 'active';
            $product->purchased_at = now();

            $product->save();
            $this->product_id = $product->id;

            $this->save();

            // notify user
            $this->user->notify(new AccountPromotionNotification($product, $this, $last_assigned->account_number));
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
    }

    public function markAsBreached()
    {



        // check assigned product
        $product = $this->last_assigned;
        // $product->order->user->notify(new BreachedAccountNotification($product));
        if ($product) {
            $product->markAsBreached();
            $product->order->user->notify(new BreachedAccountNotification($product));
        }
        $this->update([
            "breached_at" => now(),
            'product_id' => null
        ]);
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
