<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

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
            return ProductOne::where('order_id', $this->id)->latest()->first();
        }
        if ($this->product_type == "TWO") {
            return ProductTwo::where('order_id', $this->id)->latest()->first();
        }
        if ($this->product_type == "THREE") {
            return ProductThree::where('order_id', $this->id)->latest()->first();
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
        $this->phase = $this->phase + 1;
        $this->save();
    }

    public function markAsBreached()
    {
        $this->breached_at = now();
        $this->save();


        // mark latest product as breached
        $this->products->last()->markAsBreached();
    }

    public function isBreached()
    {
        return $this->breached_at != null;
    }
}
