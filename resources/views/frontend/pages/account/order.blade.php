@extends('frontend.pages.account.account')

@section('title','Akun User || Pesanan Saya')

@section('account-content')
<div >
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Pesanan Anda</h3>
        </div>
        <div class="card-body">
            <!-- Additional Navigation for Order Status -->
            <ul class="nav nav-tabs" id="orderStatusTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-orders-tab" data-bs-toggle="tab" href="#all-orders" role="tab" aria-controls="all-orders" aria-selected="true">Semua
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="new-orders-tab" data-bs-toggle="tab" href="#new-orders" role="tab" aria-controls="new-orders" aria-selected="false">Pesanan Baru
                        @if(!empty($orderCounts['new']) && $orderCounts['new'] > 0)
                        <span class="count-badge">{{ $orderCounts['new'] }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="topay-orders-tab" data-bs-toggle="tab" href="#topay-orders" role="tab" aria-controls="topay-orders" aria-selected="false">Belum Bayar
                        @if(!empty($orderCounts['topay']) && $orderCounts['topay'] > 0)
                        <span class="count-badge">{{ $orderCounts['topay'] }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toship-orders-tab" data-bs-toggle="tab" href="#toship-orders" role="tab" aria-controls="toship-orders" aria-selected="false">Dikemas
                        @if(!empty($orderCounts['toship']) && $orderCounts['toship'] > 0)
                        <span class="count-badge">{{ $orderCounts['toship'] }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toreceive-orders-tab" data-bs-toggle="tab" href="#toreceive-orders" role="tab" aria-controls="toreceive-orders" aria-selected="false">Dikirim
                        @if(!empty($orderCounts['toreceive']) && $orderCounts['toreceive'] > 0)
                        <span class="count-badge">{{ $orderCounts['toreceive'] }}</span>
                        @endif
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="completed-orders-tab" data-bs-toggle="tab" href="#completed-orders" role="tab" aria-controls="completed-orders" aria-selected="false">Selesai
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cancelled-orders-tab" data-bs-toggle="tab" href="#cancelled-orders" role="tab" aria-controls="cancelled-orders" aria-selected="false">Pembatalan
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="rejected-orders-tab" data-bs-toggle="tab" href="#rejected-orders" role="tab" aria-controls="rejected-orders" aria-selected="false">Ditolak
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- All Orders Tab -->
                <div class="tab-pane fade show active" id="all-orders" role="tabpanel" aria-labelledby="all-orders-tab">
                    @if(count($orders) > 0)
                        @foreach($orders as $order)
                        <a href="{{route('frontend.pages.account.detailorder',$order->id)}}" class="order-link">
                            <div class="order-co mb-3 p-3">
                                <div class="d-flex">
                                    <!-- Store and Contact Section -->
                                    <div>
                                        <span >Order ID</span>
                                        <strong>{{ $order->order_number }}</strong>
                                
                                    </div>
                                    <div>
      
                                            @if($order->status=='new')
                                                <span>Pesanan Anda sedang diverifikasi <strong></strong></span>
                                            @elseif($order->status=='to pay')
                                                <span>Harap selesaikan pembayaran sebelum <strong>{{ date('d-m-Y H:i:s', strtotime($order->paymentDeadline)) }}</strong></span>
                                            @elseif($order->status=='to receive')
                                                <span>Pesanan sedang dalam perjalanan ke alamat tujuan <strong></strong></span>
                                            @elseif($order->status=='completed')
                                                <span>Pesanan diterima pada <strong>{{ date('d-m-Y', strtotime($order->date_received)) }}</strong></span>
                                            @elseif($order->status=='cancel')
                                                <span>Pesanan dibatalkan pada<strong>{{ date('d-m-Y', strtotime($order->date_cancel)) }}</strong></span>
                                            @elseif($order->status=='rejected')
                                                <span>Pesanan ditolak pada <strong>{{ date('d-m-Y', strtotime($order->date_cancel)) }}</strong></span>
                                            @elseif($order->cancel && $order->cancel->status_pembatalan == 'pending')
                                                <span>Pending, Pembatalan sedang diajukan</span>
                                            @elseif($order->cancel && $order->cancel->status_pembatalan == 'disetujui')
                                                <span class="text-success">Pembatalan Disetujui</span>
                                            @elseif($order->cancel && $order->cancel->status_pembatalan == 'ditolak')
                                                <span>Pembatalan Ditolak. Pesanan akan diproses lebih lanjut dan akan dikirim sebelum<strong>{{ date('d-m-Y', strtotime($order->shippedDeadline)) }}</strong>.</span>    
                                            @elseif($order->status=='refunded')
                                                <span>Pengembalian Dana Berhasil pada <strong>{{ date('d-m-Y', strtotime($order->refund->date_transfer)) }}</strong></span>
                                            @elseif($order->status=='to ship')
                                                <span>Pesanan akan dikirim sebelum <strong>{{ date('d-m-Y', strtotime($order->shippedDeadline)) }}</strong></span>
                                            @else
                                                <span class="badge new-badge">{{$order->status}}</span>
                                            @endif

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
                                            @elseif($order->cancel && $order->cancel->status_pembatalan == 'pending')
                                            <span class="badge new-badge">Pending</span>
                                            @elseif($order->cancel && $order->cancel->status_pembatalan == 'disetujui')
                                                <span class="badge new-badge">Disetujui</span>
                                            @elseif($order->cancel && $order->cancel->status_pembatalan == 'ditolak')
                                            <span class="badge ship-badge">Dikemas</span>      
                                            @else
                                            <span class="badge new-badge">{{$order->status}}</span>
                                            @endif
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    @php
                                    $original_price = $cart->product['price']; // Harga asli produk
                                    $discount = $cart->product['discount'] ?? 0; // Diskon produk
                                    $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
                                    @endphp
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</p>
                                            <p class="mb-0">x{{ $cart->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <!-- Shipping Info -->
                                
                                
                                <!-- Order Total and Actions -->
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Order Total:</span>
                                        <strong class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="btn-container" >
                                            @if($order->status=='new')
                                                <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-contact-seller">Hubungi Penjual</a>
                                                <button type="button" class="btn-cancel-order" onclick="document.getElementById('form-allalasan-{{ $order->id }}').style.display = 'block';">
                                                    Batalkan Pesanan
                                                </button>
                                            @elseif($order->status=='to pay')
                                                <a href="#" class="btn-contact-seller pay-now" data-order-id="{{ $order->id }}">Bayar Sekarang</a>
                                                <button type="button" class="btn-cancel-order" onclick="document.getElementById('form-allalasan-{{ $order->id }}').style.display = 'block';">
                                                    Batalkan Pesanan
                                                </button>
                                            @elseif($order->status=='to ship')
                                            <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-contact-seller"> Hubungi Penjual</a>
                                            @if(!$order->cancel)
                                            <button type="button" class="btn-cancel-order" onclick="document.getElementById('form-cancel-{{ $order->id }}').style.display = 'block';">
                                                Batalkan Pesanan
                                            </button>
                                            @endif
                                            @elseif($order->status=='to receive')
                                            <form action="{{ route('order.updatestatus', $order->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn-contact-seller" title="Received" >Pesanan Diterima</button>
                                            </form>
                                            <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-cancel-order">Hubungi Penjual</a>
                                            @elseif($order->status=='completed')
                                            <form action="{{route('buy.again', $order->id)}}" method="POST">
                                                @csrf 
                                                <button type="submit" class="btn-contact-seller">Beli Lagi</button>
                                            </form>
                                            <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-cancel-order">Hubungi Penjual</a>
                                            @elseif($order->status=='cancel')
                                            <form action="{{route('buy.again', $order->id)}}" method="POST">
                                                @csrf 
                                                <button type="submit" class="btn-contact-seller">Beli Lagi</button>
                                            </form>
                                            <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-cancel-order" >
                                                Hubungi Penjual
                                            </a>
                                            @elseif($order->status=='rejected')
                                            <form action="{{route('buy.again', $order->id)}}" method="POST">
                                                @csrf 
                                                <button type="submit" class="btn-contact-seller">Beli Lagi</button>
                                            </form>
                                            <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-cancel-order" >
                                                Hubungi Penjual
                                            </a>
                                            @else
                                            <span class="badge new-badge">{{$order->status}}</span>
                                            @endif
           
                                    </div>
                                </div>

                                <form action="{{ route('order.updatestatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="cancel">
                                    <!-- Form Alasan (Tersembunyi Secara Default) -->
                                    <div id="form-allalasan-{{ $order->id }}" style="display: none; margin-top: 10px;">
                                        <label for="alasan-textarea-{{ $order->id }}">Alasan Pembatalan:</label>
                                        <textarea name="alasan" id="alasan-textarea-{{ $order->id }}" class="form-control" rows="3" required></textarea>
                                        <button type="submit" class="btn mt-2">Ajukan Pembatalan</button>
                                        <button type="button" class="btn mt-2" onclick="document.getElementById('form-allalasan-{{ $order->id }}').style.display = 'none';">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                                <form action="{{ route('cancel.order') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                                    <div id="form-cancel-{{ $order->id }}" style="display: none; margin-top: 10px;">
                                        <label for="alasan-{{ $order->id }}">Alasan Pembatalan:</label>
                                        <textarea name="alasan" id="alasan-{{ $order->id }}" class="form-control" rows="3" required></textarea>
                                        @if($order->payment->method_payment == 'online payment')
                                        <label for="bank_name" class="mt-2">Nama Bank:</label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control" required>

                                        <label for="bank_account" class="mt-2">Nomor Rekening:</label>
                                        <input type="text" name="bank_account" id="bank_account" class="form-control" required>

                                        <label for="bank_holder" class="mt-2">Pemegang Rekening:</label>
                                        <input type="text" name="bank_holder" id="bank_holder" class="form-control" required>
                                        @endif
                                    
                                        <button type="submit" class="btn mt-2">Ajukan Pembatalan</button>
                                        <button type="button" class="btn mt-2" onclick="document.getElementById('form-cancel-{{ $order->id }}').style.display = 'none';">Batal</button>
                                    </div>
                                </form>
                                @if($order->cancel && $order->cancel->status_pembatalan == 'ditolak')
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Alasan:</span>
                                        <strong class="order-total-amount">{{ $order->cancel->alasan }}</strong>
                                    </div>
                                </div>
                                @elseif($order->status == 'cancel')
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Alasan:</span>
                                        <strong class="order-total-amount">{{ $order->alasan }}</strong>
                                    </div>
                                </div>
                                @endif
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ada pesanan yang ditemukan</h6>
                    @endif
                </div>


                <div class="tab-pane fade" id="new-orders" role="tabpanel" aria-labelledby="new-orders-tab">
                    @if(count($orders->where('status', 'new')) > 0)
                        @foreach($orders->where('status', 'new') as $order)
                        <a href="{{route('frontend.pages.account.detailorder',$order->id)}}" class="order-link">
                            <div class="order-co mb-3 p-3">
                                <div class="d-flex">
                                    <!-- Store and Contact Section -->
                                    <div>
                                        <span >Order ID</span>
                                        <strong>{{ $order->order_number }}</strong>
     
                                    </div>
                                    <div>
                                    
                                        <span>Pesanan Anda sedang diverifikasi<strong></strong></span>
                                    
                                    <span class="badge new-badge">Baru</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    @php
                                    $original_price = $cart->product['price']; // Harga asli produk
                                    $discount = $cart->product['discount'] ?? 0; // Diskon produk
                                    $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
                                    @endphp
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</p>
                                            <p class="mb-0">x{{ $cart->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <!-- Shipping Info -->
                                
                                
                                <!-- Order Total and Actions -->
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Order Total:</span>
                                        <strong class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="btn-container" >
                                        <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-contact-seller">Hubungi Penjual</a>
                                         <!-- Tombol untuk Cancel Order -->
                                         <button type="button" class="btn-cancel-order" onclick="document.getElementById('form-alasan-{{ $order->id }}').style.display = 'block';">
                                            Batalkan Pesanan
                                        </button>
                                       
                                       

                                    </div>
                                </div>
                                <form action="{{ route('order.updatestatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="cancel">
                            
                                   
                            
                                    <!-- Form Alasan (Tersembunyi Secara Default) -->
                                    <div id="form-alasan-{{ $order->id }}" style="display: none; margin-top: 10px;">
                                        <label for="alasan-textarea-{{ $order->id }}">Alasan Pembatalan:</label>
                                        <textarea name="alasan" id="alasan-textarea-{{ $order->id }}" class="form-control" rows="3" required></textarea>
                                        <button type="submit" class="btn mt-2">Ajukan Pembatalan</button>
                                        <button type="button" class="btn mt-2" onclick="document.getElementById('form-alasan-{{ $order->id }}').style.display = 'none';">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ada pesanan baru yang ditemukan</h6>
                    @endif
                </div>

                <div class="tab-pane fade" id="topay-orders" role="tabpanel" aria-labelledby="topay-orders-tab">
                    @if(count($orders->where('status', 'to pay')) > 0)
                        @foreach($orders->where('status', 'to pay') as $order)
                        <a href="{{route('frontend.pages.account.detailorder',$order->id)}}" class="order-link">
                            <div class="order-co mb-3 p-3">
                                <div class="d-flex">
                                    <!-- Store and Contact Section -->
                                    <div>
                                        <span >Order ID</span>
                                        <strong>{{ $order->order_number }}</strong>
                                    </div>
                                    <div>
                                    
                                        <span>Harap selesaikan pembayaran sebelum <strong>{{ date('d-m-Y H:i:s', strtotime($order->paymentDeadline)) }}</strong></span>
                                    
                                    <span class="badge custom-badge">Belum Bayar</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    @php
                                    $original_price = $cart->product['price']; // Harga asli produk
                                    $discount = $cart->product['discount'] ?? 0; // Diskon produk
                                    $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
                                    @endphp
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</p>
                                            <p class="mb-0">x{{ $cart->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <!-- Shipping Info -->
                                
                                
                                <!-- Order Total and Actions -->
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Order Total:</span>
                                        <strong class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="btn-container">
                                        <a href="#" class="btn-contact-seller pay-now" data-order-id="{{ $order->id }}">Bayar Sekarang</a>

                                        <button type="button" class="btn-cancel-order" onclick="document.getElementById('form-alasan-{{ $order->id }}').style.display = 'block';">
                                            Batalkan Pesanan
                                        </button>
                                    </div>
                                </div>
                                <form action="{{ route('order.updatestatus', $order->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="cancel">
                            
                                   
                            
                                    <!-- Form Alasan (Tersembunyi Secara Default) -->
                                    <div id="form-alasan-{{ $order->id }}" style="display: none; margin-top: 10px;">
                                        <label for="alasan-textarea-{{ $order->id }}">Alasan Pembatalan</label>
                                        <textarea name="alasan" id="alasan-textarea-{{ $order->id }}" class="form-control" rows="3" required></textarea>
                                        <button type="submit" class="btn mt-2">Ajukan Pembatalan</button>
                                        <button type="button" class="btn mt-2" onclick="document.getElementById('form-alasan-{{ $order->id }}').style.display = 'none';">
                                            Batal
                                        </button>
                                    </div>
                                </form>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ada pesanan belum bayar yang ditemukan</h6>
                    @endif
                </div>

                <!-- To Ship Orders Tab -->
                <div class="tab-pane fade" id="toship-orders" role="tabpanel" aria-labelledby="toship-orders-tab">
                    @if(count($orders->where('status', 'to ship')) > 0)
                        @foreach($orders->where('status', 'to ship') as $order)
                        <a href="{{route('frontend.pages.account.detailorder',$order->id)}}" class="order-link">
                            <div class="order-co mb-3 p-3">
                                <div class="d-flex">
                                    <!-- Store and Contact Section -->
                                    <div>
                                        <span >Order ID</span>
                                        <strong>{{ $order->order_number }}</strong>
                                    </div>
                                    <div>

                                   
                                    @if($order->cancel && $order->cancel->status_pembatalan == 'pending')
                                        <span>Pending, Pembatalan sedang diajukan</span>
                                        <span class="badge new-badge">Pending</span>
                                    @elseif($order->cancel && $order->cancel->status_pembatalan == 'disetujui')
                                        <span class="text-success">Pembatalan Disetujui</span>
                                        <span class="badge new-badge">Disetujui</span>
                                    @elseif($order->cancel && $order->cancel->status_pembatalan == 'ditolak')
                                    <span>Pembatalan Ditolak. Pesanan akan diproses lebih lanjut dan akan dikirim sebelum<strong>{{ date('d-m-Y', strtotime($order->shippedDeadline)) }}</strong>.</span>
                                    <span class="badge ship-badge">Dikemas</span>      
                                    @else
                                        <span>Pesanan akan dikirim sebelum <strong>{{ date('d-m-Y', strtotime($order->shippedDeadline)) }}</strong></span>
                                        <span class="badge ship-badge">Dikemas</span>
                                    @endif
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    @php
                                    $original_price = $cart->product['price']; // Harga asli produk
                                    $discount = $cart->product['discount'] ?? 0; // Diskon produk
                                    $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
                                    @endphp
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</p>
                                            <p class="mb-0">x{{ $cart->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <!-- Shipping Info -->
                                
                                
                                <!-- Order Total and Actions -->
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Order Total:</span>
                                        <strong class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="btn-container">
                                        <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-contact-seller"> Hubungi Penjual</a>
                                        @if(!$order->cancel)
                                        <button type="button" class="btn-cancel-order" onclick="document.getElementById('form-alasan-{{ $order->id }}').style.display = 'block';">
                                            Batalkan Pesanan
                                        </button>
                                        @endif
                                    </div>
                                </div>
                                @if($order->cancel && $order->cancel->status_pembatalan == 'ditolak')
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Alasan:</span>
                                        <strong class="order-total-amount">{{ $order->cancel->alasan }}</strong>
                                    </div>
                                </div>
                                @endif

                                <!-- Form Pembatalan -->
                                <form action="{{ route('cancel.order') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">

                                    <div id="form-alasan-{{ $order->id }}" style="display: none; margin-top: 10px;">
                                        <label for="alasan-{{ $order->id }}">Alasan Pembatalan:</label>
                                        <textarea name="alasan" id="alasan-{{ $order->id }}" class="form-control" rows="3" required></textarea>
                                        @if($order->payment->method_payment == 'online payment')
                                        <label for="bank_name" class="mt-2">Nama Bank:</label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control" required>

                                        <label for="bank_account" class="mt-2">Nomor Rekening:</label>
                                        <input type="text" name="bank_account" id="bank_account" class="form-control" required>

                                        <label for="bank_holder" class="mt-2">Pemegang Rekening:</label>
                                        <input type="text" name="bank_holder" id="bank_holder" class="form-control" required>
                                        @endif
                                    
                                        <button type="submit" class="btn mt-2">Ajukan Pembatalan</button>
                                        <button type="button" class="btn mt-2" onclick="document.getElementById('form-alasan-{{ $order->id }}').style.display = 'none';">Batal</button>
                                    </div>
                                </form>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ada pesanan untuk dikirim yang ditemukan</h6>
                    @endif
                </div>
                
                <!-- To Receive Orders Tab -->
                <div class="tab-pane fade" id="toreceive-orders" role="tabpanel" aria-labelledby="toreceive-orders-tab">
                    @if(count($orders->where('status', 'to receive')) > 0)
                        @foreach($orders->where('status', 'to receive') as $order)
                        <a href="{{route('frontend.pages.account.detailorder',$order->id)}}" class="order-link">
                            <div class="order-co mb-3 p-3">
                                <div class="d-flex">
                                    <!-- Store and Contact Section -->
                                    <div>
                                        <span >Order ID</span>
                                        <strong>{{ $order->order_number }}</strong>
                                    </div>
                                    <div>
                                    
                                        <span>Pesanan sedang dalam perjalanan ke alamat tujuan<strong></strong></span>
                                    
                                    <span class="badge ship-badge">Dikirim</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    @php
                                    $original_price = $cart->product['price']; // Harga asli produk
                                    $discount = $cart->product['discount'] ?? 0; // Diskon produk
                                    $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
                                    @endphp
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</p>
                                            <p class="mb-0">x{{ $cart->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <!-- Shipping Info -->
                                
                                
                                <!-- Order Total and Actions -->
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Order Total:</span>
                                        <strong class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="btn-container">
                                        <form action="{{ route('order.updatestatus', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn-contact-seller" title="Received" >Pesanan Diterima</button>
                                        </form>
                                        <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-cancel-order">Hubungi Penjual</a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ditemukan pesanan untuk diterima</h6>
                    @endif
                </div>

                <!-- Complated Orders Tab -->
                <div class="tab-pane fade" id="completed-orders" role="tabpanel" aria-labelledby="completed-orders-tab">
                    @if(count($orders->where('status', 'completed')) > 0)
                        @foreach($orders->where('status', 'completed') as $order)
                        <a href="{{route('frontend.pages.account.detailorder',$order->id)}}" class="order-link">
                            <div class="order-co mb-3 p-3">
                                <div class="d-flex">
                                    <!-- Store and Contact Section -->
                                    <div>
                                        <span >Order ID</span>
                                        <strong>{{ $order->order_number }}</strong>
                                    </div>
                                    <div>
                                    
                                        <span>Pesanan diterima pada<strong>{{ date('d-m-Y', strtotime($order->date_received)) }}</strong></span>
                                    
                                    <span class="badge complated-badge">Selesai</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    @php
                                    $original_price = $cart->product['price']; // Harga asli produk
                                    $discount = $cart->product['discount'] ?? 0; // Diskon produk
                                    $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
                                    @endphp
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</p>
                                            <p class="mb-0">x{{ $cart->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <!-- Shipping Info -->
                                
                                
                                <!-- Order Total and Actions -->
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Order Total:</span>
                                        <strong class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="btn-container">
                                        <form action="{{route('buy.again', $order->id)}}" method="POST">
                                            @csrf 
                                            <button type="submit" class="btn-contact-seller">Beli Lagi</button>
                                        </form>
                                        <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-cancel-order">Hubungi Penjual</a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ditemukan pesanan yang telah selesai</h6>
                    @endif
                </div>

                <!-- Cencelled Orders Tab -->
                <div class="tab-pane fade" id="cancelled-orders" role="tabpanel" aria-labelledby="cancelled-orders-tab"> 
                    @if(count($orders->where('status', 'cancel')) > 0)
                        @foreach($orders->where('status', 'cancel') as $order)
                        <a href="{{route('frontend.pages.account.detailorder',$order->id)}}" class="order-link">
                            <div class="order-co mb-3 p-3">
                                <div class="d-flex">
                                    <!-- Store and Contact Section -->
                                    <div>
                                        <span >Order ID</span>
                                        <strong>{{ $order->order_number }}</strong>
                                    </div>
                                    <div>
                                    
                                        <span>Pesanan dibatalkan pada <strong>{{ date('d-m-Y', strtotime($order->date_cancel)) }}</strong></span>
                                    
                                    <span class="badge new-badge">Dibatalkan</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                <!-- Loop untuk setiap item di dalam cart -->
                                <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    @php
                                    $original_price = $cart->product['price']; // Harga asli produk
                                    $discount = $cart->product['discount'] ?? 0; // Diskon produk
                                    $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
                                    @endphp
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</p>
                                            <p class="mb-0">x{{ $cart->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <!-- Shipping Info -->
                                
                                
                                <!-- Order Total and Actions -->
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Order Total:</span>
                                        <strong class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="btn-container">
                                        <form action="{{route('buy.again', $order->id)}}" method="POST">
                                            @csrf 
                                            <button type="submit" class="btn-contact-seller">Beli Lagi</button>
                                        </form>
                                        <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-cancel-order" >
                                            Hubungi Penjual
                                        </a>
                                    </div>
                                </div>
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Alasan:</span>
                                        <strong class="order-total-amount">{{ $order->alasan }}</strong>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ditemukan pesanan yang dibatalkan</h6>
                    @endif
                        
                </div>

                <!-- Refunded Orders Tab -->
                <div class="tab-pane fade" id="rejected-orders" role="tabpanel" aria-labelledby="rejected-orders-tab"> 
                    @if(count($orders->where('status', 'rejected')) > 0)
                        @foreach($orders->where('status', 'rejected') as $order)
                        <a href="{{route('frontend.pages.account.detailorder',$order->id)}}" class="order-link">
                            <div class="order-co mb-3 p-3">
                                <div class="d-flex">
                                    <!-- Store and Contact Section -->
                                    <div>
                                        <span >Order ID</span>
                                        <strong>{{ $order->order_number }}</strong>
                                    </div>
                                    <div>
                                    
                                        <span>Pesanan ditolak pada <strong>{{ date('d-m-Y', strtotime($order->date_cancel)) }}</strong></span>
                                    
                                    <span class="badge new-badge">Ditolak</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                <!-- Loop untuk setiap item di dalam cart -->
                                <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    @php
                                    $original_price = $cart->product['price']; // Harga asli produk
                                    $discount = $cart->product['discount'] ?? 0; // Diskon produk
                                    $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
                                    @endphp
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($price_after_discount, 0, ',', '.') }}</p>
                                            <p class="mb-0">x{{ $cart->quantity }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                                <!-- Shipping Info -->
                                
                                
                                <!-- Order Total and Actions -->
                                <div class="order-total-container">
                                    <div>
                                        <span class="order-total-text">Order Total:</span>
                                        <strong class="order-total-amount">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                    </div>
                                    <div class="btn-container">
                                        <form action="{{route('buy.again', $order->id)}}" method="POST">
                                            @csrf 
                                            <button type="submit" class="btn-contact-seller">Beli Lagi</button>
                                        </form>
                                        <a href="https://wa.me/{{ $admin->no_hp }}?text=Halo+Admin,+saya+{{ Auth::user()->name }},+dengan+nomor+pesanan+{{ $order->order_number }}.+Saya+ingin+menanyakan+tentang+pesanan+saya" class="btn-cancel-order" >
                                            Hubungi Penjual
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ditemukan pesanan yang ditolak</h6>
                    @endif
                        
                </div>

            </div>
        </div>
    </div>
</div>


<script>
    function showCancelForm(orderId, paymentMethod) {
        // Tampilkan formulir pembatalan
        document.getElementById(`cancel-form-${orderId}`).style.display = 'block';
        // Tampilkan input bank jika metode pembayaran adalah 'online'
        if (paymentMethod === 'online payment') {
            document.getElementById(`bank-info-${orderId}`).style.display = 'block';
        }
    }

    function hideCancelForm(orderId) {
        // Sembunyikan formulir pembatalan
        document.getElementById(`cancel-form-${orderId}`).style.display = 'none';
        document.getElementById(`bank-info-${orderId}`).style.display = 'none';
    }
</script>

<script>
    document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tabElement) {
  tabElement.addEventListener('click', function(event) {
    event.preventDefault();
    var tabTrigger = new bootstrap.Tab(tabElement);
    tabTrigger.show();
  });
});
</script>
<script>
    document.querySelectorAll('.pay-now').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const orderId = this.getAttribute('data-order-id');

        // Panggil endpoint untuk mendapatkan token transaksi
        fetch("{{ route('midtrans.token') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-Token": "{{ csrf_token() }}" // CSRF Token Laravel
            },
            body: JSON.stringify({
                order_id: orderId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.token) {
                // Panggil Snap Midtrans
                snap.pay(data.token, {
                    onSuccess: function(result) {
                        alert("Pembayaran sukses!");
                        window.location.reload();
                        console.log(result);
                    },
                    onPending: function(result) {
                        alert("Pembayaran tertunda.");
                        console.log(result);
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal.");
                        console.log(result);
                    },
                    onClose: function() {
                        alert("Anda menutup tanpa menyelesaikan pembayaran.");
                    }
                });
            } else {
                alert("Token gagal dibuat. Coba lagi.");
            }
        })
        .catch(error => console.error("Error:", error));
    });
});
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
@endsection
@push('styles')
<style>
    .modal-sm{
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1050; /* Pastikan modal berada di atas elemen lain */
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

    .nav-link {
        position: relative;
    }
    .nav-link .count-badge{
        position: absolute;
        top: 2px;
        right: 1px;
        background: #ff2c2b;
        width: 18px;
        height: 18px;
        line-height: 18px;
        text-align: center;
        color: #fff;
        border-radius: 100%;
        font-size: 11px;
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

    .info-product{
        display: grid;
        margin-bottom: 5px;
        border: 1px solid #c2c1c1;
        border-radius: 10px;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        padding: 5px;
        gap: 20px;
    }

    .prdct{
        display: flex;
        flex-direction: row;
        
    }
    .order-total-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
     /* Sesuaikan warna sesuai keinginan */
    padding-top: 10px; /* Ubah padding sesuai kebutuhan */
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
    padding: 10px 15px; /* Padding atas-bawah 4px, kiri-kanan 12px */
    border-radius: 20px;
    border: none;
    /* margin-right: 8px; Jarak kanan */
}

.order-total-container .btn-container .btn-contact-seller:hover {
    background-color: #e0a800; /* Warna hover untuk 'Contact Seller' */
}

.order-total-container .btn-container .btn-cancel-order {
    font-size: 14px; /* Ukuran font tombol */
    padding: 10px 15px; /* Padding atas-bawah 4px, kiri-kanan 12px */
    border: 1px solid #ff6f00; /* Warna border tombol 'Cancel Order' */
    color: #6c757d; /* Warna teks tombol 'Cancel Order' */
    border-radius: 20px;
    background-color: transparent;
}

.order-total-container .btn-container .btn-cancel-order:hover {
    background-color: #f8f9fa; /* Warna background saat hover */
    border-color: #6c757d;
    color: #6c757d;
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

    .info-product{
        display: flex;
        flex-direction: column;
        
    }
    
}
</style>
@endpush

