<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cart;
class Product extends Model
{
    protected $fillable=['title','slug','summary','description','cat_id','child_cat_id','price','weight','discount','status','stock','condition'];

    public function gambarProduk()
    {
        return $this->hasMany(ProductImg::class, 'product_id');
    }

    public function cat_info(){
        return $this->hasOne('App\Models\Category','id','cat_id');
    }
    public function sub_cat_info(){
        return $this->hasOne('App\Models\Category','id','child_cat_id');
    }
    
    public static function getAllProduct($search = null) {
        $query = Product::with(['cat_info', 'sub_cat_info', 'gambarProduk'])->orderBy('id', 'desc');
        
        if (!empty($search)) {
            $query->where('title', 'like', '%' . $search . '%') // Pencarian berdasarkan judul produk
                  ->orWhere('condition', 'like', '%' . $search . '%') // Pencarian berdasarkan deskripsi produk
                  ->orWhere('description', 'like', '%' . $search . '%') // Pencarian berdasarkan deskripsi produk
                  ->orWhereHas('cat_info', function ($q) use ($search) {
                      $q->where('title', 'like', '%' . $search . '%'); // Pencarian pada kategori utama
                  })
                  ->orWhereHas('sub_cat_info', function ($q) use ($search) {
                      $q->where('title', 'like', '%' . $search . '%'); // Pencarian pada subkategori
                  });
        }
    
        return $query->paginate(10)->appends(['search' => $search]);
    }
    
    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    }
    
    public static function getProductBySlug($slug){
        return Product::with(['cat_info','rel_prods', 'gambarProduk'])->where('slug',$slug)->first();
    }
    public static function countActiveProduct(){
        $data=Product::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    public function carts(){
        return $this->hasMany(Cart::class)->whereNotNull('order_id');
    }


}
