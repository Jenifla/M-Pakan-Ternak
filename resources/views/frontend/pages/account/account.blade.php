@extends('frontend.layouts.master')

@section('title','PT. Agro Apis Palacio || Akun Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Beranda<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Akun</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
            
   <!-- Account Cust -->
   <div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="row">
                    <div class="col-md-3">
                        @include('frontend.pages.account.sidebar')
                    </div>
                    <div class="col-md-9">
                        
                            @yield('account-content')
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Account Cust -->


<!-- Modal Structure -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <form class="form" method="POST" action="{{route('address.store')}}">
                    @csrf
                    @method('POST')
                    <div class="checkout-form">
                        <p>Alamat Baru</p>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Nama Lengkap<span>*</span></label>
                                    <input type="text" name="full_nama" placeholder="" value="{{old('full_nama')}}"  required>
                                    @error('full_nama')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    
                                    <label>Nomor Telepon <span>*</span></label>
                                    <input type="text" name="no_hp" placeholder="" required value="{{old('no_hp')}}">
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
                                        <option value="">- Pilih Kabupaten -</option>
                                    </select>
                                    <input type="hidden" id="kelurahan-nama" name="kelurahan">
                                    @error('kelurahan')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Kode Pos<span>*</span></label>
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
                    </div>
                    <div class="single-widget get-button">
                        <div class="content">
                            <div class="button">
                                <button type="submit" class="btn-add" >Simpan</button>
                            </div>
                        </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
      
          // Fungsi untuk menampilkan detail order berdasarkan orderId
          function showOrderDetail(orderId) {
            // Simulasi mengambil detail order berdasarkan ID (gunakan Ajax atau metode lain di sini)
            setTimeout(function() {
              // Gantikan konten dengan data detail order (misal, bisa ditarik dari server)
              $("#order-detail-content").html(`
                <p>Detail untuk Order ID: ${orderId}</p>
                <p>Order Description: This is a detailed description for order #${orderId}.</p>
                <p>Status: Pending</p>
                <p>Total: $100.00</p>
              `);
              // Hapus teks "Loading..."
              $("#loading-detail").remove();
            }, 1000);
          }
      
          // Saat tombol "View" diklik, tampilkan detail order dan sembunyikan daftar orders
          $(".view-order-btn").click(function() {
            var orderId = $(this).data("order-id");
            
            // Menampilkan konten detail order
            $("#order-details").removeClass("fade").addClass("show active");
            $("#orders").removeClass("show active").addClass("fade");
      
            // Panggil fungsi untuk menampilkan detail order berdasarkan orderId
            showOrderDetail(orderId);
          });
      
          // Saat tombol "Back to Orders" diklik, kembali ke tampilan daftar orders
          $(".back-to-orders-btn").click(function() {
            $("#order-details").removeClass("show active").addClass("fade");
            $("#orders").removeClass("fade").addClass("show active");
          });
      
        });
      </script>

      
    <script>
        $(document).ready(function() {
            // Optional: You can also manually trigger the modal if needed
            $('.btn-primary').click(function() {
                $('#addAddressModal').modal('show');
            });
        });
    </script>

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

@endsection
@push('styles')
<style>
    .page-content{
        margin-top: 150px;
        margin-bottom: 150px;
    }


    .dashboard-menu .nav-link {
    display: block;
    padding: 10px 20px;
    border: 1px solid #F7941D;
    border-radius: 20px;
    background-color: #f8f9fa;
    color: #333;
    margin-bottom: 10px;
    text-align: left;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.dashboard-menu .nav-link:hover {
    background-color: #ff2c2b;
    color: #fff;
}

.dashboard-menu .nav-link.active {
    background-color: #F7941D;
    color: white;
    border-color: #F7941D;
}

.card{
    border: none;
    width: 100%;
}

.card-header{
    background: transparent;
    border-bottom: none;
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
            border: 1px solid #666;
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
        .add-address {
            text-align: right;
            margin-bottom: 20px;
        }
        .add-address button {
            background-color: #F7941D;
            color: #fff;
            border: none;
            padding: 13px 32px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 30px;
        }
        .add-address button:hover{
            background-color: #ff2c2b;
        }
        .modal-body{
            margin-top: 5%;
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


 .checkout-form {
	margin-left: 5%;
    margin-right: 5%;
}
 .checkout-form h2 {
	font-size: 25px;
	color: #333;
	font-weight: 700;
	line-height: 27px;
}
.checkout-form p {
	font-size: 16px;
	color: #333;
	font-weight: 400;
	margin-top: 12px;
	margin-bottom: 30px;
}
 .form{}
.form .form-group {
	margin-bottom: 25px;
}
.form .form-group label{
	color:#333;
	position:relative;
}
.form .form-group label span {
	color: #ff2c18;
	display: inline-block;
	position: absolute;
	right: -12px;
	top: 4px;
	font-size: 16px;
}
.form .form-group input {
	width: 100%;
	height: 45px;
	line-height: 50px;
	padding: 0 20px;
	border-radius: 3px;
	border-radius: 0px;
	color: #333 !important;
	border: none;
	background: #F6F7FB;
}
.form .form-group input:hover{
	
}
.nice-select {
	width: 100%;
	height: 45px;
	line-height: 50px;
	margin-bottom: 25px;
	background: #F6F7FB;
	border-radius: 0px;
	border:none;
}
 .nice-select .list {
	width: 100%;
	height: 300px;
	overflow: scroll;
}
 .nice-select .list li{}
.nice-select .list li.option{
	color:#333;
}
 .nice-select .list li.option:hover{
	background:#F6F7FB;
	color:#333;
}
 .form .address input {
	margin-bottom: 15px;
}
 .form .address input:last-child{
	margin:0;
}
</style>
@endpush