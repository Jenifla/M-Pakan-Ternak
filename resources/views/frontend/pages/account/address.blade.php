@extends('frontend.pages.account.account')

@section('title','Akun User || Alamat')

@section('account-content')
<div >
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Alamat Pengiriman</h5>
            <div class="add-address">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">Tambah Alamat</button>
            </div>
        </div>
        <div class="card-body">
            @php
            $addresses = Helper::getAddresses();
            @endphp
            @if($addresses && count($addresses) > 0)
                @foreach($addresses as $key=>$address)
            <div class="address-card">
                <div class="address">
                    @if($address->is_default)
                    <a>Default</a>
                    @endif
                    <h3>{{ $address->full_nama }}</h3>
                    <p>{{ $address->kelurahan }}, {{ $address->detail_alamat }}<br>
                        {{ $address->kecamatan }}, {{ $address->kabupaten }}, {{ $address->provinsi }}, {{ $address->kode_pos }}</p>
                    <p><strong>Nomor Telepon:</strong>{{ $address->no_hp }}</p>
                </div>
                <div class="actions">
                    <a href="{{ route('address.get', $address->id) }}">Edit</a>
                    @if(!$address->is_default)
                    <form action="{{ route('set-default', $address->id) }}" method="POST">
                        @csrf
                        @method('POST') <!-- Menyertakan metode POST jika form mengubah data -->
                        <button type="submit" class="dflt">ATUR SEBAGAI DEFAULT</button>
                    </form>
                    @endif
                    <form action="{{ route('address.delete', $address->id) }}" method="POST">
                        @csrf
                        @method('delete') 
                        <button type="submit" class="dlt"><i class="ti-trash remove-icon"></i></button>
                    </form>
                </div>
            </div>
            @endforeach
            @else
            <a>Anda Tidak Memiliki Alamat</a>
            @endif
        </div>
    </div>
</div>





@endsection