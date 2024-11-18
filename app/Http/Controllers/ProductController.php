<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::getAllProduct();
        // return $products;
        return view('backend.product.index')->with('products',$products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $category=Category::where('is_parent',1)->get();
        // return $category;
        return view('backend.product.create')->with('categories',$category);
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
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photos' => 'required|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'weight'=>'required|numeric',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,best seller',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        $data=$request->all();
        $slug=Str::slug($request->title);
        $count=Product::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // dd($data);
        $product=Product::create($data);
        if ($product) {
    

            // Simpan gambar produk jika ada
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $file) {
                    // Buat nama file unik untuk setiap gambar
                    $filename = time() . '_' . $file->getClientOriginalName();
                    
                    // Tentukan path tujuan untuk menyimpan gambar
                    $destinationPath = public_path('images');
                    
                    // Pindahkan file ke folder public/images/
                    $file->move($destinationPath, $filename);
                    
                    // Buat entri di tabel product_imgs dengan path yang benar
                    $product->gambarProduk()->create([
                        'product_id' => $product->id,
                        'gambar' => 'images/' . $filename // Menyimpan path relatif dari gambar
                    ]);
                }
            }
            
            
            request()->session()->flash('success', 'Product added');
        } else {
            request()->session()->flash('error', 'Please try again!!');
        }
    
        return redirect()->route('product.index');

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
        
        $product=Product::findOrFail($id);
        $category=Category::where('is_parent',1)->get();
        $items=Product::where('id',$id)->get();
        // return $items;
        return view('backend.product.edit')->with('product',$product)
                    ->with('categories',$category)->with('items',$items);
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
        $product=Product::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'photo'=>'array|nullable',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'stock'=>"required|numeric",
            'cat_id'=>'required|exists:categories,id',
            'child_cat_id'=>'nullable|exists:categories,id',
            'weight'=>'required|numeric',
            'status'=>'required|in:active,inactive',
            'condition'=>'required|in:default,new,best seller',
            'price'=>'required|numeric',
            'discount'=>'nullable|numeric'
        ]);

        $data=$request->all();
        $data['is_featured']=$request->input('is_featured',0);
        
        // return $data;
        $status=$product->fill($data)->save();

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $file) {
                $filename = time() . '_' . $file->getClientOriginalName();
                $destinationPath = public_path('images');
                $file->move($destinationPath, $filename);
    
                // Hapus gambar lama
                foreach ($product->gambarProduk as $image) {
                    $oldImagePath = public_path($image->gambar);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                    $image->delete();
                }
    
                // Simpan gambar baru
                $product->gambarProduk()->create([
                    'product_id' => $product->id,
                    'gambar' => 'images/' . $filename
                ]);
            }
        }
        
        if($status){
            request()->session()->flash('success','Product updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $status=$product->delete();
        
        if($status){
            request()->session()->flash('success','Product deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('product.index');
    }
}
