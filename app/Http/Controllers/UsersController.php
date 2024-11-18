<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::orderBy('id','ASC')->paginate(10);
        return view('backend.users.index')->with('users',$users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'email'=>'string|required|unique:users',
            'password'=>'string|required',
            'no_hp'=>'string|nullable|max:15',
            'role'=>'required|in:admin,user',
            'status'=>'required|in:active,inactive',
            'photo'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // dd($request->all());
        $data=$request->all();
        if ($request->hasFile('photo')) {
            // Ambil file foto yang diupload
            $photo = $request->file('photo');
            
            // Tentukan path tujuan untuk menyimpan foto
            $destinationPath = public_path('images');
            
            // Buat nama file yang unik
            $fileName = time() . '_' . $photo->getClientOriginalName();
            
            // Pindahkan file ke folder public/category/
            $photo->move($destinationPath, $fileName);
            
            // Simpan path relatif dari foto ke dalam data
            $data['photo'] = 'images' . $fileName;
        }
        $data['password']=Hash::make($request->password);
        // dd($data);
        $status=User::create($data);
        // dd($status);
        if($status){
            request()->session()->flash('success','User added successfully');
        }
        else{
            request()->session()->flash('error','Error occurred while adding user');
        }
        return redirect()->route('users.index');

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
        $user=User::findOrFail($id);
        return view('backend.users.edit')->with('user',$user);
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
        $user=User::findOrFail($id);
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'email'=>'string|required',
            'no_hp'=>'string|nullable|max:15',
            'role'=>'required|in:admin,user',
            'status'=>'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        if ($request->hasFile('photo')) {
            // Ambil file foto yang diupload
            $photo = $request->file('photo');
            
            // Tentukan path tujuan untuk menyimpan foto
            $destinationPath = public_path('images');
            
            // Buat nama file yang unik
            $fileName = time() . '_' . $photo->getClientOriginalName();
            
            // Pindahkan file ke folder public/category/
            $photo->move($destinationPath, $fileName);
            
            // Simpan path relatif dari foto ke dalam data
            $data['photo'] = 'images' . $fileName;
        }else {
            // Jika tidak ada file gambar yang diunggah, gunakan gambar  yang lama
            $data['photo'] = $user->photo;
        }
        
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated');
        }
        else{
            request()->session()->flash('error','Error occured while updating');
        }
        return redirect()->route('users.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete=User::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('success','User deleted successfully');
        }
        else{
            request()->session()->flash('error','There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
