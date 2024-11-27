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
                                        {{-- <div class="form-footer">
                                            <div class="checkbox">
                                                <label class="checkbox-inline" for="remember">
                                                    <input name="remember" id="remember" type="checkbox">Remember me
                                                </label>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <a class="lost-pass" href="{{ route('password.reset') }}">Lost your password?</a>
                                            @endif
                                        </div> --}}
                                    </div>
                                    
                                </div>
                                <div class="col-12">
                                    <div class="form-group login-btn">
                                        <button class="btn btn-facebook" type="submit">Login</button>
                                        {{-- <a href="{{route('register.form')}}" class="btn">Register</a> --}}
                                        <p class="register-text">Tidak punya akun? <a href="{{route('register.form')}}" class="btn-register-link">Register</a></p>
                                        <!-- OR
                                        <a href="{{route('login.redirect','facebook')}}" class="btn btn-facebook"><i class="ti-facebook"></i></a>
                                        <a href="{{route('login.redirect','github')}}" class="btn btn-github"><i class="ti-github"></i></a>
                                        <a href="{{route('login.redirect','google')}}" class="btn btn-google"><i class="ti-google"></i></a> -->

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

    {{-- <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        document.getElementById('login-form').addEventListener('submit', function(e) {
            e.preventDefault();

            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;
            let remember = document.getElementById('remember').checked;

            axios.post('/api/auth/login', {
                email: email,
                password: password
            })
            .then(function (response) {
                // Simpan JWT Token ke localStorage
                localStorage.setItem('token', response.data.token);
                
                // Redirect ke halaman home setelah login berhasil
                window.location.href = "{{ route('home') }}";
            })
            .catch(function (error) {
                if (error.response) {
                    // Handle errors
                    if (error.response.status === 401) {
                        document.getElementById('email-error').innerText = 'Invalid email or password';
                    } else {
                        document.getElementById('email-error').innerText = '';
                        document.getElementById('password-error').innerText = '';
                    }
                }
            });
        });
    </script> --}}
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