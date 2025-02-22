@extends('frontend.layouts.master')
@section('title','Cart Page')
@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="">Keranjang</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- Shopping Cart -->
	<div class="shopping-cart section">
		<div class="container">
			<div class="row cart-bg">
				<div class="col-lg-9  col-12">
					<!-- Shopping Summery -->
					<table class="table shopping-summery">
						<thead>
							<tr class="main-hading">
								<th >PRODUK</th>
								<th class="text-center hide-mobile">JUMLAH</th>
								<th class="text-center">TOTAL</th>
								<th class="text-center hide-mobile"><i class="ti-trash remove-icon"></i></th>
							</tr>
						</thead>
						<tbody id="cart_item_list">
							<form action="{{route('cart.update')}}" method="POST">
								@csrf
								@php
									$subtotal_cart = 0; // Inisialisasi subtotal
									$total_items = 0; // Inisialisasi jumlah total barang
								@endphp
								@if(Helper::getAllProductFromCart())
									@foreach(Helper::getAllProductFromCart() as $key=>$cart)
										<tr>
											@php
											$photo=explode(',',$cart->product['photo']);
											$photo = explode(',', $cart->product['photo']);
											
											$original_price = $cart->product['price']; // Harga asli produk
											$discount = $cart->product['discount']; // Diskon produk
											$price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
											$total_price = $price_after_discount * $cart->quantity;
											$subtotal_cart += $total_price; 
											$total_items += $cart->quantity;
											@endphp

										
											
											<td class="product-in-cart" >
												<div class="product-image">
													@if($cart->product->gambarProduk->isNotEmpty())
													<img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
												@else
													<img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
												@endif
												</div>
												<!-- Informasi Produk -->
    											<div class="product-info">
													<p class="product-name"><a href="{{route('product-detail',$cart->product['slug'])}}" target="_blank">{{$cart->product['title']}}</a></p>
													<p class="product-des">{!!($cart->product['summary'])!!}</p>
													<p>Rp{{number_format($price_after_discount, 0, ',', '.')}}</p> 
												</div>
											</td>
											<td id="mob-info" class="qty" data-title="Qty"><!-- Input Order -->
												<div class="input-group">
													<div class="button minus">
														<button type="button" class="btn btn-primary btn-number" disabled="disabled" data-type="minus" data-field="quant[{{$key}}]">
															<i class="ti-minus"></i>
														</button>
													</div>
													<input type="text" name="quant[{{$key}}]" class="input-number"  data-min="1" data-max="100" value="{{$cart->quantity}}">
													<input type="hidden" name="qty_id[]" value="{{$cart->id}}">
													<div class="button plus">
														<button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[{{$key}}]">
															<i class="ti-plus"></i>
														</button>
													</div>
												</div>
												<!--/ End Input Order -->
											</td>
											<td id="mob-info" class="total-amount cart_single_price" data-title="Total">
												<span class="money">Rp{{ number_format($total_price, 0, ',', '.') }}</span> 
											</td>
											<td id="mob-info" class="action" data-title="Remove"><a href="{{route('cart-delete',$cart->id)}}"><i class="ti-trash remove-icon"></i></a></td>
										</tr>
									@endforeach
									<tr>
										
										<td class="b-right" colspan="4">
											<button class="btn float-right" type="submit">Perbarui</button>
										</td>
									</tr>
								@else
										<tr>
											<td class="text-center">
												Tidak ada keranjang yang tersedia. <a href="{{route('product-grids')}}" style="color:blue;">Lanjutkan belanja</a>

											</td>
										</tr>
								@endif

							</form>
						</tbody>
						
					</table>
					<!--/ End Shopping Summery -->
				</div>
				<div class="col-lg-3  col-12">
					<!-- Total Amount -->
					<div class="total-amount">
							<div >
								<div class="right">
									<ul>
										<li class="order_subtotal" >Subtotal Keranjang<span>Rp{{number_format($subtotal_cart, 0, ',', '.')}}</span></li>

										@php
											$total_amount=Helper::totalCartPrice();
											if(session()->has('coupon')){
												$total_amount=$total_amount-Session::get('coupon')['value'];
											}
										@endphp
											<li class="last" id="order_total_price">Subtotal Bayar<span>Rp{{number_format($subtotal_cart, 0, ',', '.')}}</span></li>
									</ul>
									<div class="button5">
										<a href="{{route('checkout')}}" class="bton">Checkout</a>
										<a href="{{route('product-grids')}}" class="bton">Lanjutkan Belanja</a>
									</div>
								</div>
							</div>
						{{-- </div> --}}
					</div>
					<!--/ End Total Amount -->
				</div>
			</div>
			<div class="row">
				
			</div>
		</div>
	</div>
	<!--/ End Shopping Cart -->



	

@endsection
@push('styles')
	<style>
		.b-right{
			padding-right: 0;
			text-align: right;
			right: 0;
		}
		li.shipping{
			display: inline-flex;
			width: 100%;
			font-size: 14px;
		}
		li.shipping .input-group-icon {
			width: 100%;
			margin-left: 10px;
		}
		.input-group-icon .icon {
			position: absolute;
			left: 20px;
			top: 0;
			line-height: 40px;
			z-index: 3;
		}
		.form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#F7941D !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}
	</style>
@endpush
@push('scripts')
	<script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') );
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0;
				// alert(coupon);
				$('#order_total_price span').text('$'+(subtotal + cost-coupon).toFixed(2));
			});

		});

	</script>

@endpush
