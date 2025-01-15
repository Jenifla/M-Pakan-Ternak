@extends('frontend.layouts.master')
@section('title','PT. Agro Apis Palacio || HOME PAGE')
@section('main-content')
<!-- Slider Area -->
@if(count($banners)>0)
    <section id="Gslider" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            @foreach($banners as $key=>$banner)
        <li data-target="#Gslider" data-slide-to="{{$key}}" class="{{(($key==0)? 'active' : '')}}"></li>
            @endforeach

        </ol>
        <div class="carousel-inner" role="listbox">
                @foreach($banners as $key=>$banner)
                <div class="carousel-item {{(($key==0)? 'active' : '')}}">
                    <img class="first-slide" src="{{$banner->photo}}" alt="First slide">
                    <div class="carousel-caption  d-block text-left">
                        <h1 class="wow fadeInDown">{{$banner->title}}</h1>
                        <p>{!! html_entity_decode($banner->description) !!}</p>
                        <a class="btn btn-lg ws-btn wow fadeInUpBig" href="{{route('product-grids')}}" role="button">Jelajahi<i class="ti-arrow-circle-right"></i></i></a>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#Gslider" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Sebelumnya</span>
        </a>
        <a class="carousel-control-next" href="#Gslider" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Selanjutnya</span>
        </a>
    </section>
@endif

<!--/ End Slider Area -->
<div class="text-run section">
    <div class="container-teks">
        
            <div class="marquee" >
                <span class="marquee-text">Konsultasikan Pakan Ternak secara Gratis <img src="{{ asset('images/12.png') }}" alt="sun">Konsultasikan Pakan Ternak secara Gratis<img src="{{ asset('images/12.png') }}" alt="sun"></span>
                <span class="marquee-text">Konsultasikan Pakan Ternak secara Gratis <img src="{{ asset('images/12.png') }}" alt="sun">Konsultasikan Pakan Ternak secara Gratis<img src="{{ asset('images/12.png') }}" alt="sun"></span>
                
            </div>
        
    </div>
</div>

<!-- Start Small Banner  -->
<section class="small-banner section" style="background-image: url('{{ asset('images/back.png') }}'); background-size: contain; ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="small-section-title">
                    <h2>Belanja Berdasarkan Kategori<img src="{{ asset('images/icons.png') }}" ></h2>
                    
                    
                </div>
            </div>
        </div>
        <div class="row">
            @php
            $category_lists=DB::table('categories')->where('status','active')->limit(3)->get();
            @endphp
            @if($category_lists)
                @foreach($category_lists as $cat)
                    @if($cat->is_parent==1)
                        <!-- Single Banner  -->
                        <div class="col-lg-6 col-md-6 col-12">
                            <div class="single-banner-kat">
                                @if($cat->photo)
                                    <img src="{{$cat->photo}}" alt="{{$cat->photo}}">
                                @else
                                    <img src="https://via.placeholder.com/600x370" alt="#">
                                @endif
                                <div class="content">
                                    <h3>{{$cat->title}}</h3>
                                        <a href="{{route('product-cat',$cat->slug)}}">Temukan Sekarang <i class="ti-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- /End Single Banner  -->
                @endforeach
            @endif
        </div>
    </div>
</section>
<!-- End Small Banner -->



