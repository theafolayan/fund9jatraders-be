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
            return $this->hasOne(ProductOne::class);
        }
        if ($this->product_type == "TWO") {
            return $this->hasOne(ProductTwo::class);
        }
        if ($this->product_type == "THREE") {
            return $this->hasOne(ProductThree::class);
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
