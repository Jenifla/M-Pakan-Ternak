<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable=['order_id','cancellation_id','total_refund','bank_name','bank_account','bank_holder', 'bukti_transfer', 'date_transfer', 'status'];

    public function order()
    {
        return $this->belongsTo(Order::class); // Relasi satu ke satu dengan Order
    }

    public function cancellation()
    {
        return $this->belongsTo(Cancellation::class); // Relasi satu ke satu dengan Cancellation
    }
}