<!-- Start Product Area -->
<div class="product-area section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>Produk Baru </h2>
                        <img src="{{ asset('images/ikon.png') }}" >
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="product-info">
                        <div class="tab-content isotope-grid" id="myTabContent">
                        @if($product_lists)
                            @foreach($product_lists as $key => $product)
                                <div class=" isotope-item {{$product->cat_id}}">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="{{route('product-detail', $product->slug)}}">
                                                
                                                @php
                                                // Ambil gambar produk dari relasi
                                                
                                                    $images = $product->gambarProduk; // Pastikan ini menggunakan model Product dengan relasi yang benar
                                                    $defaultImage = asset('backend/img/thumbnail-default.jpg'); // Gambar default jika tidak ada
                                                    $firstImage = (isset($images) && $images->isNotEmpty()) ? asset($images[0]->gambar) : $defaultImage; // Ambil gambar pertama
                                                @endphp
                                                <img class="default-img" src="{{ $firstImage }}" alt="{{ $firstImage }}">
                                                <img class="hover-img" src="{{ $firstImage }}" alt="{{ $firstImage }}">
                                                
                                                @if($product->stock <= 0)
                                                    <span class="out-of-stock">Stok Habis</span>
                                                @elseif($product->condition == 'new')
                                                    <span class="new">Baru</span>
                                                @elseif($product->condition == 'best seller')
                                                    <span class="hot">Terlaris</span>
                                                @else
                                                    <span class="price-dec">{{$product->discount}}% Off</span>
                                                @endif
                                            </a>
                                            <div class="button-head">
                                                
                                                <div class="product-action-2">
                                                    <a title="Add to cart" href="{{route('add-to-cart', $product->slug)}}">Masukkan Keranjang</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3><a href="{{route('product-detail', $product->slug)}}">{{$product->title}}</a></h3>
                                            @php
                                                $after_discount = ($product->price - ($product->price * $product->discount) / 100);
                                            @endphp
                                            <div class="product-price">
                                                @if($product->discount > 0)
                                                <span>Rp{{ number_format($after_discount, 0, ',', '.') }}</span>
                                                <del style="padding-left: 4%;">Rp{{ number_format($product->price, 0, ',', '.') }}</del>
                                                @else
                                                    <span>Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                             <!--/ End Single Tab -->
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<!-- End Product Area -->

<!-- Start info Banner  -->
<section class="info-banner section">
    <div class="container">
        <!-- Single Banner  -->
        <div >
            <div class="conten-info">
                
                    <img src="{{ asset('images/kuning.png') }}" alt="cta">

            </div>
        </div>
    
    <!-- /End Single Banner  -->
        
    </div>
</section>
<!-- End CTA Banner -->

<!-- Start Shop By Animal  -->
<section class="shop-animal section" style="background-image: url('{{ asset('images/back.png') }}'); background-size: contain; ">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="animal-section-title">
                    <h2>Belanja Berdasarkan Hewan <img src="{{ asset('images/icons.png') }}" ></h2>
                    
                </div>
            </div>
        </div>
        <div class="row">
            
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Start Single Animal  -->
                        <div class="shop-single-animal">
                            <img src="{{ asset('images/kambing.png') }}" 
                                alt="kambing"
                                onmouseover="this.src='{{ asset('images/hoverkambing.png') }}'"
                                onmouseout="this.src='{{ asset('images/kambing.png') }}'">
                                <div class="content">
                                <a href="{{route('product-sub-cat',['pakan-ternak','pakan-kambing'])}}" class="title-animal">Pakan Kambing&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                                </div>
                        </div>
                        <!-- End Single Animal  -->
                    </div>
                    
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Start Single Animal  -->
                        <div class="shop-single-animal">
                            <img src="{{ asset('images/domba.png') }}" 
                                alt="domba"
                                onmouseover="this.src='{{ asset('images/hoverdomba.png') }}'"
                                onmouseout="this.src='{{ asset('images/domba.png') }}'">
                            <div class="content">
                                <a href="{{route('product-sub-cat',['pakan-ternak','pakan-domba'])}}" class="title-animal">Pakan Domba&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            </div>
                        </div>
                        <!-- End Single Animal  -->
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Start Single Animal  -->
                        <div class="shop-single-animal">
                            <img src="{{ asset('images/sapi.png') }}" 
                                alt="sapi"
                                onmouseover="this.src='{{ asset('images/hoversapi.png') }}'"
                                onmouseout="this.src='{{ asset('images/sapi.png') }}'">
                            <div class="content">
                                <a href="{{route('product-sub-cat',['pakan-ternak','pakan-sapi'])}}" class="title-animal">Pakan Sapi&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
                            </div>
                        </div>
                        <!-- End Single Animal  -->
                    </div>
        </div>
    </div>
