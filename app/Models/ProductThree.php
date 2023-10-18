<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductThree extends Model
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
