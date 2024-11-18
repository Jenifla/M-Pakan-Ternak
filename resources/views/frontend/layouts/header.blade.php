<header class="header shop">
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-2">
                    <!-- Mobile Menu Trigger -->
                    {{-- <div class="mobile-nav-trigger">
                        <i class="ti-menu"></i>
                    </div> --}}
                    <div class="menu-area">
                        <!-- Main Menu -->
                        <nav class="navbar navbar-expand-lg">
                            <div class="navbar-collapse">	
                                <div class="nav-inner">	
                                    <ul class="nav main-menu menu navbar-nav">
                                        <li class="{{Request::path()=='' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                                        <li class="{{Request::path()=='product-grids' ? 'active' : ''}}"><a href="{{route('product-grids')}}">Shop</a></li>
                                        
                                        <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Blog</a></li>									
                                           
                                        <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contact Us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                        <!--/ End Main Menu -->	
                    </div>

                    
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-1 col-md-6 col-sm-6 col-6">
                    <!-- Logo -->
                    <div class="logo">
                        @php
                            $settings=DB::table('settings')->get();
                        @endphp                    
                        <a href="{{route('home')}}"><img src="@foreach($settings as $data) {{ asset($data->logo) }} @endforeach" alt="logo"></a>
                    </div>
                    <!--/ End Logo -->
                </div>
                {{-- <div class="col-lg-2 col-md-2 col-12">
                   
                    
                </div> --}}
                <div class="col-lg-5 col-md-2 col-sm-6 col-6">
                    <div class="right-bar">
                        <div class="sinlge-bar search">
                            <div class="search-bar-top">
                                <div class="search-bar">
                                    {{-- <select>
                                        <option >All Category</option>
                                        @foreach(Helper::getAllCategory() as $cat)
                                            <option>{{$cat->title}}</option>
                                        @endforeach
                                    </select> --}}
                                    <form method="POST" action="{{route('product.search')}}">
                                        @csrf
                                        <input name="search" placeholder="Search products here..." type="search">
                                        <button class="btnn" type="submit"><i class="ti-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        {{-- <!-- Mobile Menu Trigger -->
                        <div class="search-trigger">
                            <i class="ti-search"></i>
                        </div> --}}
                        
                        <div class="sinlge-bar dropdown">
                           <a class="single-icon"> <i class="ti-search"></i></a>
                            <div class="dropdown-content">
                                <form method="POST" action="{{ route('product.search') }}">
                                    @csrf
                                    <input type="text" placeholder="Search here..." name="search" required>
                                    <button type="submit"><i class="ti-search"></i></button>
                                </form>
                            </div>
                        </div>
                        

                        <div class="sinlge-bar shopping">
                            <a href="{{route('cart')}}" class="single-icon"><i class="ti-bag"></i> <span class="total-count" >{{Helper::cartCount()}}</span></a>
                            <!-- Shopping Item -->
                            @auth
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span>{{count(Helper::getAllProductFromCart())}} Items</span>
                                        <a href="{{route('cart')}}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list">
                                        {{-- {{Helper::getAllProductFromCart()}} --}}
                                            @foreach(Helper::getAllProductFromCart() as $data)
                                                    @php
                                                        $photo=explode(',',$data->product['photo']);
                                                    @endphp
                                                    <li>
                                                        <a href="{{route('cart-delete',$data->id)}}" class="remove" title="Remove this item"><i class="fa fa-remove"></i></a>
                                                        <a class="cart-img" href="#">
                                                            @if($data->product->gambarProduk->isNotEmpty())
                                                                <img src="{{ asset($data->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                                            @else
                                                                <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                                            @endif
                                                        </a>
                                                        <h4><a href="{{route('product-detail',$data->product['slug'])}}" target="_blank">{{$data->product['title']}}</a></h4>
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">Rp{{number_format($data->price,2)}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">Rp{{number_format(Helper::totalCartPrice(),2)}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        <div class="sinlge-bar shopping">
                            <ul class="list-main">
                                {{-- <li><i class="ti-alarm-clock"></i> <a href="#">Daily deal</a></li> --}}
                                @auth
                                    <li class="user-dropdown">
                                        <a href="#" class="single-icon" id="userDropdown" role="button"  aria-haspopup="true" aria-expanded="false">
                                            <i class="ti-user"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                                            @if(Auth::user()->role == 'admin')
                                                <a class="dropdown-item" href="{{ route('admin') }}"><i class="ti-user"></i>My Account</a>
                                            @else
                                                <a class="dropdown-item" href="{{ route('account-dash') }}"><i class="ti-user"></i>My Account</a>
                                            @endif
                                            <a class="dropdown-item" href="{{ route('user.logout') }}"><i class="ti-power-off"></i>Logout</a>
                                        </div>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ route('login.form') }}" class="single-icon">
                                            <i class="ti-user"></i>
                                        </a>
                                    </li>
                                @endauth

                                {{-- Check for JWT token in localStorage --}}
                                {{-- <script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        const token = localStorage.getItem('token');

                                        if (token) {
                                            // Decode the token to get user information
                                            const payload = JSON.parse(atob(token.split('.')[1]));
                                            const userRole = payload.role; // Adjust this if your token doesn't contain role directly
                                            console.log(payload);

                                            // Display admin or user link based on role
                                            if (userRole === 'admin') {
                                                document.querySelector('.user-role').innerHTML = '<li><a href="{{ route('admin') }}" class="single-icon" target="_blank"><i class="ti-user"></i></a></li>';
                                            } else if (userRole === 'user') {  // Pastikan peran pengguna adalah 'user'
                                                document.querySelector('.user-role').innerHTML = '<li><a href="{{ route('user') }}" class="single-icon" target="_blank"><i class="ti-user"></i></a></li>';
                                            } else {
                                                document.querySelector('.user-role').innerHTML = '<li><a href="#" class="single-icon" target="_blank"><i class="ti-user"></i> Unknown Role</a></li>';
                                            }
                                            // Display logout option
                                            document.querySelector('.logout').innerHTML = '<li><i class="ti-power-off"></i><a href="{{ route('user.logout') }}">Logout</a></li>';
                                        } else {
                                            // If no token, show login/register links
                                            document.querySelector('.auth-links').innerHTML = '<li><i class="fa fa-sign-in"></i><a href="{{ route('login.form') }}">Login /</a> <a href="{{ route('register.form') }}">Register</a></li>';
                                        }
                                    });
                                </script> --}}
                                {{-- <li class="user-role"></li> 
                                <li class="logout"></li>      
                                <li class="auth-links"></li>   --}}
                            </ul>
                        </div>

                        <!-- Mobile Menu Trigger -->
                        <div class="sinlge-bar shopping">
                        <div class="mobile-nav-trigger">
                           <a class="single-icon"> <i class="ti-menu"></i></a>
                        </div>
                        </div>
                    </div>
                    
                </div>
            </div>

       <!-- Search Form -->
       <!-- Modal Pencarian -->
{{-- <div class="modal-search" id="searchModal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <form method="POST" action="{{route('product.search')}}">
            @csrf
            <input type="text" placeholder="Search here..." name="search">
            <button type="submit"><i class="ti-search"></i></button>
        </form>
    </div>
</div> --}}
    <!--/ End Search Form -->
        </div>
    </div>
   



