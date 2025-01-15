@extends('frontend.pages.account.account')

@section('title','Akun User || Edit Alamat')

@section('account-content')
<div >
    <div >
        <div >
            <div >
                <form class="form" method="POST" action="{{ route('address.update', $address->id) }}">
                    @csrf
                    @method('PUT') <!-- Menggunakan PUT karena ini adalah pembaruan data -->
                    <div class="checkout-form">
                        <p>Edit Address</p>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Nama Lengkap<span>*</span></label>
                                    <input type="text" name="full_nama" placeholder="" value="{{ old('full_nama', $address->full_nama) }}" required>
                                    @error('full_nama')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Nomor Telepon <span>*</span></label>
                                    <input type="text" name="no_hp" placeholder="" value="{{ old('no_hp', $address->no_hp) }}" required>
                                    @error('no_hp')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="pilih-provinsi">Provinsi <span>*</span></label>
                                    <select id="pilih-provinsi" name="provinsi" required>
                                        <option value="{{ $address->provinsi }}" selected>{{ $address->provinsi }}</option>
                                        <!-- Additional options for provinces -->
                                    </select>
                                    <input type="hidden" id="provinsi-nama" name="provinsi" value="{{ $address->provinsi }}">
                                    @error('provinsi')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Kabupaten <span>*</span></label>
                                    <select id="pilih-kabupaten" name="kabupaten" required>
                                        <option value="{{ $address->kabupaten }}" selected>{{ $address->kabupaten }}</option>
                                        <!-- Additional options for kabupaten -->
                                    </select>
                                    <input type="hidden" id="kabupaten-nama" name="kabupaten" value="{{ $address->kabupaten }}">
                                    @error('kabupaten')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kecamatan -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Kecamatan <span>*</span></label>
                                    <select id="pilih-kecamatan" name="kecamatan" required>
                                        <option value="{{ $address->kecamatan }}" selected>{{ $address->kecamatan }}</option>
                                        <!-- Additional options for kecamatan -->
                                    </select>
                                    <input type="hidden" id="kecamatan-nama" name="kecamatan" value="{{ $address->kecamatan }}">
                                    @error('kecamatan')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kelurahan -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Kelurahan <span>*</span></label>
                                    <select id="pilih-kelurahan" name="kelurahan" required>
                                        <option value="{{ $address->kelurahan }}" selected>{{ $address->kelurahan }}</option>
                                        <!-- Additional options for kelurahan -->
                                    </select>
                                    <input type="hidden" id="kelurahan-nama" name="kelurahan" value="{{ $address->kelurahan }}">
                                    @error('kelurahan')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Kode Pos<span>*</span></label>
                                    <input type="text" name="kode_pos" value="{{ old('kode_pos', $address->kode_pos) }}">
                                    @error('kode_pos')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Detail Alamat<span>*</span></label>
                                    <input type="text" name="detail_alamat" value="{{ old('detail_alamat', $address->detail_alamat) }}">
                                    @error('detail_alamat')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Jenis Alamat<span>*</span></label>
                                    <select name="jenis_alamat" id="jenis-alamat" required>
                                        <option value="Rumah" {{ old('jenis_alamat', $address->jenis_alamat) == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                                        <option value="Kantor" {{ old('jenis_alamat', $address->jenis_alamat) == 'Kantor' ? 'selected' : '' }}>Kantor</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--/ End Form -->
                    </div>
                    <div class="single-widget get-button">
                        <div class="content">
                            <div class="button">
                                <button type="submit" class="btn-add">Perbarui Alamat</button>
                            </div>
                        </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#pilih-provinsi').niceSelect();
    // Load Provinsi
    fetch('/wilayah/provinsi.json')
        .then(response => response.json())
        .then(data => {
            const provinsiSelect = document.getElementById('pilih-provinsi');
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
    $('#pilih-provinsi').on('change', function () {
        const provinsiId = $(this).val();
        console.log(`Provinsi Id : `, provinsiId)
        const provinsiNama = $(this).find("option:selected").text();
        $('#provinsi-nama').val(provinsiNama); 
        console.log(`Provinsi Nama : `, provinsiNama)
        loadKabupaten(provinsiId);
        resetDropdowns(['pilih-kabupaten', 'pilih-kecamatan', 'pilih-kelurahan']); // Reset dropdown di bawahnya
        // $('#select-kecamatan').prop('disabled', true); // Nonaktifkan dropdown kecamatan
        // $('#select-kelurahan').prop('disabled', true); // Nonaktifkan dropdown kelurahan
    });

    // Function to load Kabupaten
    function loadKabupaten(provinsiId) {
        fetch(`/wilayah/kabupaten/${provinsiId}.json`)
            .then(response => response.json())
            .then(data => {
                const kabupatenSelect = document.getElementById('pilih-kabupaten');
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
    $('#pilih-kabupaten').on('change', function () {
        const kabupatenId = $(this).val();
        console.log(`Kabupaten Id : `, kabupatenId)
        const kabupatenNama = $(this).find("option:selected").text();
        $('#kabupaten-nama').val(kabupatenNama);
        console.log(`Kabupaten Nama : `, kabupatenNama)
        loadKecamatan(kabupatenId);
        resetDropdowns(['pilih-kecamatan', 'pilih-kelurahan']);
    });

    // Function to load Kecamatan
    function loadKecamatan(kabupatenId) {
        fetch(`/wilayah/kecamatan/${kabupatenId}.json`)
            .then(response => response.json())
            .then(data => {
                const kecamatanSelect = document.getElementById('pilih-kecamatan');
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
    $('#pilih-kecamatan').on('change', function () {
        const kecamatanId = $(this).val();
        console.log(`Kecamatan Id : `, kecamatanId)
        const kecamatanNama = $(this).find("option:selected").text();
        $('#kecamatan-nama').val(kecamatanNama);
        console.log(`Kecamatan Nama : `, kecamatanNama)
        loadKelurahan(kecamatanId);
        resetDropdowns(['pilih-kelurahan']);
    });

    // Function to load Kelurahan
    function loadKelurahan(kecamatanId) {
        fetch(`/wilayah/kelurahan/${kecamatanId}.json`)
            .then(response => response.json())
            .then(data => {
                const kelurahanSelect = document.getElementById('pilih-kelurahan');
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

    $('#pilih-kelurahan').on('change', function () {
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