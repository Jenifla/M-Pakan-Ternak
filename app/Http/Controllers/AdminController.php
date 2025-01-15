<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Rules\MatchOldPassword;
use Hash;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;
class AdminController extends Controller
{
    public function index(){
        $data = User::select(\DB::raw("COUNT(*) as count"), \DB::raw("DAYNAME(created_at) as day_name"), \DB::raw("DAY(created_at) as day"))
        ->where('created_at', '>', Carbon::today()->subDay(6))
        ->groupBy('day_name','day')
        ->orderBy('day')
        ->get();
     $array[] = ['Name', 'Number'];
     foreach($data as $key => $value)
     {
       $array[++$key] = [$value->day_name, $value->count];
     }
    //  return $data;
     return view('backend.index')->with('users', json_encode($array));
    }

    public function profile(){
        $profile=Auth()->user();
        // return $profile;
        return view('backend.users.profile')->with('profile',$profile);
    }

    public function profileUpdate(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $this->validate($request,
        [
            'name'=>'string|required|max:30',
            'no_hp'=>'string|nullable|max:15',
            'role'=>'required|in:admin,user',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
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
            $data['photo'] = $user->photo;
        }
        
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated');
        }
        else{
            request()->session()->flash('error','Error occured while updating');
        }
        return redirect()->back();

    }


    public function changePassword(){
        return view('backend.layouts.changePassword');
    }
    public function changPasswordStore(Request $request)
    {
        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'new_confirm_password' => ['same:new_password'],
        ]);
   
        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
   
        return redirect()->route('admin')->with('success','Password successfully changed');
    }

}