<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <span class="close-icon" id="closeMenu"><i class="ti-close"></i></span>
    <ul>
        <li><a href="{{ route('home') }}">Home</a></li>
        <li><a href="{{ route('product-grids') }}">Shop</a></li>
        <li><a href="{{ route('blog') }}">Blog</a></li>
        <li><a href="{{ route('contact') }}">Contact Us</a></li>
    </ul>
</div>
    

<script>
    document.querySelector('.mobile-nav-trigger').addEventListener('click', function() {
        document.getElementById('mobileMenu').classList.toggle('active');
    });

// Tombol untuk menutup menu (ikon close)
document.getElementById("closeMenu").addEventListener("click", function() {
    document.getElementById("mobileMenu").classList.remove("active");
});

</script>

<script>
    document.addEventListener('click', function (e) {
    var userDropdown = document.getElementById('userDropdown');
    var dropdownMenu = userDropdown.nextElementSibling;

    if (userDropdown.contains(e.target)) {
        // Toggle dropdown
        dropdownMenu.style.display = dropdownMenu.style.display === 'block' ? 'none' : 'block';
    } else {
        // Hide dropdown when clicking outside
        dropdownMenu.style.display = 'none';
    }
});

</script>

<script>
document.addEventListener('click', function (event) {
    const dropdown = document.querySelector('.dropdown-content');
    const button = document.querySelector('.dropbtn');

    if (!button.contains(event.target) && !dropdown.contains(event.target)) {
        dropdown.style.display = 'none'; // Tutup dropdown jika klik di luar
    }
});

</script>

<style>
.dropdown {
    position: relative;
    display: none;
}

/* .dropbtn {
    background-color: #007bff;
    color: white;
    padding: 10px 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
} */

.dropdown-content {
    display: none; /* Awalnya disembunyikan */
    position: absolute;
    right: 10px;
    border-radius: 10px;
    background-color: #f9f9f9;
    min-width: 200px; /* Lebar dropdown */
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
    padding: 10px; /* Padding dalam dropdown */
}

.dropdown-content form {
    display: flex;
    flex-direction: row; /* Susun input secara vertikal */
}

.dropdown-content input[type="text"] {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 10px 0px 0px 10px;
   
}

