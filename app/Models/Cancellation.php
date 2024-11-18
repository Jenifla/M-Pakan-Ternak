<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{
    protected $fillable=['order_id','user_id','status_pembatalan','tgl_diajukan','tgl_diproses','alasan'];

    public function order()
    {
        return $this->belongsTo(Order::class,'order_id');
    }
}
