@extends('frontend.layouts.master')

@section('title','PT. Agro Apis Palacio || Kontak')

@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Kontak</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->
  
	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div >
								
								<img src="{{ asset('images/us.png') }}" alt="us">
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="single-head">
								<div class="title">
									<h4>Jangan ragu untuk menghubungi kami jika Anda memerlukan bantuan.</h4>
									<p>Kami siap membantu Anda dengan segala pertanyaan atau kebutuhan yang Anda miliki. Tim kami akan segera merespon setiap pesan yang Anda kirimkan dan siap memberikan solusi terbaik.</p>
								</div>
								
								<div class="single-info">
									<i class="fa fa-map"></i>
									<div>
									<h4 class="title">Alamat:</h4>
									<ul>
										<li>Dsn Singget RT 04 RW 02 Randuagung, Desa Sukomoro, Kec. Sukomoro, Magetan, Jawa Timur</li>
									</ul>
									</div>
								</div>
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<div>
									<h4 class="title">Telepon:</h4>
									<ul>
										<li>+62 821-3197-3213</li>
									</ul>
									</div>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<div>
									<h4 class="title">Email:</h4>
									<ul>
										<li><a href="mailto:info@yourwebsite.com">pakanmagetan@gmail.com</a></li>
									</ul>
									</div>
								</div>
								
								<div class="single-info">
									<a href="https://www.facebook.com/pakaninstanapis/"><i class="fa fa-facebook-f"></i></a>
									<a href="https://wa.me/{{ $admin->no_hp }}?text=Halo%2C%20saya%20tertarik%20dengan%20produk%20anda"><i class="fa fa-whatsapp"></i></a>
									<a href="https://www.instagram.com/pakaninstanapis/?igsh=eTIycm12cDVsdXE0"><i class="fa fa-instagram"></i></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->
	
	<!-- Map Section -->
	<div class="map-section">
		<div id="myMap">
			<iframe 
    src="https://maps.google.com/maps?q=-7.6367200815741825%2C111.38095337074881&t=m&z=12&output=embed&iwloc=near"
    title="Location near coordinates -7.6367200815741825, 111.38095337074881"
    aria-label="Location near coordinates -7.6367200815741825, 111.38095337074881"
    width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" tabindex="0">
</iframe>

		</div>
	</div>
	<!--/ End Map Section -->
	
	
@endsection

@push('styles')
<style>
	.modal-dialog .modal-content .modal-header{
		position:initial;
		padding: 10px 20px;
		border-bottom: 1px solid #e9ecef;
	}
	.modal-dialog .modal-content .modal-body{
		height:100px;
		padding:10px 20px;
	}
	.modal-dialog .modal-content {
		width: 50%;
		border-radius: 0;
		margin: auto;
	}
</style>
@endpush
@push('scripts')
<script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush