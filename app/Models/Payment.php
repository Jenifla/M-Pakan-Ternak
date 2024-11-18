<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    protected $fillable=['order_id','user_id', 'method_payment','total_bayar','date_payment','status'];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
