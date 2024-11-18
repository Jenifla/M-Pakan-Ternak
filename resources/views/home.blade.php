@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div id="login-status" class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Jika ada pesan dari URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const message = urlParams.get('message');
    if (message) {
        const loginStatus = document.getElementById('login-status');
        loginStatus.innerText = message;
        loginStatus.style.display = 'block';
    }
</script>
{{-- <script>
    let token = localStorage.getItem('access_token');
    if (token) {
        // Buat request ke backend untuk cek token
        fetch('/api/user', {
            method: 'GET',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data) {
                document.getElementById('login-status').innerHTML = '<p>You are logged in!</p>';
            }
        })
        .catch(error => {
            console.log('Error:', error);
        });
    } else {
        document.getElementById('login-status').innerHTML = '<p>You are not logged in.</p>';
    }
</script> --}}

@endsection
