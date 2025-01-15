<header class="header shop">
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-2">
                    <div class="menu-area">
                        <!-- Main Menu -->
                        <nav class="navbar navbar-expand-lg">
                            <div class="navbar-collapse">	
                                <div class="nav-inner">	
                                    <ul class="nav main-menu menu navbar-nav">
                                        <li class="{{Request::path()=='' ? 'active' : ''}}"><a href="{{route('home')}}">Beranda</a></li>
                                        <li class="{{Request::path()=='product-grids' ? 'active' : ''}}"><a href="{{route('product-grids')}}">Toko</a></li>
                                        
                                        <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="{{route('blog')}}">Artikel</a></li>									
                                           
                                        <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Kontak</a></li>
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
                        <img src="{{ asset('images/Logo optima feed.png') }}" alt="logo" >
                    </div>
                    <!--/ End Logo -->
                </div>

                <div class="col-lg-5 col-md-2 col-sm-6 col-6">
                    <div class="right-bar">
                        <div class="sinlge-bar search">
                            <div class="search-bar-top">
                                <div class="search-bar">
                                    <form method="POST" action="{{route('product.search')}}">
                                        @csrf
                                        <input name="search" placeholder="Cari Produk disini..." type="search">
                                        <button class="btnn" type="submit"><i class="ti-search"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                        <div class="sinlge-bar dropdown">
                           <a class="single-icon"> <i class="ti-search"></i></a>
                            <div class="dropdown-content">
                                <form method="POST" action="{{ route('product.search') }}">
                                    @csrf
                                    <input type="text" placeholder="Cari disini..." name="search" required>
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
                                        <span>{{count(Helper::getAllProductFromCart())}} Item</span>
                                        <a href="{{route('cart')}}">Lihat Keranjang</a>
                                    </div>
                                    <ul class="shopping-list">
                                       
                                            @foreach(Helper::getAllProductFromCart() as $data)
                                                    @php
                                                        $product = $data->product;
                                                        $original_price = $product->price; // Harga asli produk
                                                        $discount = $product->discount; // Diskon produk
                                                        $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
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
                                                        <p class="quantity">{{$data->quantity}} x - <span class="amount">Rp{{number_format($price_after_discount, 0, ',', '.')}}</span></p>
                                                    </li>
                                            @endforeach
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount">Rp{{number_format(Helper::totalCartPrice(), 0, ',', '.')}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                            @endauth
                            <!--/ End Shopping Item -->
                        </div>
                        <div class="sinlge-bar shopping">
                            <ul class="list-main">
                                @auth
                                    <li class="user-dropdown">
                                        <a href="#" class="single-icon" id="userDropdown" role="button"  aria-haspopup="true" aria-expanded="false">
                                            <i class="ti-user"></i>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="userDropdown">
                                            @if(Auth::user()->role == 'admin')
                                                <a class="dropdown-item" href="{{ route('admin') }}" target="_blank"><i class="ti-user"></i>Akun Saya</a>
                                            @else
                                                <a class="dropdown-item" href="{{ route('account-dash') }}"><i class="ti-user"></i>Akun Saya</a>
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
        </div>
    </div>
   



<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <span class="close-icon" id="closeMenu"><i class="ti-close"></i></span>
    <ul>
        <li><a href="{{ route('home') }}">Beranda</a></li>
        <li><a href="{{ route('product-grids') }}">Toko</a></li>
        <li><a href="{{ route('blog') }}">Artikel</a></li>
        <li><a href="{{ route('contact') }}">Kontak</a></li>
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

.dropdown-content {
    display: none; /* Awalnya disembunyikan */
    position: absolute;
    right: -90px;
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
    background-color: #ffa800;
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
}


</style>
</header>