@extends('frontend.layouts.master')

@section('title','PT. Agro Apis Palacio || PRODUCT PAGE')

@section('main-content')
	
		<!-- Breadcrumbs -->
		<div class="breadcrumbs">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<div class="bread-inner">
							<ul class="bread-list">
								<li><a href="{{route('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
								<li class="active"><a href="javascript:void(0);">Toko</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- End Breadcrumbs -->
		<form action="{{route('shop.filter')}}" method="POST">
		@csrf
			<!-- Product Style 1 -->
			<section class="product-area shop-sidebar shop-list shop section">
				<div class="container">
					<div class="row">
						<div class="col-lg-3 col-md-4 col-12">
							<div class="shop-sidebar">
                                <!-- Single Widget -->
                                <div class="single-widget category">
                                    <h3 class="title">Kategori</h3>
                                    <ul class="categor-list">
										@php
											// $category = new Category();
											$menu=App\Models\Category::getAllParentWithChild();
										@endphp
										@if($menu)
										<li>
											@foreach($menu as $cat_info)
													@if($cat_info->child_cat->count()>0)
														<li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a>
															<ul>
																@foreach($cat_info->child_cat as $sub_menu)
																	<li><a href="{{route('product-sub-cat',[$cat_info->slug,$sub_menu->slug])}}">{{$sub_menu->title}}</a></li>
																@endforeach
															</ul>
														</li>
													@else
														<li><a href="{{route('product-cat',$cat_info->slug)}}">{{$cat_info->title}}</a></li>
													@endif
											@endforeach
										</li>
										@endif
                                    </ul>
                                </div>
                                <!--/ End Single Widget -->
                                <!-- Shop By Price -->
								<div class="single-widget range">
									<h3 class="title">Temukan Berdasarkan Harga</h3>
									<div class="price-filter">
										<div class="price-filter-inner">
											@php
												$max=DB::table('products')->max('price');
												// dd($max);
											@endphp
											<div id="slider-range" data-min="0" data-max="{{$max}}"></div>
											<div class="product_filter">
											<button type="submit" class="filter_button">Terapkan</button>
											<div class="label-input">
												<span>Range:</span>
												<input style="" type="text" id="amount" readonly/>
												<input type="hidden" name="price_range" id="price_range" value="@if(!empty($_GET['price'])){{$_GET['price']}}@endif"/>
											</div>
											</div>
										</div>
									</div>
								</div>
								<!--/ End Shop By Price -->
                        	</div>
						</div>
						<div class="col-lg-9 col-md-8 col-12">
							<div class="row">
								<div class="col-12">
									<!-- Shop Top -->
									<div class="shop-top">
										<div class="shop-shorter">
											<div class="single-shorter">
												<label>Show :</label>
												<select class="show" name="show" onchange="this.form.submit();">
													<option value="">Default</option>
													<option value="9" @if(!empty($_GET['show']) && $_GET['show']=='9') selected @endif>09</option>
													<option value="15" @if(!empty($_GET['show']) && $_GET['show']=='15') selected @endif>15</option>
													<option value="21" @if(!empty($_GET['show']) && $_GET['show']=='21') selected @endif>21</option>
													<option value="30" @if(!empty($_GET['show']) && $_GET['show']=='30') selected @endif>30</option>
												</select>
											</div>
											<div class="single-shorter">
												<label>Sort By :</label>
												<select class='sortBy' name='sortBy' onchange="this.form.submit();">
													<option value="">Default</option>
													<option value="title" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='title') selected @endif>Name</option>
													<option value="price" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='price') selected @endif>Price</option>
													<option value="category" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='category') selected @endif>Category</option>
													<option value="brand" @if(!empty($_GET['sortBy']) && $_GET['sortBy']=='brand') selected @endif>Brand</option>
												</select>
											</div>
										</div>
										<ul class="view-mode">
											<li><a href="{{route('product-grids')}}"><i class="fa fa-th-large"></i></a></li>
											<li class="active"><a href="javascript:void(0)"><i class="fa fa-th-list"></i></a></li>
										</ul>
									</div>
									<!--/ End Shop Top -->
								</div>
							</div>
							<div class="row">
								@if(count($products))
									@foreach($products as $product)
									 	{{-- {{$product}} --}}
										<!-- Start Single List -->
										<div class="col-12">
											<div class="row">
												<div class="col-lg-4 col-md-6 col-sm-6">
													<div class="single-product">
														<div class="product-img">
															<a href="{{route('product-detail',$product->slug)}}">
															@php 
																$images = $product->gambarProduk->first();; // Pastikan ini menggunakan model Product dengan relasi yang benar
																$imageUrl = $images ? asset($images->gambar) : asset('backend/img/thumbnail-default.jpg'); // Gambar default jika tidak ada
															@endphp
															<img class="default-img" src="{{ $imageUrl }}" alt="{{$imageUrl}}">
															<img class="hover-img" src="{{ $imageUrl }}" alt="{{$imageUrl}}">
															</a>
															<div class="button-head">
																<div class="product-action-2">
																	<a title="Add to cart" href="{{route('add-to-cart',$product->slug)}}">Masukkan Keranjang</a>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-lg-8 col-md-6 col-12">
													<div class="list-content">
														<div class="product-content">
															<div class="product-price">
																@php
																	$after_discount=($product->price-($product->price*$product->discount)/100);
																@endphp
																<span>Rp{{number_format($after_discount, 0, ',', '.')}}</span>
																<del>Rp{{number_format($product->price, 0, ',', '.')}}</del>
															</div>
															<h3 class="title"><a href="{{route('product-detail',$product->slug)}}">{{$product->title}}</a></h3>
														{{-- <p>{!! html_entity_decode($product->summary) !!}</p> --}}
														</div>
														<p class="des pt-2">{!! html_entity_decode($product->summary) !!}</p>
														<a href="javascript:void(0)" class="btn cart" data-id="{{$product->id}}">Beli Sekarang!</a>
													</div>
												</div>
											</div>
										</div>
										<!-- End Single List -->
									@endforeach

									@if($products->lastPage() > 1)
										<div class="col-md-12 d-flex justify-content-center">
											<nav aria-label="Page navigation">
												<ul class="pagination">
													<!-- Previous Page Link -->
													@if ($products->onFirstPage())
														<li class="page-item disabled">
															<span class="page-link"><i class="ti-angle-left"></i></span>
														</li>
													@else
														<li class="page-item">
															<a class="page-link" href="{{ $products->previousPageUrl() }}" rel="prev"><i class="ti-angle-left"></i></a>
														</li>
													@endif
										
													<!-- Page Numbers -->
													@for ($i = 1; $i <= $products->lastPage(); $i++)
														@if ($i == 1 || $i == $products->lastPage() || ($i >= $products->currentPage() - 2 && $i <= $products->currentPage() + 2))
															<li class="page-item {{ $products->currentPage() == $i ? 'active' : '' }}">
																<a class="page-link" href="{{ $products->url($i) }}">{{ $i }}</a>
															</li>
														@elseif ($i == 2 || $i == $products->lastPage() - 1)
															<li class="page-item disabled"><span class="page-link">...</span></li>
														@endif
													@endfor
										
													<!-- Next Page Link -->
													@if ($products->hasMorePages())
														<li class="page-item">
															<a class="page-link" href="{{ $products->nextPageUrl() }}" rel="next"><i class="ti-angle-right"></i></a>
														</li>
													@else
														<li class="page-item disabled">
															<span class="page-link"><i class="ti-angle-right"></i></span>
														</li>
													@endif
												</ul>
											</nav>
										</div>
									@endif
							
								
								@else
									<h4 class="text-danger" style="margin:100px auto;">Sorry, there are no products according to the range given. Try selecting different one to see more results.</h4>
								@endif
							</div>
						
						</div>
					</div>
				</div>
			</section>
			<!--/ End Product Style 1  -->	
		</form>

