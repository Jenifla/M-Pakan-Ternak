<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable=['user_id','full_nama','no_hp','provinsi','kabupaten','kecamatan','kelurahan','detail_alamat','kode_pos','jenis_alamat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class); // Address memiliki banyak Order
    }
   
}
