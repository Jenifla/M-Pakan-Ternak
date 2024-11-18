<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable=['title','slug','description','photo','status'];

    public static function getAllBanner(){
        return  Banner::orderBy('id','DESC')->paginate(10);
    }
}
