@extends('frontend.pages.account.account')

@section('title','Akun User || Detail Pesanan')

@section('account-content')
<!-- Order Detail Content -->
<div>
<div class="card">
    <div class="card-header">
        <h5>Detail Pesanan  
            @if($order->status == 'completed' || $order->status == 'to_receive')
            <a href="{{route('order.invoice',$order->id)}}" 
            style="
                display: inline-block;
                padding: 7px 17px;
                margin-left: 10px;
                margin-bottom: 10px;
                font-size: 13px;
                font-weight: bold;
                color: #fff;
                background-color: #F7941D;
                border: 1px solid #F7941D;
                border-radius: 20px;
                text-decoration: none;
                text-align: center;
                transition: background-color 0.3s ease;
            " 
            class="float-right">
            Cetak Invoice
         </a>
         @endif

         @if($order && $order->refund && $order->refund->status == 'completed')
         <a href="javascript:void(0);" 
                    onclick="showPopup('{{ asset($order->refund->bukti_transfer) }}')"
            style="
                display: inline-block;
                padding: 7px 17px;
                font-size: 13px;
                margin-left: 10px;
                margin-bottom: 10px;
                font-weight: bold;
                color: #fff;
                background-color: #F7941D;
                border: 1px solid #F7941D;
                border-radius: 20px;
                text-decoration: none;
                text-align: center;
                transition: background-color 0.3s ease;
            " 
            class="float-right">
            Lihat Bukti Transfer
         </a>
         @endif
        </h5>
    </div>
    <div class="card-body">
        @if($order)
        <div class="order-status">
            <div class="status-header">
              <span class="status-dot"> Order ID: <strong>{{ $order->order_number }}</strong></span>
              {{-- <span class="status-text">With courier en route</span> --}}
              @if($order->status=='new')
                <span class="badge new-badge">Baru</span>
                @elseif($order->status=='to pay')
                <span class="badge custom-badge">Belum Bayar</span>
                @elseif($order->status=='to ship')
                <span class="badge ship-badge">Dikemas</span>
                @elseif($order->status=='to receive')
                <span class="badge ship-badge">Dikirim</span>
                @elseif($order->status=='completed')
                <span class="badge complated-badge">Selesai</span>
                @elseif($order->status=='cancel')
                <span class="badge new-badge">Dibatalkan</span>
                @elseif($order->status=='rejected')
                <span class="badge new-badge">Ditolak</span>
                @else
                <span class="badge new-badge">{{$order->status}}</span>
                @endif
            </div>
            @if(in_array($order->status, ['new', 'to pay', 'to ship', 'to receive', 'completed']))
            <div class="status-steps">
              <div class="step {{ in_array($order->status, ['new', 'to pay', 'to ship', 'to receive', 'completed']) ? 'active' : '' }}">
                <div class="icon-li">
                  <i class="ti ti-receipt"></i>
                </div>
                <p>Pesanan Dibuat</p>
                <span>{{ $order->date_order }}</span>
              </div>
              <div class="step {{ in_array($order->status, ['to ship',  'to receive', 'completed']) ? 'active' : '' }}">
                <div class="icon-li">
                    <i class="ti ti-money"></i>
                </div>
                <p>Pesanan Dibayarkan</p>
                <span>{{ $order->payment->date_payment }}</span>
              </div>
              <div class="step {{ in_array($order->status, [ 'to receive', 'completed']) ? 'active' : '' }}">
                <div class="icon-li">
                  <i class="fa fa-truck"></i>
                </div>
                <p>Pesanan Dikirimkan</p>
                <span>{{ $order->date_shipped}}</span>
              </div>
              <div class="step {{ in_array($order->status, ['completed']) ? 'active' : '' }}">
                <div class="icon-li">
                  <i class="fa fa-check-circle"></i>
                </div>
                <p>Pesanan Selesai</p>
                <span>{{ $order->date_received }}</span>
              </div>
            </div>
            @endif

            
            <div class="refund-steps">
                @if($order->refund && in_array($order->refund->status, ['pending', 'approved', 'completed']))
                <!-- Progress Bar -->
                <div class="progress-bar-container">
                    <div class="progress-step {{ in_array($order->refund->status, ['pending', 'approved', 'completed']) ? 'active' : '' }}">
                        <span class="dot"></span>
                        <span class="step-text">Pembatalan Diajukan</span>
                        <span class="step-date">{{ $order->cancel->tgl_diajukan }}</span>
                    </div>
                    <div class="progress-step {{ in_array($order->refund->status, ['approved', 'completed']) ? 'active' : '' }}">
                        <span class="dot"></span>
                        <span class="step-text">Pembatalan Disetujui</span>
                        <span class="step-date">{{ $order->cancel->tgl_diproses }}</span>
                    </div>
                    <div class="progress-step {{ $order->refund->status == 'completed' ? 'active' : '' }}">
                        <span class="dot"></span>
                        <span class="step-text">Dana Dikembalikan</span>
                        <span class="step-date">{{ $order->refund->date_transfer }}</span>
                    </div>
                </div>
                @endif
                
                <!-- Status Information -->
                <div class="status-info mt-4">
                    @if($order->refund && $order->refund->status == 'completed')
                        <h3 >Pengembalian Dana Selesai</h3>
                        <p>Dana sebesar Rp{{ number_format($order->refund->total_refund, 0, ',', '.') }} telah dikembalikan.</p>
                    @elseif($order->refund && $order->refund->status == 'approved')
                        <h3 >Pembatalan Disetujui</h3>
                        <p>Proses pengembalian dana sedang diproses.</p>
                    @elseif($order->refund && $order->refund->status == 'pending')
                        <h3 >Pembatalan Diajukan</h3>
                        <p>Menunggu persetujuan dari admin.</p>
                    @elseif($order->status == 'cancel')
                        <h3 >Pembatalan Berhasil</h3>
                        <p>pada {{ $order->date_cancel }}</p>
                    @endif
                </div>
            </div>
            
        </div>

        @if(!in_array($order->status, ['cancel', 'rejected']) || ($order->cancel && $order->cancel->status_pembatalan !== 'disetujui'))
        <section class="confirmation_part section_padding">
          <div class="order_boxes">
            <div class="row">
                
                  
              <div class="col-lg-6 col-lx-4">
                <div class="order-info">
                <div class="orderan">
                  <h4 class="text-left pb-4">Informasi Pembeli & Pesanan</h4>
                  <table class="table table-borderless">
                        <tr class="">
                            <td>Nama</td>
                            <td> : {{$order->user->name}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td> : {{$order->user->email}} </td>
                        </tr>
                        <tr>
                            <!-- <td>Payment Method</td>
                            <td> : @if($order->payment->method_payment=='cod') Cash on Delivery @else Online @endif</td> -->
                            <td>Metode Pembayaran</td>
                            <td> : 
                                @if($order->payment->method_payment == 'cod')
                                    Bayar Di Tempat
                                @elseif($order->payment->method_payment == 'online payment')
                                    Pembayaran Online/Transfer Bank
                                @endif
                            </td>
    
                        </tr>
                        <!-- <tr>
                            <td>Payment Status</td>
                            <td> : {{$order->payment->status}}</td>
                        </tr> -->
                        <tr>
                          <td>Status Pembayaran</td>
                          <td> : 
                              @if($order->payment->status == 'paid')
                                  <span class="badge badge-success">Terbayar</span>
                              @elseif($order->payment->status == 'unpaid')
                                  <span class="badge badge-danger">Belum Bayar</span>
                                @elseif($order->payment->status == 'pending')
                                <span class="badge badge-danger">Pending</span>
                            @elseif($order->payment->status == 'failed')
                            <span class="badge badge-danger">Gagal</span>
                              @else
                                  {{$order->payment_status}}
                              @endif
                          </td>
                      </tr>
    
                  </table>
                </div>
                </div>
              </div>
    
              <div class="col-lg-6 col-lx-4">
                <div class="shipping-info">
                <div class="shipp">
                  <h4 class="text-left pb-4">Alamat Pengiriman</h4>
                  <h6>{{ $order->address->full_nama }}</h6>
                    <p>{{ $order->address->kelurahan }}, {{ $order->address->detail_alamat }}<br>
                        {{ $order->address->kecamatan }}, {{ $order->address->kabupaten }}, {{ $order->address->provinsi }}, {{ $order->address->kode_pos }}</p>
                    <p><strong>Nomor Telepon:</strong>{{ $order->address->no_hp }}</p>
                </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        @endif
        <h5 class="text-left p-3">Item Pesanan</h5>
        <div class="item-product">
            @php
            $subtotal_cart = 0; // Inisialisasi subtotal
            $total_items = 0; // Inisialisasi jumlah total barang
            @endphp
            
        @foreach($order->cart as $cart)

            @php
            $original_price = $cart->product['price']; // Harga asli produk
            $discount = $cart->product['discount'] ?? 0; // Diskon produk
            $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
            $total_price = $price_after_discount * $cart->quantity;
            $subtotal_cart += $total_price; 
            $total_items += $cart->quantity;
            @endphp
        <div class="info-product">
                <div class="prdct">
                    @if($cart->product->gambarProduk->isNotEmpty())
                        <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                    @else
                        <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                    @endif
                    <div>
                        <h6 class="one-line-text">{{ $cart->product->title }}</h6>
                        <p class="one-text">{{strip_tags($cart->product->summary)}}</p>
                        <p class="text-price">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</p>
                        <p class="text-price">x{{ $cart->quantity }}</p>
                    </div>
                </div>
                <div class="price">
                    <h6 class="mb-0 ">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</h6>
                        <p class="mb-0">x{{ $cart->quantity }}</p>
                </div>
            
        </div>
        @endforeach
        </div>
        <h6 class="text-left pb-3">Ringkasan Pesanan</h6>
        <div class="info-total">
            <div class="label">
                <a class="text-center">Subtotal Pesanan</a>
                
            </div>
            <div class="info-price">
                <a class="mb-0">Rp{{ number_format($subtotal_cart, 0, ',', '.') }}</a>
            </div>
        
        </div>
        <div class="info-total">
            <div class="label">
                <a class="mb-0">Biaya Pengiriman</a>
                
            </div>
            <div class="info-price">
                <a class="mb-0">Rp 
                    @if ($order->shipping->status_biaya == 0)
                        {{ number_format($order->ongkir, 0, ',', '.') }}
                    @else
                        {{ number_format($order->shipping->price, 0, ',', '.') }}
                    @endif
                </a>                
            </div>
        
        </div>
        <div class="info-total">
            <div class="label">
                <a class="mb-0">Total Pesanan</a>
                
            </div>
            <div class="info-price">
                <a class="mb-0">Rp {{number_format($order->total_amount, 0, ',', '.')}}</a>
            </div>
        
        </div>
        @endif
    
        @if(in_array($order->status, ['cancel', 'rejected']))
        <div class="alasan">
        <a >Alasan : <span>{{ $order->alasan }}</span></a>
        </div>
        @endif
    </div>
    
    
</div>
</div>

<!-- Popup HTML -->
<div class="popup-overlay" id="popupOverlay" style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
">
    <div class="popup-content" style="
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        text-align: center;
        position: relative;
        max-width: 90%;
    ">
        <button class="close-btn" onclick="closePopup()" style="
            position: absolute;
            top: 10px;
            right: 10px;
            background: #f7941d;
            color: #fff;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            font-size: 18px;
            cursor: pointer;
        ">&times;</button>
        <img id="transferProofImage" src="" alt="Bukti Transfer" style="
        max-width: 400px; /* Membatasi lebar maksimum */
        max-height: 400px; /* Membatasi tinggi maksimum */
        width: auto; /* Menyesuaikan lebar agar tetap proporsional */
        height: auto; /* Menyesuaikan tinggi agar tetap proporsional */
        border-radius: 5px;
    ">
    
    </div>
</div>

<script>
    // Function to show the popup with the image
    function showPopup(imagePath) {
        const popupOverlay = document.getElementById('popupOverlay');
        const transferProofImage = document.getElementById('transferProofImage');

        // Set the image source
        transferProofImage.src = imagePath;

        // Show the popup
        popupOverlay.style.display = 'flex';
    }

    // Function to close the popup
    function closePopup() {
        const popupOverlay = document.getElementById('popupOverlay');
        popupOverlay.style.display = 'none';
    }
</script>
@endsection
@push('styles')
<style>

    .alasan{
        padding: 10px;
        border: 1px solid #eaeaea;
        border-radius: 10px;
        margin-top: 15px;
        width: 100%;
    }
    /* Container */
.order-status {

  border: 1px solid #eaeaea;
  border-radius: 20px;
  margin-bottom: 20px;
  padding: 20px;
}

/* Header */
.status-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.status-dot {
  
}

.status-text {
  font-size: 16px;
  color: #333;
  font-weight: bold;
}

.resi {
  font-size: 14px;
  color: #777;
}

/* Steps Container */
.status-steps {
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: relative;
}

.step {
  text-align: center;
  position: relative;
  flex: 1;
}

.step .icon-li {
  width: 40px;
  height: 40px;
  background-color: #ffd9c2;
  color: #ff5722;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto;
  font-size: 18px;
}

.step p {
  margin: 10px 0 5px;
  font-size: 14px;
  color: #333;
}

.step span {
  font-size: 12px;
  color: #aaa;
}

/* Active Step */
.step.active .icon-li {
  background-color: #ff5722;
  color: #fff;
}

.step.active p {
  color: #ff5722;
}

/* Shipped Step */
.step.active.shipped {
  border: 2px solid #ff5722;
  padding: 5px;
  border-radius: 8px;
}



    .order-link {
    text-decoration: none; /* Hilangkan underline */
    color: inherit; /* Warna teks sesuai dengan tema */
    display: block; /* Agar <a> membungkus seluruh card */
}

.order-link:hover .order-co {
    background-color: #f8f9fa; /* Warna saat hover pada card */
    cursor: pointer;
}

.order-info, .shipping-info{
    border: 1px solid #c2c1c1;
    border-radius: 20px;
}
.shipp, .orderan{
    padding: 20px;
}
    .order-co{
        /* border: 1px solid #7e7e7e; */
        border-radius: 20px;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 20px;
    }
    .order-co .d-flex {
        display: flex;
       justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .new-badge {
        background-color: #ffb30056;
        font-size: 12px;
        
        color: #ffbb00;
        /* Menambahkan border merah */
        border-radius: 15px;
        padding: 5px 10px;
    }

    .custom-badge {
    background-color: #ff000056;
    font-size: 12px;
    
    color: #ff2f00;
    /* Menambahkan border merah */
    border-radius: 15px;
    padding: 5px 10px;
    }

    .ship-badge {
        background-color: #0077ff56;
        font-size: 12px;
        
        color: #0048ff;
        /* Menambahkan border merah */
        border-radius: 15px;
        padding: 5px 10px;
    }

    .complated-badge {
        background-color: #00ff6e56;
        font-size: 12px;
        
        color: #00a62c;
        /* Menambahkan border merah */
        border-radius: 15px;
        padding: 5px 10px;
    }
    .item-product{
        
        border-top: 2px solid #c2c1c1;
        border-bottom: 2px solid #c2c1c1;
        margin-bottom: 20px;
    }

    .info-product{
        display: flex;
        margin-bottom: 5px;
        padding: 10px;
        
        justify-content: space-between;
    }

    .info-total{
        display: flex;
        margin-bottom: 8px;
        
        justify-content: space-between;

    }
    .prdct{
        /* margin-top: 20px; */
        display: flex;
        /* border: 1px solid #c2c1c1; */
        flex-direction: row;
        padding: 5px;
        border-radius: 10px;
        
    }
    .info-price{
    }
    .price{
        display: block;
 
    }
    .info-product .prdct .one-text p{
        display: block;
        
    }
    .info-product .prdct .text-price{
        display: none;
        
    }
    .order-total-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 10px; 
}

.order-total-container .order-total-text {
    color: #6c757d; /* Warna teks 'Order Total' */
    font-weight: normal;
}

.order-total-container .order-total-amount {
    color: #333; /* Warna untuk 'Rp' */
    font-weight: bold;
}
.order-total-container .btn-container {
    display: flex;
    flex-wrap: wrap;
    gap: 10px; /* Jarak antara tombol */
}

.order-total-container .btn-container .btn-contact-seller {
    background-color: #ff6f00; /* Warna tombol 'Contact Seller' */
    color: #fff;
    font-size: 14px; /* Ukuran font tombol */
    padding: 5px 15px; /* Padding atas-bawah 4px, kiri-kanan 12px */
    border-radius: 20px;
    /* margin-right: 8px; Jarak kanan */
}

.order-total-container .btn-container .btn-contact-seller:hover {
    background-color: #e0a800; /* Warna hover untuk 'Contact Seller' */
}

.order-total-container .btn-container .btn-cancel-order {
    font-size: 14px; /* Ukuran font tombol */
    padding: 5px 15px; /* Padding atas-bawah 4px, kiri-kanan 12px */
    border: 1px solid #ff6f00; /* Warna border tombol 'Cancel Order' */
    color: #6c757d; /* Warna teks tombol 'Cancel Order' */
    border-radius: 20px;
}

.order-total-container .btn-container .btn-cancel-order:hover {
    background-color: #f8f9fa; /* Warna background saat hover */
    border-color: #6c757d;
    color: #6c757d;
}


.progress-bar-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        /* margin-top: 10px; */
    }

    .progress-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .dot {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background-color: #ddd;
        margin-bottom: 5px;
        transition: background-color 0.3s ease;
    }

    .line {
        width: 60px;
        height: 4px;
        background-color: #ddd;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translateX(-50%);
        transition: background-color 0.3s ease;
    }

    .active .dot {
        background-color: #F7941D;
    }

    .active-line {
        background-color: #F7941D;
    }

    .step-text {
        margin-top: 5px;
        color: #333;
        font-size: 14px;
    }

    .step-date{
        font-size: 12px;
        color: #aaa;
    }

    .status-info h3 {
        font-size: 20px;
        color: #F7941D;
    }

@media only screen and (max-width: 465px) {
    .order-co .d-flex {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: flex-start;
    }
    .order-total-container{
        display: flex;
        flex-direction: column; /* Menyusun elemen secara vertikal */
        align-items: flex-start;
        justify-content: flex-start;
        gap: 10px;
    }
    .status-steps {
    display: none;
    }

    .refund-steps {
    display: none;
    }

    .info-product{
        display: flex;
        padding: 0px;
        flex-direction: column;
        
    }
    .price{
        display: none;
    }

    .info-product .prdct .one-line-text {
        max-width: 150px;
        white-space: nowrap;        /* Tidak membungkus teks */
        overflow: hidden;           /* Sembunyikan teks yang meluap */
        text-overflow: ellipsis;    /* Tambahkan ellipsis (...) pada teks yang terpotong */
                  /* Tentukan lebar maksimum */
    }

    .info-product .prdct .one-text {
        display: none;
        
    }

    .info-product .prdct .text-price{
        display: block;
        right: 0;
    }
    
}
</style>
@endpush