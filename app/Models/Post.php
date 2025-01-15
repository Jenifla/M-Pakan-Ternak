<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=['title','summary','slug','description','photo','quote','added_by','status'];



    public function author_info(){
        return $this->hasOne('App\User','id','added_by');
    }
    public static function getAllPost($search = null)
    {
        $query = Post::with(['author_info'])->orderBy('id', 'DESC');
        
        // Jika ada parameter pencarian, tambahkan filter pencarian ke query
        if (!empty($search)) {
            $query->where('title', 'like', "%$search%");
        }

        return $query->paginate(10)->appends(['search' => $search]);
    }

    public static function getPostBySlug($slug){
        return Post::with(['author_info'])->where('slug',$slug)->where('status','active')->first();
    }

    public static function countActivePost(){
        $data=Post::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
