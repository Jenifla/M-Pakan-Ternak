@extends('frontend.pages.account.account')

@section('title','Account Uset || Dashboard')

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
                                    <label>Full Name<span>*</span></label>
                                    <input type="text" name="full_nama" placeholder="" value="{{ old('full_nama', $address->full_nama) }}" required>
                                    @error('full_nama')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Phone Number <span>*</span></label>
                                    <input type="text" name="no_hp" placeholder="" value="{{ old('no_hp', $address->no_hp) }}" required>
                                    @error('no_hp')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="select-provinsi">Provinsi <span>*</span></label>
                                    <select id="select-provinsi" name="provinsi" required>
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
                                    <select id="select-kabupaten" name="kabupaten" required>
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
                                    <select id="select-kecamatan" name="kecamatan" required>
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
                                    <select id="select-kelurahan" name="kelurahan" required>
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
                                    <label>Postal Code</label>
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
                                <button type="submit" class="btn-add">Update Address</button>
                            </div>
                        </div>
                    </div>
                
                </form>
            </div>
        </div>
    </div>
</div>
@endsection