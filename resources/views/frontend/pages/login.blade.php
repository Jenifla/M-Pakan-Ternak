@extends('frontend.layouts.master')

@section('title','PT. Agro Apis Palacio || Login Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Login</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
            
    <!-- Shop Login -->
    <section class="shop login section">
        <div class="container">
            <div class="row"> 
                <div class="col-lg-6 offset-lg-3 col-12">
                    <div class="login-form">
                        <h2>Login</h2>
                        <!-- Form -->
                        <form class="form" id="login-form" method="post" action="{{route('login.submit')}}"> 
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Email<span>*</span></label>
                                        <input type="email" name="email" id="email" placeholder="" required="required" value="{{old('email')}}">
                                        @error('email')
                                            <span class="text-danger" id="email-error">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Password<span>*</span></label>
                                        <input type="password" name="password" id="password" placeholder="" required="required" value="{{old('password')}}">
                                        @error('password')
                                            <span class="text-danger" id="password-error">{{$message}}</span>
                                        @enderror
                                    </div>
                                    
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn btn-facebook" type="submit">Login</button>
 
                                        <p class="register-text">Tidak punya akun? <a href="{{route('register.form')}}" class="btn-register-link">Register</a></p>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                        <!--/ End Form -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Login -->

    
@endsection
@push('styles')
<style>
    .shop.login .form .btn{
        margin-right:0;
        
    }
    .register-text{
        margin-top: 10px;
    }
    .register-text .btn-register-link{
        color:#ffa800;
    }
    .btn-facebook{
        border-radius: 30px;
        background:#ffa800;
        width: 100%;
    }
    .btn-facebook:hover{
        background:#ff2c2b !important;
    }
    .btn-github{
        background:#444444;
        color:white;
    }
    .btn-github:hover{
        background:black !important;
    }
    .btn-google{
        background:#ea4335;
        color:white;
    }
    .btn-google:hover{
        background:rgb(243, 26, 26) !important;
    }
</style>
@endpush