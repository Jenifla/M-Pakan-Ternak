<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable=['user_id','address_id','order_number','ongkir','status','total_amount','date_order','date_packed','date_sent','date_cancel','alasan','shipping_id'];

    public function cart_info(){
        return $this->hasMany('App\Models\Cart','order_id','id');
    }
    public static function getAllOrder($id){
        return Order::with('cart_info')->find($id);
    }
    public static function countActiveOrder(){
        $data=Order::count();
        if($data){
            return $data;
        }
        return 0;
    }
    // public function cart(){
    //     return $this->hasMany(Cart::class);
    // }
    // Order.php
    public function cart()
    {
        return $this->hasMany(Cart::class, 'order_id');
    }


    public function shipping(){
        return $this->belongsTo(Shipping::class,'shipping_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class,'address_id'); // Order milik satu Address
    }

    // Relasi Order ke Payment (One to One)
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function cancel()
    {
        return $this->hasOne(Cancellation::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public static function countNewReceivedOrder(){
        $data = Order::where('status', 'new')->count();
        return $data;
    }
    public static function countProcessingOrder(){
        $data = Order::where('status', 'process')->count();
        return $data;
    }
    public static function countDeliveredOrder(){
        $data = Order::where('status', 'delivered')->count();
        return $data;
    }
    public static function countCancelledOrder(){
        $data = Order::where('status', 'cancel')->count();
        return $data;
    }
    

}
