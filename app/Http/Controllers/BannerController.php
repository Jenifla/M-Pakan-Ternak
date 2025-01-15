<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('search'); // Ambil parameter pencarian
        $query = Banner::orderBy('id', 'DESC');

        if (!empty($search)) {
            $query->where('title', 'like', "%$search%"); 
        }

        $banners = $query->paginate(10)->appends(['search' => $search]);

        return view('backend.banner.index', compact('banners', 'search'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
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
            'title'=>'required|string|max:50',
            'description'=>'string|nullable',
            'photo'=>'required|image|mimes:jpeg,png,jpg|max:2048',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        if ($request->hasFile('photo')) {
            // Ambil file foto yang diupload
            $photo = $request->file('photo');
            
            // Tentukan path tujuan untuk menyimpan foto
            $destinationPath = public_path('images/');
            
            // Buat nama file yang unik
            $fileName = time() . '_' . $photo->getClientOriginalName();
            
            // Pindahkan file ke folder public/category/
            $photo->move($destinationPath, $fileName);
            
            // Simpan path relatif dari foto ke dalam data
            $data['photo'] = 'images/' . $fileName;
        }
        $slug=Str::slug($request->title);
        $count=Banner::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $slug;
        $status=Banner::create($data);
        if($status){
            request()->session()->flash('success','Banner has been added successfully');
        }
        else{
            request()->session()->flash('error','Error occurred while adding banner');
        }
        return redirect()->route('banner.index');
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
        $banner=Banner::findOrFail($id);
        return view('backend.banner.edit')->with('banner',$banner);
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
        $banner=Banner::findOrFail($id);
        $this->validate($request,[
            'title'=>'required|string|max:50',
            'description'=>'string|nullable',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status'=>'required|in:active,inactive',
        ]);
        $data=$request->all();
        if ($request->hasFile('photo')) {
            // Ambil file foto yang diupload
            $photo = $request->file('photo');
            
            // Tentukan path tujuan untuk menyimpan foto
            $destinationPath = public_path('images/');
            
            // Buat nama file yang unik
            $fileName = time() . '_' . $photo->getClientOriginalName();
            
            // Pindahkan file ke folder public/category/
            $photo->move($destinationPath, $fileName);
            
            // Simpan path relatif dari foto ke dalam data
            $data['photo'] = 'images/' . $fileName;
        }else {
            // Jika tidak ada file gambar yang diunggah, gunakan gambar  yang lama
            $data['photo'] = $banner->photo;
        }
        $status=$banner->fill($data)->save();
        if($status){
            request()->session()->flash('success','Banner has been updated successfully');
        }
        else{
            request()->session()->flash('error','Error occurred while updating banner');
        }
        return redirect()->route('banner.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner=Banner::findOrFail($id);
        $status=$banner->delete();
        if($status){
            request()->session()->flash('success','Banner has been deleted successfully.');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}