</section>
<!-- End Shop By Animal  -->

<!-- Start Most Popular -->
<div class="product-area most-popular section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Product Terlaris</h2>
                    <img src="{{ asset('images/ikon.png') }}" >
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="owl-carousel popular-slider">
                    @foreach($product_most as $product)
                        @if($product->condition=='best seller')
                            <!-- Start Single Product -->
                        <div class="single-product">
                            <div class="product-img">
                                <a href="{{route('product-detail',$product->slug)}}">
                                    @php
                                                // Ambil gambar produk dari relasi
                                                
                                                    $images = $product->gambarProduk; // Pastikan ini menggunakan model Product dengan relasi yang benar
                                                    $defaultImage = asset('backend/img/thumbnail-default.jpg'); // Gambar default jika tidak ada
                                                    $firstImage = (isset($images) && $images->isNotEmpty()) ? asset($images[0]->gambar) : $defaultImage; // Ambil gambar pertama
                                                @endphp
                                                <img class="default-img" src="{{ $firstImage }}" alt="{{ $firstImage }}">
                                                <img class="hover-img" src="{{ $firstImage }}" alt="{{ $firstImage }}">
                                                
                                    
                                </a>
                                <div class="button-head">
                                    <div class="product-action-2">
                                        <a href="{{route('add-to-cart',$product->slug)}}">Masukkan Keranjang</a>
                                    </div>
                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
                                <div class="product-price">
                                    <span class="old">Rp{{number_format($product->price, 0, ',', '.')}}</span>
                                    @php
                                    $after_discount=($product->price-($product->price*$product->discount)/100)
                                    @endphp
                                    <span>Rp{{number_format($after_discount, 0, ',', '.')}}</span>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Product -->
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Most Popular Area -->

<!-- Start CTA Banner  -->
<section class="cta-banner section">
    <div class="container-cta">
        <!-- Single Banner  -->
        <div >
            <div class="single-banner-cta">
                
                    <img src="{{ asset('images/cow.png') }}" alt="cta">
                
                <div class="content">
                   
                <a href="{{route('product-cat',$cat->slug)}}">Belanja Sekarang <i class="ti-angle-right"></i></a>
                </div>
            </div>
        </div>
    
    <!-- /End Single Banner  -->
        
    </div>
</section>
<!-- End CTA Banner -->


<!-- Start Shop Blog  -->
<section class="shop-blog section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h2>Artikel dari Kami</h2>
                    <img src="{{ asset('images/ikon.png') }}" >
                </div>
            </div>
        </div>
        <div class="row">
            @if($posts)
                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6 col-12">
                        <!-- Start Single Blog  -->
                        <div class="shop-single-blog">
                            
                                <img src="{{$post->photo}}" alt="{{$post->photo}}">
                            
                            <div class="blog-meta">
                                <span class="author"><a href="javascript:void(0);"><i class="fa fa-user"></i> {{$post->author_info['name']}}</a><a href="javascript:void(0);"><i class="fa fa-calendar"></i>{{$post->created_at->format('M d, Y')}}</a></span>
                            </div>
                            <div class="content">
                                {{-- <p class="date">{{$post->created_at->format('d M , Y. D')}}</p> --}}
                                <a href="{{route('blog.detail',$post->slug)}}" class="title">{{$post->title}}</a>
                                <a href="{{route('blog.detail',$post->slug)}}" class="more-btn">Lanjutkan Membaca</a>
                            </div>
                        </div>
                        <!-- End Single Blog  -->
                    </div>
                @endforeach
            @endif

        </div>
    </div>
</section>
<!-- End Shop Blog  -->

@endsection