@endsection
@push ('styles')
<style>
/* Styling untuk pagination */
.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.pagination .page-item {
    margin: 0 5px;
}

.pagination .page-link {
    padding: 10px 15px;
    border: 1px solid #ccc;
    text-decoration: none;
    color: #F7941D;
}

.pagination .active .page-link {
    background-color: #F7941D;
    border: none;
    color: white;
}

.pagination .disabled .page-link {
    color: #ccc;
}

.pagination .page-link:hover {
    background-color: #F7941D;
    color: white;
}


	.filter_button{
        /* height:20px; */
        text-align: center;
        background:#F7941D;
        padding:8px 16px;
        margin-top:10px;
        color: white;
    }
    .filter_button:hover{
        background:#ff2c2b;
    }
</style>
@endpush
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

	<script>
        $(document).ready(function(){
        /*----------------------------------------------------*/
        /*  Jquery Ui slider js
        /*----------------------------------------------------*/
        if ($("#slider-range").length > 0) {
            const max_value = parseInt( $("#slider-range").data('max') ) || 500;
            const min_value = parseInt($("#slider-range").data('min')) || 0;
            const currency = $("#slider-range").data('currency') || '';
            let price_range = min_value+'-'+max_value;
            if($("#price_range").length > 0 && $("#price_range").val()){
                price_range = $("#price_range").val().trim();
            }
            
            let price = price_range.split('-');
            $("#slider-range").slider({
                range: true,
                min: min_value,
                max: max_value,
                values: price,
                slide: function (event, ui) {
                    $("#amount").val(currency + ui.values[0] + " -  "+currency+ ui.values[1]);
                    $("#price_range").val(ui.values[0] + "-" + ui.values[1]);
                }
            });
            }
        if ($("#amount").length > 0) {
            const m_currency = $("#slider-range").data('currency') || '';
            $("#amount").val(m_currency + $("#slider-range").slider("values", 0) +
                "  -  "+m_currency + $("#slider-range").slider("values", 1));
            }
        })
    </script>

@endpush