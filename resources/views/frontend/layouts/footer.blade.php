
	<!-- Start Footer Area -->
	<footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							<div class="logo">
								<p class="text">Didukung oleh Jaringan Usaha Kami:</p>
								<a href="index.html"><img src="{{ asset('images/Logo cv ttm.png') }}" alt="logo" style="width: 90px; height: auto; padding:10px;">
									<img src="{{ asset('images/LOGO APIS.png') }}" alt="logo" style="width: 90px; height: auto; margin-right:10px;">
									<img src="{{ asset('images/logo feed.png') }}" alt="logo" style="width: 80px; height: auto; "></a>
							</div>
							<p class="text">Selamat datang di Situs Web Ecommerce Apis, tujuan utama Anda untuk mencari produk. Temukan koleksi jenis produk pilihan yang dirancang untuk meningkatkan kebutuhan Anda. Selami dunia yang berkualitas, inovasi di mana setiap pembelian menjamin kepuasan.</p>
							
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Informasi</h4>
							<ul>
								{{-- <li><a href="{{route('about-us')}}">Tentan</a></li> --}}
								{{-- <li><a href="#">Faq</a></li> --}}
								<li><a href="#">Terms & Conditions</a></li>
								<li><a href="{{route('contact')}}">Kontak</a></li>
								<li><a href="#">Bantuan</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Tautan Cepat</h4>
							<ul>
								<li><a href="{{route('product-grids')}}">Produk Toko</a></li>
								<li><a href="{{route('cart')}}">Keranjang</a></li>
								<li><a href="{{route('blog')}}">Artikel</a></li>
								<li><a href="{{ route('frontend.pages.account.order') }}">Pesanan</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Hubungi Kami</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li>Dsn Singget RT 04 RW 02 Randuagung, Desa Sukomoro, Kec. Sukomoro, Magetan, Jawa Timur</li>
									<li>pakanmagetan@gmail.com</li>
									<li>+62 821-3197-3213</li>
								</ul>
							</div>
							<div class="social-media">
								<a class="crl" href="https://www.instagram.com/pakaninstanapis/?igsh=eTIycm12cDVsdXE0"> <img src="{{ asset('images/instagram.png') }}"></a>
								<a class="crl" href="https://wa.me/6282131973213?text=Halo%2C%20saya%20tertarik%20dengan%20produk%20anda"> <img src="{{ asset('images/wa.png') }}"></a>
								<a class="crl" href="https://www.facebook.com/pakaninstanapis/"> <img src="{{ asset('images/fb.png') }}"></a>
							</div>
							<!-- End Single Widget -->
							
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="justify-content-center">
						<div class="text-center">
							<div class="left">
								<p>© {{date('Y')}} Developed By PT. Agro Apis Palacio  -  All Rights Reserved.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->
 
	<!-- Jquery -->
    <script src="{{asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
	<script src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
	<!-- Popper JS -->
	<script src="{{asset('frontend/js/popper.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
	<!-- Color JS -->
	<script src="{{asset('frontend/js/colors.js')}}"></script>
	<!-- Slicknav JS -->
	<script src="{{asset('frontend/js/slicknav.min.js')}}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{asset('frontend/js/owl-carousel.js')}}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{asset('frontend/js/magnific-popup.js')}}"></script>
	<!-- Waypoints JS -->
	<script src="{{asset('frontend/js/waypoints.min.js')}}"></script>
	<!-- Countdown JS -->
	<script src="{{asset('frontend/js/finalcountdown.min.js')}}"></script>
	<!-- Nice Select JS -->
	<script src="{{asset('frontend/js/nicesellect.js')}}"></script>
	<!-- Flex Slider JS -->
	<script src="{{asset('frontend/js/flex-slider.js')}}"></script>
	<!-- ScrollUp JS -->
	<script src="{{asset('frontend/js/scrollup.js')}}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{asset('frontend/js/onepage-nav.min.js')}}"></script>
	{{-- Isotope --}}
	<script src="{{asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script>
	<!-- Easing JS -->
	<script src="{{asset('frontend/js/easing.js')}}"></script>

	<!-- Active JS -->
	<script src="{{asset('frontend/js/active.js')}}"></script>

	
	@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>