.dropdown-content button {
    background-color: #ff2c2b;
    color: white;
    border: none;
    padding: 10px; 
    cursor: pointer;
    border-radius: 0px 10px 10px 0px;
}

/* Tampilkan dropdown saat hover */
.dropdown:hover .dropdown-content {
    display: block;
}

.user-dropdown {
    position: relative; /* Supaya dropdown menu ditempatkan relatif ke elemen ini */
}

/* Style dasar dropdown */
.user-dropdown .dropdown-menu {
    display: none;
    position: absolute;
    top: 100%; /* Tempatkan tepat di bawah ikon user */
    left: 50%;
    transform: translateX(-50%); 
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border-radius: 10px;
    border: none;
    padding: 10px;
    max-width: 170px;
    min-width: 150px;
    z-index: 1000;
}

/* Tampilkan dropdown saat hover */
.user-dropdown:hover .dropdown-menu {
    display: block;
}

/* Style item dropdown */
.dropdown-menu .dropdown-item {
    color: #333;
    padding: 8px 12px;
    text-decoration: none;
    display: flex;
    align-items: center;
}

.dropdown-menu .dropdown-item i {
    margin-right: 8px; /* Spasi antara ikon dan teks */
    color: #333; /* Warna ikon */
}

.dropdown-menu .dropdown-item:hover {
    background-color: #f7f7f7;
}

.mobile-nav-trigger {
    display: none;
}

.search-trigger {
    display: none;
}

/* Default Style */
.header .middle-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* Kontrol ikon menu */
.mobile-menu {
    display: none;
    position: fixed;
    top: 75px;
    right: -100%;
    width: 100%;
    height: 300px;
    background-color: #fff;
    transition: all 0.3s ease;
    z-index: 999;
    padding-top: 50px;
    text-align: center;
    border-radius: 0px 0px 30px 30px;
}

.mobile-menu ul {
    list-style-type: none;
}

.mobile-menu ul li {
    margin: 20px 0;
}

.mobile-menu ul li a {
    color: #333;
    font-size: 20px;
    font-weight: 600;
    text-decoration: none;
}

.mobile-menu ul li a:hover {
    color: #ff2c2b !important;
    text-decoration: underline !important;
}


.close-icon {
    position: absolute;
    top: 30px;
    right: 40px;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    color: #333; /* Atur warna sesuai kebutuhan */
}


/* Tampilan di bawah 1090px */
@media (max-width: 1090px) {
    .header .middle-inner {
        flex-direction: row;
    }

    /* Atur ulang posisi logo dan ikon */
    .logo {
        order: 1;
        flex: 1;
        text-align: left;
    }

    /* Posisi icon cart, user, dan hamburger di sebelah kanan */
    .right-bar {
        display: flex;
        order: 2;
        justify-content: flex-end;
    }

    .search-bar-top{
        display: none;
    }

    .search-top {
        
    }

    .dropdown{
        display: block;
        cursor: pointer;
        font-size: 24px;
        margin-right: 20px;
    }
    /* Kontrol tampilan menu */
    .mobile-nav-trigger {
        display: block;
        cursor: pointer;
        font-size: 24px;
        margin-left: auto;
    }

    .search-trigger {
        display: block;
        cursor: pointer;
        font-size: 24px;
        margin-right: 20px;
    }

    .menu-area {
        display: none; /* Sembunyikan menu pada tampilan kecil */
    }

    /* Tampilan ketika icon menu diklik */
    .mobile-menu.active {
        display: block;
        left: 0;
    }
}

/* Tampilan di bawah 780px */
@media (max-width: 780px) {
    /* Tampilkan search bar di bawah konten logo dan ikon */
    .search-bar-wrapper {
        display: flex;
        justify-content: center;
        order: 3;
        width: 100%;
    }

    .search-bar {
        width: 90%;
        margin-top: 70px;
    }

    .mobile-nav-trigger {
        display: block;
    }
}


/* Responsif pada layar smartphone kecil (480px ke bawah) */
@media (max-width: 480px) {

    .dropdown{
        display: block;
        cursor: pointer;
        margin-right: 10px;
    }
    
    /* .single-icon i {
        font-size: 60px; 
    }

    .dropdown i.ti-search {
        font-size: 60px; 
    }
    
    .single-icon i.ti-user,
    .single-icon i.ti-power-off {
    font-size: 100px;
}

    .mobile-nav-trigger i{
        font-size: 60px;
    }
    .logo img {
        width: 20%; 
    } */
    
    
    /* .mobile-menu {
        height: 100vh;
        padding-top: 30px;
    }

    .close-icon {
        top: 20px;
        right: 20px;
        font-size: 22px;
    }

    .mobile-menu ul li a {
        font-size: 1rem;
    }

    .dropdown-content {
        min-width: 100%;
    }

    .dropdown-menu {
        max-width: 100%;
    } */
}


</style>
</header>