<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category=Category::getAllCategory($search);
        // return $category;
        return view('backend.category.index')->with('categories',$category);
    }

    public function getCategories()
    {
        $categories = Category::with('parent_info')->get(); // Pastikan Anda mengambil relasi parent_info
        return response()->json($categories);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_cats=Category::where('is_parent',1)->orderBy('title','ASC')->get();
        return view('backend.category.create')->with('parent_cats',$parent_cats);
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
            'photo'=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status'=>'required|in:active,inactive',
            'is_parent'=>'sometimes|in:1',
            'parent_id'=>'nullable|exists:categories,id',
        ]);
        $data= $request->all();
        if ($request->hasFile('photo')) {
            // Ambil file foto yang diupload
            $photo = $request->file('photo');
            
            // Tentukan path tujuan untuk menyimpan foto
            $destinationPath = public_path('images/category');
            
            // Buat nama file yang unik
            $fileName = time() . '_' . $photo->getClientOriginalName();
            
            // Pindahkan file ke folder public/category/
            $photo->move($destinationPath, $fileName);
            
            // Simpan path relatif dari foto ke dalam data
            $data['photo'] = 'images/category/' . $fileName;
        }
        $slug=Str::slug($request->title);
        $count=Category::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $data['is_parent']=$request->input('is_parent',0);
        // return $data;   
        $status=Category::create($data);
        if($status){
            request()->session()->flash('success','Category added successfully');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('category.index');


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
        $parent_cats=Category::where('is_parent',1)->get();
        $category=Category::findOrFail($id);
        return view('backend.category.edit')->with('category',$category)->with('parent_cats',$parent_cats);
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
        // Mencari kategori berdasarkan ID
        $category = Category::findOrFail($id);

        // Validasi input
        $this->validate($request, [
            'title' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:active,inactive',
            'is_parent' => 'sometimes|in:1',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        // Ambil semua data dari request
        $data = $request->all();

        // Tentukan nilai 'is_parent' jika ada
        $data['is_parent'] = $request->input('is_parent', 0);

        // Jika ada foto baru yang diupload, simpan foto baru
        if ($request->hasFile('photo')) {
            // Ambil file foto yang diupload
            $photo = $request->file('photo');
            
            // Tentukan path tujuan untuk menyimpan foto
            $destinationPath = public_path('images/category');
            
            // Buat nama file yang unik
            $fileName = time() . '_' . $photo->getClientOriginalName();
            
            // Pindahkan file ke folder public/category/
            $photo->move($destinationPath, $fileName);
            
            // Simpan path relatif dari foto ke dalam data
            $data['photo'] = 'images/category/' . $fileName;
        }else {
            // Jika tidak ada file gambar yang diunggah, gunakan gambar  yang lama
            $data['photo'] = $category->photo;
        }

        // Update data kategori
        $status = $category->fill($data)->save();

        // Menampilkan pesan sukses atau error
        if ($status) {
            request()->session()->flash('success', 'Category updated successfully');
        } else {
            request()->session()->flash('error', 'Error occurred, Please try again!');
        }

        // Redirect ke halaman index kategori
        return redirect()->route('category.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $child_cat_id=Category::where('parent_id',$id)->pluck('id');
        // return $child_cat_id;
        $status=$category->delete();
        
        if($status){
            if(count($child_cat_id)>0){
                Category::shiftChild($child_cat_id);
            }
            request()->session()->flash('success','Category deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting category');
        }
        return redirect()->route('category.index');
    }

    public function getChildByParent(Request $request){
        // return $request->all();
        $category=Category::findOrFail($request->id);
        $child_cat=Category::getChildByParentID($request->id);
        // return $child_cat;
        if(count($child_cat)<=0){
            return response()->json(['status'=>false,'msg'=>'','data'=>null]);
        }
        else{
            return response()->json(['status'=>true,'msg'=>'','data'=>$child_cat]);
        }
    }
}
