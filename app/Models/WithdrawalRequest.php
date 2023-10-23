<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WithdrawalRequest extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function markAsApproved()
    {
        $this->status = "approved";
        $this->approved_at = now();
        $this->save();
    }

    public function markAsDeclined($reason)
    {
        $this->status = "declined";
        $this->declined_at = now();
        $this->save();
    }

    public function markAsPaid()
    {
        $this->status = "paid";
        $this->paid_at = now();
        $this->save();
    }
}
