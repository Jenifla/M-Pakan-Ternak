@extends('frontend.layouts.master')

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
								{{-- <div class="title">
									@php
										$settings=DB::table('settings')->get();
									@endphp
									<h4>Jangan ragu untuk menghubungi kami jika Anda memerlukan bantuan.</h4>
									<h3>Write us a message @auth @else<span style="font-size:12px;" class="text-danger">[You need to login first]</span>@endauth</h3>
								</div> --}}
								{{-- <form class="form-contact form contact_form" method="post" action="{{route('contact.store')}}" id="contactForm" novalidate="novalidate">
									@csrf
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Name<span>*</span></label>
												<input name="name" id="name" type="text" placeholder="Enter your name">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Subjects<span>*</span></label>
												<input name="subject" type="text" id="subject" placeholder="Enter Subject">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Email<span>*</span></label>
												<input name="email" type="email" id="email" placeholder="Enter email address">
											</div>	
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Your Phone<span>*</span></label>
												<input id="phone" name="phone" type="number" placeholder="Enter your phone">
											</div>	
										</div>
										<div class="col-12">
											<div class="form-group message">
												<label>your message<span>*</span></label>
												<textarea name="message" id="message" cols="30" rows="9" placeholder="Enter Message"></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn ">Send Message</button>
											</div>
										</div>
									</div>
								</form> --}}
								<img src="{{ asset('images/us.png') }}" alt="us">
							</div>
						</div>
						<div class="col-lg-6 col-12">
							<div class="single-head">
								<div class="title">
									@php
										$settings=DB::table('settings')->get();
									@endphp
									<h4>Jangan ragu untuk menghubungi kami jika Anda memerlukan bantuan.</h4>
									<p>Kami siap membantu Anda dengan segala pertanyaan atau kebutuhan yang Anda miliki. Tim kami akan segera merespon setiap pesan yang Anda kirimkan dan siap memberikan solusi terbaik.</p>
								</div>
								
								<div class="single-info">
									<i class="fa fa-map"></i>
									<div>
									<h4 class="title">Alamat:</h4>
									<ul>
										<li>@foreach($settings as $data) {{$data->address}} @endforeach</li>
									</ul>
									</div>
								</div>
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<div>
									<h4 class="title">Telepon:</h4>
									<ul>
										<li>@foreach($settings as $data) {{$data->phone}} @endforeach</li>
									</ul>
									</div>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<div>
									<h4 class="title">Email:</h4>
									<ul>
										<li><a href="mailto:info@yourwebsite.com">@foreach($settings as $data) {{$data->email}} @endforeach</a></li>
									</ul>
									</div>
								</div>
								
								<div class="single-info">
									<i class="fa fa-facebook-f"></i>
									<i class="fa fa-whatsapp"></i>
									<i class="fa fa-instagram"></i>
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