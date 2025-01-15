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
                            <li><a href="{{route('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
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
                                <h2>Selesaikan Pembelian Anda</h2>
                                <p>Tinggal beberapa langkah lagi untuk menyelesaikan pembelian Anda dengan aman!</p>
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
                                            <label>Kode Pos <span>*</span></label>
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
                                            <select name="jenis_alamat" id="jenis-alamat" required>
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
                                    <div class="address-card" data-kabupaten="{{ $address->kabupaten }}">
                                        <div class="address">
                                            {{-- <a href="{{ route('account-address') }}"><i class="ti-pencil"></i></a> --}}
                                            <a href="#" class="pen" data-bs-toggle="modal" data-bs-target="#addressModal">
                                                <i class="ti-pencil"></i>
                                            </a>
                                            
                                            <h3>{{ $address->full_nama }}</h3>
                                            <p>{{ $address->kelurahan }}, {{ $address->detail_alamat }}<br>
                                                {{ $address->kecamatan }}, {{ $address->kabupaten }}, {{ $address->provinsi }}, {{ $address->kode_pos }}</p>
                                            <p><strong>Nomor Telepon:</strong> {{ $address->no_hp }}</p>
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
                                    <h2>TOTAL KERANJANG</h2>
                                    <div class="content">
                                        <ul>
										    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Subtotal Keranjang<span>Rp{{number_format(Helper::totalCartPrice(), 0, ',', '.')}}</span></li>
                                            <li class="shipping">
                                                Biaya Pengiriman
                                                <select id="shipping-select" name="shipping" class="nice-select" required>
                                                    <option value="">- Pilih Pengiriman -</option>
                                                    <!-- Opsi pengiriman akan dimuat secara dinamis melalui JavaScript -->
                                                </select>
                                            </li>
                                            
                                            @php
                                                $total_amount=Helper::totalCartPrice();
                                                
                                            @endphp
                                            
                                                <li class="last"  id="order_total_price">Total<span>Rp{{number_format($total_amount, 0, ',', '.')}}</span></li>
                                           
                                        </ul>
                                    </div>
                                </div>
                                <!--/ End Order Widget -->
                                <!-- Order Widget -->
                                <div class="single-widget">
                                    <h2>Metode Pembayaran</h2>
                                    <div class="content">
                                    <div class="checkbox">
                                        
                                        <form-group>
                                            <input name="payment_method"  type="radio" value="cod" required> <label>Bayar Di Tempat</label><br>
                                            <input name="payment_method"  type="radio" value="online payment" required> <label> Pembayaran Online/Transfer</label><br>
                                        </form-group>
                                    </div>
                                </div>

                                </div>
                                <!--/ End Order Widget -->
                                
                                <!-- Button Widget -->
                                <div class="single-widget get-button">
                                    <div class="content">
                                        <div class="button">
                                            <button type="submit" class="bton">Proses Ke Checkout</button>
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
    
                                <!-- Modal Daftar Alamat -->
                                <div class="modal fade" id="addressModal" tabindex="-1" aria-labelledby="addressModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                              
                                                <button type="button" style="background: transparent; border: none; margin-right: 10px; font-size:20px;" data-bs-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
                                            </div>
                                            <div class="modal-body">
                                                <div id="address-list" style="padding: 30px;">
                                                    <h5 style="margin-bottom: 20px;" id="addressModalLabel">Alamat Saya</h5>
                                                    @foreach($user->addresses as $address)
                                                        <div class="address-card" data-id="{{ $address->id }}">
                                                            <div class="address">
                                                                <h3>{{ $address->full_nama }}</h3>
                                                                <p>{{ $address->kelurahan }}, {{ $address->detail_alamat }}<br>
                                                                    {{ $address->kecamatan }}, {{ $address->kabupaten }}, {{ $address->provinsi }}, {{ $address->kode_pos }}</p>
                                                                <p><strong>Nomor Telepon:</strong> {{ $address->no_hp }}</p>
                                                                <form action="{{ route('set-default', $address->id) }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="address_id" value="{{ $address->id }}">
                                                                    <button type="submit" style="background: transparent; border: none; color:#007bff;">Pilih Alamat</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#select-provinsi').niceSelect();
        const defaultAddressCard = document.querySelector('.address-card[data-kabupaten]');
        if (defaultAddressCard) {
            const kabupatenNama = defaultAddressCard.getAttribute('data-kabupaten');
            console.log(`Kabupaten dari data : `, kabupatenNama)
            loadShippingOptions(kabupatenNama); // Panggil fungsi dengan kabupaten yang diambil
        }
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
        // Load shipping options
        loadShippingOptions(kabupatenNama);
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

    function toTitleCase(str) {
    return str
        .toLowerCase() // Ubah semua huruf ke kecil
        .split(' ') // Pisahkan string menjadi array berdasarkan spasi
        .map(word => word.charAt(0).toUpperCase() + word.slice(1)) // Ubah huruf pertama tiap kata menjadi besar
        .join(' '); // Gabungkan kembali array menjadi string
    }

    function normalizeString(str) {
        return toTitleCase(
            str
                .replace(/Kab\.|Kota|\/|,/gi, '') // Hilangkan "KAB.", "KOTA", dan tanda baca
                .trim() // Hilangkan spasi di awal/akhir
        );
    }

    function formatRupiah(number) {
    return `Rp${number.toLocaleString('id-ID')}`;
    }


    // Function to load shipping options
    function loadShippingOptions(kabupatenNama) {
        const normalizedKabupaten = normalizeString(kabupatenNama);
        console.log("kabupaten untuk shipp: ", normalizedKabupaten)
        console.log("loadShippingOptions telah dipanggil dengan kabupaten: ", kabupatenNama);
        fetch('/get/shipping?kabupaten=' + encodeURIComponent(normalizedKabupaten)) // Ensure the query is formatted properly
        .then(function(response) {
            if (!response.ok) {
                // If response is not OK, log more details about the error
                return response.text().then(text => {
                    console.error('HTTP Error:', response.status, response.statusText);
                    console.error('Response body:', text);
                    throw new Error(`HTTP error! Status: ${response.status}`);
                });
            }
            return response.json(); // If OK, parse JSON data
        })
        .then(function(data) {
                console.log("data shipp: ", data)
                const shippingSelect = document.getElementById('shipping-select');
                shippingSelect.innerHTML = ''; // Reset opsi
                if (data.length === 1) {
                    // Jika hanya ada satu opsi, pilih otomatis
                    const shipping = data[0];
                    const shippingPrice = shipping.price !== null ? shipping.price : 0; // Gunakan 0 jika null
                    console.log("shippingPrice: ", shippingPrice)
                    const shippingText = shipping.price !== null ? `Rp${shippingPrice}` : 'Belum Diketahui';
                    const option = document.createElement('option');
                    option.value = shipping.id;
                    option.textContent = `${shipping.type}: ${shippingText}`;
                    option.setAttribute('data-price', shipping.price);
                    shippingSelect.appendChild(option);
                    
                    // Pilih opsi ini
                    shippingSelect.selectedIndex = 0;

                    // Trigger perubahan otomatis untuk menghitung total
                    updateTotalPrice(shipping.price);
                    $(shippingSelect).niceSelect('update');
                } else if (data.length > 1) {
                    // Jika ada beberapa opsi, tambahkan ke dropdown
                    data.forEach(shipping => {
                        const option = document.createElement('option');
                        option.value = shipping.id;
                        option.textContent = `${shipping.type}: Rp${shipping.price}`;
                        option.setAttribute('data-price', shipping.price);
                        shippingSelect.appendChild(option);
                    });
                    $(shippingSelect).niceSelect('update');
                } else {
                    // Jika tidak ada opsi pengiriman
                    const noOption = document.createElement('option');
                    noOption.value = '';
                    noOption.textContent = 'Pengiriman tidak tersedia';
                    shippingSelect.appendChild(noOption);
                }
                console.log('Shipping options loaded:', data);
            })
            .catch(error => console.error('Error loading shipping options:', error));
    }

    // Fungsi untuk memperbarui total harga
    function updateTotalPrice(shippingPrice = 0) {
        const cartSubtotalElement = document.querySelector('.order_subtotal');
        const cartSubtotal = parseFloat(cartSubtotalElement.getAttribute('data-price'));
        
        let shipping = parseFloat(shippingPrice); // Ubah shippingPrice ke angka
        if (isNaN(shipping)) {
            shipping = 0; // Jika tidak bisa dikonversi menjadi angka, set ke 0
        }
        console.log(' cartSubtotal :', cartSubtotal);
        console.log(' shippingPrice dari update :', shipping);
        

        // Hitung total keseluruhan
        const grandTotal = cartSubtotal + shipping;
        const formattedGrandTotal = new Intl.NumberFormat('id-ID').format(grandTotal);

        // Perbarui elemen total
        const cartTotalElement = document.querySelector('#order_total_price span');
        cartTotalElement.textContent = `Rp${formattedGrandTotal}`;
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

@endpush