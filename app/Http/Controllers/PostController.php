<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts=Post::getAllPost();
        // return $posts;
        return view('backend.post.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $users=User::get();
        return view('backend.post.create')->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'required|string',
            'quote'=>'string|nullable',
            'summary'=>'nullable|string',
            'description'=>'required|string',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'added_by'=>'nullable',
            'status'=>'required|in:active,inactive'
        ]);

        $data=$request->all();
        if ($request->hasFile('photo')) {
            // Ambil file foto yang diupload
            $photo = $request->file('photo');
            
            // Tentukan path tujuan untuk menyimpan foto
            $destinationPath = public_path('images/blog');
            
            // Buat nama file yang unik
            $fileName = time() . '_' . $photo->getClientOriginalName();
            
            // Pindahkan file ke folder public/category/
            $photo->move($destinationPath, $fileName);
            
            // Simpan path relatif dari foto ke dalam data
            $data['photo'] = 'images/blog/' . $fileName;
        }

        $slug=Str::slug($request->title);
        $count=Post::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $data;

        $status=Post::create($data);
        if($status){
            request()->session()->flash('success','Post added');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('post.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post=Post::findOrFail($id);
        $users=User::get();
        return view('backend.post.edit')->with('users',$users)->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post=Post::findOrFail($id);
         // return $request->all();
         $this->validate($request,[
            'title'=>'required|string',
            'quote'=>'string|nullable',
            'summary'=>'nullable|string',
            'description'=>'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'added_by'=>'nullable',
            'status'=>'required|in:active,inactive'
        ]);

        $data=$request->all();
        // return $data;

        if ($request->hasFile('photo')) {
            // Ambil file foto yang diupload
            $photo = $request->file('photo');
            
            // Tentukan path tujuan untuk menyimpan foto
            $destinationPath = public_path('images/blog');
            
            // Buat nama file yang unik
            $fileName = time() . '_' . $photo->getClientOriginalName();
            
            // Pindahkan file ke folder public/category/
            $photo->move($destinationPath, $fileName);
            
            // Simpan path relatif dari foto ke dalam data
            $data['photo'] = 'images/blog/' . $fileName;
        }else {
            // Jika tidak ada file gambar yang diunggah, gunakan gambar  yang lama
            $data['photo'] = $post->photo;
        }

        $status=$post->fill($data)->save();
        if($status){
            request()->session()->flash('success','Post updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('post.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::findOrFail($id);
       
        $status=$post->delete();
        
        if($status){
            request()->session()->flash('success','Post deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting post ');
        }
        return redirect()->route('post.index');
    }
}
