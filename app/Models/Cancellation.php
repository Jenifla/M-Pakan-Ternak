<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cancellation extends Model
{
    protected $fillable=['order_id','user_id','status_pembatalan','tgl_diajukan','tgl_diproses','alasan'];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function refund()
    {
        return $this->hasOne(Refund::class); // Relasi satu ke satu dengan Refund
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
