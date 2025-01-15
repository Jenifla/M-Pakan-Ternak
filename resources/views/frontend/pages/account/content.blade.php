@extends('frontend.pages.account.account')

@section('title','Akun User || Dashboard')

@section('account-content')
<div >
<div >
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Halo {{ Auth::user()->name }}</h3>
        </div>
        <div class="card-body">
            <p>
                Dari dashboard akun Anda, Anda dapat dengan mudah memeriksa &amp; melihat <a href="#">pesanan terkini</a>,<br />
                mengelola <a href="#">alamat pengiriman</a> dan <a href="#">mengedit kata sandi dan detail akun Anda.</a>
            </p>

            
        </div>
    </div>
</div>
</div>
@endsection