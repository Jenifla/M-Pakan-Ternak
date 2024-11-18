<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=['title','summary','slug','description','photo','quote','added_by','status'];



    public function author_info(){
        return $this->hasOne('App\User','id','added_by');
    }
    public static function getAllPost(){
        return Post::with(['author_info'])->orderBy('id','DESC')->paginate(10);
    }
    // public function get_comments(){
    //     return $this->hasMany('App\Models\PostComment','post_id','id');
    // }
    public static function getPostBySlug($slug){
        return Post::with(['author_info'])->where('slug',$slug)->where('status','active')->first();
    }

    // public function comments(){
    //     return $this->hasMany(PostComment::class)->whereNull('parent_id')->where('status','active')->with('user_info')->orderBy('id','DESC');
    // }
    // public function allComments(){
    //     return $this->hasMany(PostComment::class)->where('status','active');
    // }


    // public static function getProductByCat($slug){
    //     // dd($slug);
    //     return Category::with('products')->where('slug',$slug)->first();
    //     // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    // }

    

    public static function countActivePost(){
        $data=Post::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