@push('styles')
    <style>
        /* Banner Sliding */
        #Gslider .carousel-inner {
        
        }

        #Gslider .carousel-inner{
        height: 550px;
        }
        #Gslider .carousel-inner img{
            width: 100% !important;
            opacity: 1;
        }

        #Gslider .carousel-inner .carousel-caption {
        bottom: 60%;
        visibility: visible; /* Ensure visibility */
         opacity: 1; /* Ensure opacity */
        }

        #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 50px;
        font-weight: bold;
        line-height: 100%;
        /* color: #F7941D; */
        color: #1e1e1e;
        }

        #Gslider .carousel-inner .carousel-caption p {
        font-size: 18px;
        color: #ff2c2b;
        margin: 28px 0 28px 0;
        }

        #Gslider .carousel-inner .carousel-caption span {
        font-size: 18px;
        color: #ff2c2b;
        margin: 28px 0 28px 0;
        }

        #Gslider .carousel-inner .carousel-caption .btn{
            color: #fff;
            background: #ffa800;
            font-weight: 600; 
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px; /* Menambahkan jarak antara teks dan ikon */
            line-height: initial;
            text-transform: none;
            border-radius: 25px;
            height: auto;
            z-index: 0;
        }

        #Gslider .carousel-inner .carousel-caption .btn i{
            color: #fff;
            font-size: 18px;  
        }

        #Gslider .carousel-inner .carousel-caption .btn:hover{
            color: #fff;
            background: #ff2c2b;
        }

        #Gslider .carousel-indicators {
        bottom: 70px;
        }

/* Tablet (max-width: 991px) */
@media (max-width: 991px) {
    #Gslider .carousel-inner {
        height: 400px;
    }
    #Gslider .carousel-inner .carousel-caption {
        bottom: 50%;
    }
    #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 36px;
    }
    #Gslider .carousel-inner .carousel-caption p {
        font-size: 16px;
    }
    #Gslider .carousel-inner .carousel-caption .btn {
        font-size: 14px;
        padding: 10px 25px;
    }
}

/* Mobile (max-width: 767px) */
@media (max-width: 767px) {
    #Gslider .carousel-inner {
        height: 400px;
    }
    #Gslider .carousel-inner img {
        /* height: 300px; */
        /* object-fit: cover; */
    }
    #Gslider .carousel-inner .carousel-caption {
        bottom: 50%;
        /* text-align: center; */
    }
    #Gslider .carousel-inner .carousel-caption h1 {
        font-size: 24px;
    }
    #Gslider .carousel-inner .carousel-caption p {
        font-size: 14px;
    }
    #Gslider .carousel-inner .carousel-caption .btn {
        font-size: 12px;
        padding: 8px 20px;
    }
}

/* Extra Small Mobile (max-width: 480px) */
@media (max-width: 480px) {
    #Gslider .carousel-inner {
        height: 250px;
    }
    #Gslider .carousel-inner .carousel-caption {
        bottom: 10%;
    }
    #Gslider .carousel-inner .carousel-caption h1 {
        color: #1e1e1e;
        font-size: 20px;
    }
    #Gslider .carousel-inner .carousel-caption p {
        font-size: 12px;
    }
    #Gslider .carousel-inner .carousel-caption .btn {
        font-size: 10px;
        padding: 6px 15px;
    }
}
    </style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <script>
         function cancelFullScreen(el) {
            var requestMethod = el.cancelFullScreen||el.webkitCancelFullScreen||el.mozCancelFullScreen||el.exitFullscreen;
            if (requestMethod) { // cancel full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        function requestFullScreen(el) {
            // Supports most browsers and their versions.
            var requestMethod = el.requestFullScreen || el.webkitRequestFullScreen || el.mozRequestFullScreen || el.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(el);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
            return false
        }
    </script>
<script>
    const buttons = document.querySelectorAll('.butn');

buttons.forEach(button => {
    button.addEventListener('click', function() {
        // Hapus kelas 'active' dari semua tombol
        buttons.forEach(btn => btn.classList.remove('active'));
        // Tambahkan kelas 'active' pada tombol yang diklik
        this.classList.add('active');
    });
});

    </script>
@endpush
