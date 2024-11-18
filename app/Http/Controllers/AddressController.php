<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use App\Models\Shipping;


class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $addresses = Address::where('user_id', $userId)->get();
        $address=Address::orderBy('id','DESC')->paginate(10);
        return view('backend.shipping.index')->with('address',$address);
    }

    public function showAddressForm()
    {
        $user = auth()->user(); // Mendapatkan pengguna yang sedang login
        return view('frontend.pages.checkout', compact('user')); // Kirimkan data pengguna ke view
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return view('frontend.pages.account.addaddress');
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        // Validasi input
        $this->validate($request, [
            'full_nama' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'detail_alamat' => 'required|string',
            'kode_pos' => 'required|digits:5',
            'jenis_alamat' => 'in:Rumah,Kantor',
        ]);

        // Cek apakah pengguna sudah memiliki alamat
        $existingAddressCount = Address::where('user_id', $user_id)->count();

       // Menentukan apakah alamat pertama harus default atau tidak
        if ($existingAddressCount == 0) {
            $isDefault = 1; // Alamat pertama yang ditambahkan adalah default
        } else {
            $isDefault = 0; // Alamat selanjutnya non-default
        }

        // Membuat alamat baru menggunakan mass assignment
        $address = new Address;
        $address->user_id = $user_id;
        $address->full_nama = $request->full_nama;
        $address->no_hp = $request->no_hp;
        $address->provinsi = $request->provinsi;
        $address->kabupaten = $request->kabupaten;
        $address->kecamatan = $request->kecamatan;
        $address->kelurahan = $request->kelurahan;
        $address->detail_alamat = $request->detail_alamat;
        $address->kode_pos = $request->kode_pos;
        $address->jenis_alamat = $request->jenis_alamat; // Default 'Rumah' jika tidak ada input
        $address->is_default = $isDefault;
        $addressSaved = $address->save();

        // Menyimpan hasil dan memberikan pesan flash
        if ($addressSaved) {
            request()->session()->flash('success', 'Address created successfully');
        } else {
            request()->session()->flash('error', 'Error, Please try again');
        }

        // Redirect ke halaman daftar alamat
        return redirect()->route('account-address');
    }

    public function setDefaultAddress($id)
    {
        $userId = auth()->user()->id;

        // Set semua alamat milik pengguna menjadi non-default
        Address::where('user_id', $userId)->update(['is_default' => 0]);

        // Set alamat yang dipilih sebagai default
        $address = Address::where('id', $id)->where('user_id', $userId)->first();
        if ($address) {
            $address->is_default = 1;
            $address->save();
            return redirect()->back()->with('success', 'Alamat default berhasil diatur');
        }
        return redirect()->back()->with('error', 'Alamat sudah menjadi default');

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
        $address = Address::find($id);
        if(!$address){
            request()->session()->flash('error','Shipping not found');
        }
        return view('frontend.pages.account.editaddress')->with('address',$address);
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
        $address=Address::find($id);
        $this->validate($request,[
            'full_nama' => 'required|string',
            'no_hp' => 'required|string|max:15',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'detail_alamat' => 'required|string',
            'kode_pos' => 'required|digits:5',
            'jenis_alamat' => 'in:Rumah,Kantor',
        ]);
        $data=$request->all();
        // return $data;
        $status=$address->fill($data)->save();
        if($status){
            request()->session()->flash('success','Address updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('account-address');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address=Address::find($id);
        if($address){
            $status=$address->delete();
            if($status){
                request()->session()->flash('success','Address deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('account-address');
        }
        else{
            request()->session()->flash('error','Address not found');
            return redirect()->back();
        }
    }
}
