@extends('frontend.pages.account.account')

@section('title','Akun User || Detail Akun')

@section('account-content')
<div >
    <div class="card">
        <div class="card-header">
            <h5>Detail Akun</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('account.update') }}" method="POST" >
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input style="padding: 10px 15px;" class="form-control" name="name" type="text" value="{{ old('name', $user->name) }}" required />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Alamat Email <span class="text-danger">*</span></label>
                        <input style="padding: 10px 15px;" class="form-control" name="email" type="email" value="{{ old('email', $user->email) }}" required />
                    </div>
                    <div class="form-group col-md-12">
                        <label>Nomor Telepon <span class="text-danger">*</span></label>
                        <input style="padding: 10px 15px;" class="form-control" name="no_hp" type="text" value="{{ old('no_hp', $user->no_hp) }}" required/>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Password Baru</label>
                        <input style="padding: 10px 15px;" class="form-control" name="npassword" type="password" placeholder="Kosongkan jika tidak ingin mengubah password"/>
                    </div>
                    <div class="form-group col-md-12">
                        <label>Konfirmasi Password</label>
                        <input style="padding: 10px 15px;" class="form-control" name="npassword_confirmation" type="password" placeholder="Kosongkan jika tidak ingin mengubah password"/>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection