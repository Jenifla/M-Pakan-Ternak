@extends('frontend.layouts.master')

@section('title','Checkout page')

@section('main-content')

    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0)">Checkout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
            
    <!-- Start Checkout -->
    <section class="shop checkout section">
        <div class="container">
                <form class="form" method="POST" action="{{route('cart.order')}}">
                    @csrf
                    <div class="row"> 

                        <div class="col-lg-8 col-12">
                            <div class="checkout-form">
                                <h2>Complete Your Purchase</h2>
                                <p>Just a few more steps to complete your purchase securely!</p>
                                <!-- Form -->
                                @if($user->addresses->isEmpty())
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Full Name<span>*</span></label>
                                            <input type="text" name="full_nama" placeholder="" value="{{old('full_nama')}}" value="{{old('full_nama')}}" required>
                                            @error('full_nama')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            
                                            <label>Phone Number <span>*</span></label>
                                            <input type="number" name="no_hp" placeholder="" required value="{{old('no_hp')}}">
                                            @error('no_hp')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="select-provinsi" >Provinsi <span>*</span></label>
                                            <select  id="select-provinsi" name="provinsi" required>
                                                <option value="">- Pilih Provinsi -</option>
                                            </select>
                                            <input type="hidden" id="provinsi-nama" name="provinsi">
                                            @error('provinsi')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="select-provinsi" >Provinsi <span>*</span></label>
                                            <select id="province" name="province_id" class="nice-select" required>
                                                <option value="">- Pilih Provinsi -</option>
                                                @foreach($provinces as $province)
                                                    <option value="{{ $province['province_id'] }}" 
                                                        @if(old('province_id') == $province['province_id'] || isset($province_id) && $province_id == $province['province_id']) selected @endif>
                                                        {{ $province['province'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                           
                                            @error('province_id')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    
                                    
                                    {{-- <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Kabupaten <span>*</span></label>
                                            <select id="city_id" name="destination"class="nice-select"  required>
                                                <option value="">- Pilih Kota -</option>
                                                @foreach($cities as $city)
                                                    <option value="{{ $city['city_id'] }}">{{ $city['city_name'] }}</option>
                                                @endforeach
                                            </select>
                                            @error('destination')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Kabupaten <span>*</span></label>
                                            <select id="select-kabupaten" name="kabupaten" required disabled>
                                                <option value="">- Pilih Kabupaten -</option>
                                            </select>
                                            <input type="hidden" id="kabupaten-nama" name="kabupaten"> 
                                            @error('kabupaten')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Kecamatan -->
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Kecamatan <span>*</span></label>
                                            <select  id="select-kecamatan" name="kecamatan" required disabled>
                                                <option value="">- Pilih Kecamatan -</option>
                                            </select>
                                            <input type="hidden" id="kecamatan-nama" name="kecamatan">
                                            @error('kecamatan')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Kelurahan -->
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Kelurahan <span>*</span></label>
                                            <select  id="select-kelurahan" name="kelurahan" required disabled>
                                                <option value="">- Pilih Kelurahan -</option>
                                            </select>
                                            <input type="hidden" id="kelurahan-nama" name="kelurahan">
                                            @error('kelurahan')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Postal Code</label>
                                            <input type="text" name="kode_pos" placeholder="" value="{{old('kode_pos')}}">
                                            @error('kode_pos')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Detail Alamat<span>*</span></label>
                                            <input type="text" name="detail_alamat" placeholder="" value="{{old('detail_alamat')}}">
                                            @error('detail_alamat')
                                                <span class='text-danger'>{{$message}}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="form-group">
                                            <label>Jenis Alamat<span>*</span></label>
                                            <select name="jenis-alamat" id="jenis-alamat" required>
                                                <option value="">- Pilih Jenis Alamat -</option>
                                                <option value="Rumah" {{ old('jenis_alamat') == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                                                <option value="Kantor" {{ old('jenis_alamat') == 'Kantor' ? 'selected' : '' }}>Kantor</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Form -->
                                @else
                                @foreach($user->addresses as $address)
                                @if($address->is_default)
                                    <div class="address-card">
                                        <div class="address">
                                            <a><i class="ti-pencil"></i></a>
                                            <h3>{{ $address->full_nama }}</h3>
                                            <p>{{ $address->kelurahan }}, {{ $address->detail_alamat }}<br>
                                                {{ $address->kecamatan }}, {{ $address->kabupaten }}, {{ $address->provinsi }}, {{ $address->kode_pos }}</p>
                                            <p><strong>Phone Number:</strong> {{ $address->no_hp }}</p>
                                        </div>
                                        <input type="hidden" name="address_id" value="{{ $address->id }}">
                                    </div>
                                @endif
                            @endforeach
                        @endif
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="order-details">
                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2>CART TOTAL</h2>
                                    <div class="content">
                                        <ul>
										    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Cart Subtotal<span>Rp{{number_format(Helper::totalCartPrice(),2)}}</span></li>
                                            <li class="shipping">
                                                Shipping Cost
                                                @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                                    <select name="shipping" class="nice-select" required>
                                                        <option value="">Select your address</option>
                                                        @foreach(Helper::shipping() as $shipping)
                                                        <option value="{{$shipping->id}}" class="shippingOption" data-price="{{$shipping->price}}">{{$shipping->type}}: Rp{{$shipping->price}}</option>
                                                        @endforeach
                                                    </select>
                                                @else 
                                                    <span>Free</span>
                                                @endif
                                                {{-- <select name="courier" class="nice-select" required>
                                                    <option value="">Select your address</option>
                                                    
                                                    @foreach($shippingCost['rajaongkir']['results'] as $shipping)
                                                        <option 
                                                            value="{{ $shipping['costs'][0]['service'] }}" 
                                                            class="shippingOption" 
                                                            data-price="{{ $shipping['costs'][0]['cost'][0]['value'] }}">
                                                            {{ $shipping['code'] }}: Rp{{ number_format($shipping['costs'][0]['cost'][0]['value'], 0, ',', '.') }}
                                                        </option>
                                                    @endforeach
                                                </select> --}}
                                            </li>
                                            
                                            @if(session('coupon'))
                                            <li class="coupon_price" data-price="{{session('coupon')['value']}}">You Save<span>Rp{{number_format(session('coupon')['value'],2)}}</span></li>
                                            @endif
                                            @php
                                                $total_amount=Helper::totalCartPrice();
                                                if(session('coupon')){
                                                    $total_amount=$total_amount-session('coupon')['value'];
                                                }
                                            @endphp
                                            @if(session('coupon'))
                                                <li class="last"  id="order_total_price">Total<span>Rp{{number_format($total_amount,2)}}</span></li>
                                            @else
                                                <li class="last"  id="order_total_price">Total<span>Rp{{number_format($total_amount,2)}}</span></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                                <!--/ End Order Widget -->
                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2>Payment Methods</h2>
                                    <div class="content">
                                    <div class="checkbox">
                                        
                                        <form-group>
                                            <input name="payment_method"  type="radio" value="cod" required> <label> Cash On Delivery</label><br>
                                            <!-- <input name="payment_method"  type="radio" value="paypal"> <label> PayPal</label><br> -->
                                            <input name="payment_method"  type="radio" value="online payment" required> <label> Online Payment/Transfer Bank</label><br>
                                        </form-group>
                                    </div>
                                </div>

                                </div>
                                <!--/ End Order Widget -->
                                
                                <!-- Button Widget -->
                                <div class="single-widget get-button">
                                    <div class="content">
                                        <div class="button">
                                            <button type="submit" class="bton">proceed to checkout</button>
                                        </div>
                                    </div>
                                </div>
                                <!--/ End Button Widget -->
                            </div>
                        </div>
                    </div>
                </form>
        </div>
    </section>
    <!--/ End Checkout -->
    
    
@endsection
@push('styles')
	<style>
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

        .address-card {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .address-card h3 {
            margin: 0;
            font-size: 16px;
        }
        .address-card p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .address-card .address a{
            color: #ff6f00;
            
            font-size: 20px;
        }
        .address-card .actions {
            text-align: right;
        }
        .address-card .actions a {
            display: block;
            margin-bottom: 10px;
            color: #ff6f00;
            text-decoration: none;
            font-size: 14px;
        }
        .address-card .actions .dflt {
            background: transparent;
            border: none;
            color: #007bff;
        }
        .address-card .actions .dlt  {
            background: transparent;
            border: none;
            color: #ff2f00;
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
		function showMe(box){
			var checkbox=document.getElementById('shipping').style.display;
			// alert(checkbox);
			var vis= 'none';
			if(checkbox=="none"){
				vis='block';
			}
			if(checkbox=="block"){
				vis="none";
			}
			document.getElementById(box).style.display=vis;
		}
	</script>
	<script>
		$(document).ready(function(){
			$('.shipping select[name=shipping]').change(function(){
				let cost = parseFloat( $(this).find('option:selected').data('price') ) || 0;
				let subtotal = parseFloat( $('.order_subtotal').data('price') ); 
				let coupon = parseFloat( $('.coupon_price').data('price') ) || 0; 
				// alert(coupon);
				$('#order_total_price span').text('Rp'+(subtotal + cost-coupon).toFixed(2));
			});

		});

	</script>

<script>
    $(document).ready(function() {
        $('input[name="payment_method"]').change(function() {
            if ($(this).val() === 'cardpay') {
                $('#creditCardDetails').show();
            } else {
                $('#creditCardDetails').hide();
            }
        });
    });
</script>

{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}


<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#select-provinsi').niceSelect();
    // Load Provinsi
    fetch('/wilayah/provinsi.json')
        .then(response => response.json())
        .then(data => {
            const provinsiSelect = document.getElementById('select-provinsi');
            data.forEach(provinsi => {
                const option = document.createElement('option');
                option.value = provinsi.id;
                option.textContent = provinsi.nama;
                console.log(`Menambahkan Provinsi: ${provinsi.nama} dengan ID: ${provinsi.id}`);
                provinsiSelect.appendChild(option);
            });
            console.log('Provinsi loaded:', data);
            // Memperbarui tampilan nice select
            if (typeof $.fn.niceSelect === 'function') {
                $(provinsiSelect).niceSelect('update');
            }
        })
        .catch(error => console.error('Error loading provinsi:', error));

    // Event listener for Provinsi change
    $('#select-provinsi').on('change', function () {
        const provinsiId = $(this).val();
        console.log(`Provinsi Id : `, provinsiId)
        const provinsiNama = $(this).find("option:selected").text();
        $('#provinsi-nama').val(provinsiNama); 
        console.log(`Provinsi Nama : `, provinsiNama)
        loadKabupaten(provinsiId);
        resetDropdowns(['select-kabupaten', 'select-kecamatan', 'select-kelurahan']); // Reset dropdown di bawahnya
        // $('#select-kecamatan').prop('disabled', true); // Nonaktifkan dropdown kecamatan
        // $('#select-kelurahan').prop('disabled', true); // Nonaktifkan dropdown kelurahan
    });

    // Function to load Kabupaten
    function loadKabupaten(provinsiId) {
        fetch(`/wilayah/kabupaten/${provinsiId}.json`)
            .then(response => response.json())
            .then(data => {
                const kabupatenSelect = document.getElementById('select-kabupaten');
                kabupatenSelect.innerHTML = '<option value="">- Pilih Kabupaten -</option>'; // Reset opsi
                data.forEach(kabupaten => {
                    const option = document.createElement('option');
                    option.value = kabupaten.id;
                    option.textContent = kabupaten.nama;
                    console.log(`Menambahkan Kabupaten: ${kabupaten.nama} dengan ID: ${kabupaten.id}`);
                    kabupatenSelect.appendChild(option);
                });
                kabupatenSelect.disabled = false; // Enable kabupaten dropdown
                console.log('Kabupaten loaded:', data);
                $(kabupatenSelect).niceSelect('update');
            })
            .catch(error => console.error('Error loading kabupaten:', error));
    }

    // Event listener for Kabupaten change
    $('#select-kabupaten').on('change', function () {
        const kabupatenId = $(this).val();
        console.log(`Kabupaten Id : `, kabupatenId)
        const kabupatenNama = $(this).find("option:selected").text();
        $('#kabupaten-nama').val(kabupatenNama);
        console.log(`Kabupaten Nama : `, kabupatenNama)
        loadKecamatan(kabupatenId);
        resetDropdowns(['select-kecamatan', 'select-kelurahan']);
    });

    // Function to load Kecamatan
    function loadKecamatan(kabupatenId) {
        fetch(`/wilayah/kecamatan/${kabupatenId}.json`)
            .then(response => response.json())
            .then(data => {
                const kecamatanSelect = document.getElementById('select-kecamatan');
                kecamatanSelect.innerHTML = '<option value="">- Pilih Kecamatan -</option>'; // Reset opsi
                data.forEach(kecamatan => {
                    const option = document.createElement('option');
                    option.value = kecamatan.id;
                    option.textContent = kecamatan.nama;
                    kecamatanSelect.appendChild(option);
                });
                kecamatanSelect.disabled = false; // Enable kecamatan dropdown
                console.log('Kecamatan loaded:', data);
                $(kecamatanSelect).niceSelect('update');
            })
            .catch(error => console.error('Error loading kecamatan:', error));
    }

    // Event listener for Kecamatan change
    $('#select-kecamatan').on('change', function () {
        const kecamatanId = $(this).val();
        console.log(`Kecamatan Id : `, kecamatanId)
        const kecamatanNama = $(this).find("option:selected").text();
        $('#kecamatan-nama').val(kecamatanNama);
        console.log(`Kecamatan Nama : `, kecamatanNama)
        loadKelurahan(kecamatanId);
        resetDropdowns(['select-kelurahan']);
    });

    // Function to load Kelurahan
    function loadKelurahan(kecamatanId) {
        fetch(`/wilayah/kelurahan/${kecamatanId}.json`)
            .then(response => response.json())
            .then(data => {
                const kelurahanSelect = document.getElementById('select-kelurahan');
                kelurahanSelect.innerHTML = '<option value="">- Pilih Kelurahan -</option>'; // Reset opsi
                data.forEach(kelurahan => {
                    const option = document.createElement('option');
                    option.value = kelurahan.id;
                    option.textContent = kelurahan.nama;
                    kelurahanSelect.appendChild(option);
                });
                kelurahanSelect.disabled = false; // Enable kelurahan dropdown
                console.log('Kelurahan loaded:', data);
                $(kelurahanSelect).niceSelect('update');
            })
            .catch(error => console.error('Error loading kelurahan:', error));
    }

    $('#select-kelurahan').on('change', function () {
        const kelurahanNama = $(this).find("option:selected").text();
        $('#kelurahan-nama').val(kelurahanNama);
        console.log(`Kelurahan Nama : `, kelurahanNama)
    });

    // Fungsi untuk mereset dropdown
    function resetDropdowns(dropdownIds) {
            dropdownIds.forEach(id => {
                const selectElement = document.getElementById(id);
                selectElement.innerHTML = '<option value="">- Pilih -</option>'; // Reset opsi
                selectElement.disabled = true; // Menonaktifkan dropdown
                $(selectElement).niceSelect('update'); // Memperbarui nice select
            });
        }
});

</script>


{{-- <script>
    // Ketika provinsi dipilih
    
    $(document).ready(function() {
    // Menginisialisasi Nice Select
    $('select').niceSelect();

    // Event listener untuk perubahan pada dropdown provinsi
    $('#province').on('change', function() {
        var provinceId = $(this).val();
        console.log('Provinsi ID yang dipilih:', provinceId);
        
        // Pastikan ID provinsi valid
        if (provinceId) {
            $.ajax({
                url: `/get-cities/${provinceId}`,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log('Data Kota:', data);
                    var citySelect = $('#city_id');
                    citySelect.empty(); // Clear previous options
                    citySelect.append('<option value="">- Pilih Kota -</option>'); // Add default option

                    // Add new options based on city data
                    if (data.length > 0) {
                        $.each(data, function(index, city) {
                            citySelect.append($('<option>', {
                                value: city.city_id,
                                text: city.city_name
                            }));
                        });
                    } else {
                        citySelect.append($('<option>', {
                            value: '',
                            text: 'Tidak ada kota tersedia'
                        }));
                    }
                    citySelect.niceSelect('update');
                },
                error: function(error) {
                    console.error('Error fetching cities:', error);
                }
            });
        } else {
            // Clear city dropdown if no province is selected
            $('#city_id').empty().append('<option value="">- Pilih Kota -</option>');
        }
    });
});

$(document).ready(function() {
    // Ketika ada perubahan pada kota tujuan
    $('#city_id').on('change', function() {
        var cityId = $(this).val();
        console.log('City ID selected:', cityId);
        
        // Ambil data produk di keranjang (misalnya dari session atau form)
        var cartItems = [
            { product_id: 1, quantity: 2 },
            { product_id: 2, quantity: 1 }
        ];

        // Kirim data ke backend menggunakan AJAX
        $.ajax({
            url: '/calculate-shipping-cost',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                destination: cityId,
                cart_items: cartItems
            },
            success: function(response) {
                console.log('Shipping cost data:', response);

                // Kosongkan dropdown terlebih dahulu
                var shippingSelect = $('select[name="courier"]');
                shippingSelect.empty();
                
                // Tambahkan opsi default
                shippingSelect.append('<option value="">Select your address</option>');

                // Tambahkan opsi ongkos kirim berdasarkan data yang diterima
                if (response.length > 0) {
                    $.each(response, function(index, shipping) {
                        var service = shipping['costs'][0]['service'];
                        var price = shipping['costs'][0]['cost'][0]['value'];
                        var formattedPrice = 'Rp' + price.toLocaleString('id-ID');  // Format harga ke IDR

                        // Append option untuk setiap service ongkos kirim
                        shippingSelect.append($('<option>', {
                            value: service,
                            class: 'shippingOption',
                            'data-price': price,
                            text: `${shipping['code']}: ${formattedPrice}`
                        }));
                    });
                } else {
                    shippingSelect.append('<option value="">Ongkos kirim tidak tersedia</option>');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error calculating shipping:', error);
                alert('Terjadi kesalahan dalam perhitungan ongkir');
            }
        });
    });
});
</script> --}}

@endpush