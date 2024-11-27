@extends('frontend.pages.account.account')

@section('title','Account Uset || Dashboard')

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
                    <a class="nav-link active" id="all-orders-tab" data-bs-toggle="tab" href="#all-orders" role="tab" aria-controls="all-orders" aria-selected="true">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="new-orders-tab" data-bs-toggle="tab" href="#new-orders" role="tab" aria-controls="new-orders" aria-selected="false">Pesanan Baru</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="topay-orders-tab" data-bs-toggle="tab" href="#topay-orders" role="tab" aria-controls="topay-orders" aria-selected="false">Belum Bayar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toship-orders-tab" data-bs-toggle="tab" href="#toship-orders" role="tab" aria-controls="toship-orders" aria-selected="false">Dikemas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toreceive-orders-tab" data-bs-toggle="tab" href="#toreceive-orders" role="tab" aria-controls="toreceive-orders" aria-selected="false">Dikirim</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="completed-orders-tab" data-bs-toggle="tab" href="#completed-orders" role="tab" aria-controls="completed-orders" aria-selected="false">Selesai</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cancelled-orders-tab" data-bs-toggle="tab" href="#cancelled-orders" role="tab" aria-controls="cancelled-orders" aria-selected="false">Pembatalan</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" id="processing-orders-tab" data-bs-toggle="tab" href="#processing-orders" role="tab" aria-controls="processing-orders" aria-selected="false">Return Refund</a>
                </li> --}}
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
                                        {{-- <a href="#" class="btn btn-link btn-sm text-decoration-none">Chat</a>
                                        <a href="#" class="btn btn-link btn-sm text-decoration-none">View Shop</a> --}}
                                    </div>
                                    <div>
                                    
                                        {{-- <span>Your order is under verification <strong></strong></span> --}}
                                    
                                            @if($order->status=='new')
                                                <span>Pesanan Anda sedang diverifikasi <strong></strong></span>
                                            @elseif($order->status=='to pay')
                                                <span>Harap selesaikan pembayaran sebelum <strong>{{ date('d-m-Y H:i:s', strtotime($order->paymentDeadline)) }}</strong></span>
                                            @elseif($order->status=='to ship')
                                                <span>Pesanan akan dikirim sebelum <strong>{{ date('d-m-Y', strtotime($order->shippedDeadline)) }}</strong></span>
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
                                            @else
                                                <span class="badge new-badge">{{$order->status}}</span>
                                            @endif

                                    {{-- <span class="badge new-badge">New</span> --}}
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
                                            <a href="#" class="btn-contact-seller">Hubungi Penjual</a>
                                            <a href="#" class="btn-cancel-order">Batalkan Pesanan</a>
                                            @elseif($order->status=='to pay')
                                            <a href="#" class="btn-contact-seller pay-now" data-order-id="{{ $order->id }}">Bayar Sekarang</a>
                                            <a href="#" class="btn-cancel-order">Batalkan Pesanan</a>
                                            @elseif($order->status=='to ship')
                                            <a href="#" class="btn-contact-seller">Hubungi Penjual</a>
                                            <a href="#" class="btn-cancel-order">Batalkan Pesanan</a>
                                            @elseif($order->status=='to receive')
                                            <a href="#" class="btn-contact-seller">Pesanan Diterima</a>
                                            <a href="#" class="btn-cancel-order">Hubungi Penjual</a>
                                            @elseif($order->status=='completed')
                                            <a href="#" class="btn-contact-seller">Beli Lagi</a>
                                            <a href="#" class="btn-cancel-order">Hubungi Penjual</a>
                                            @elseif($order->status=='cancel')
                                            <a href="#" class="btn-contact-seller">Beli Lagi</a>
                                            <a href="#" class="btn-cancel-order">Hubungi Penjual</a>
                                            @elseif($order->status=='rejected')
                                            <a href="#" class="btn-contact-seller">Beli Lagi</a>
                                            <a href="#" class="btn-cancel-order">Hubungi Penjual</a>
                                            @else
                                            <span class="badge new-badge">{{$order->status}}</span>
                                            @endif
                                        {{-- <a href="#" class="btn-contact-seller" data-order-id="{{ $order->id }}">Contact Seller</a>
                                        <a href="#" class="btn-cancel-order">Cancel Order</a> --}}
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ada pesanan yang ditemukan</h6>
                    @endif
                </div>
                {{-- <div class="tab-pane fade show active" id="all-orders" role="tabpanel" aria-labelledby="all-orders-tab">
                    <div class="table-responsive">
                        @if(count($orders)>0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{$order->order_number}}</td>
                                    <td>March 45, 2020</td>
                                    <td>
                                        @if($order->status=='new')
                                        <span class="badge badge-primary">NEW</span>
                                        @elseif($order->status=='process')
                                        <span class="badge badge-warning">PROCESSING</span>
                                        @elseif($order->status=='delivered')
                                        <span class="badge badge-success">DELIVERED</span>
                                        @else
                                        <span class="badge badge-danger">{{$order->status}}</span>
                                        @endif
                                    </td>
                                    <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                                    <td><a class="tn" href="{{route('frontend.pages.account.detailorder',$order->id)}}" >View</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h6 class="text-center">No orders found!!! Please order some products</h6>
                        @endif
                    </div>
                </div> --}}
                <!-- New Orders Tab -->
                {{-- <div class="tab-pane fade" id="new-orders" role="tabpanel" aria-labelledby="new-orders-tab">
                    <div class="table-responsive">
                         @php
                            $newOrders = $orders->where('status', 'new');
                        @endphp
                        @if($newOrders->count() > 0)
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($newOrders as $order)
                                <tr>
                                    <td>{{$order->order_number}}</td>
                                    <td>March 45, 2020</td>
                                    <td>
                                        @if($order->status=='new')
                                        <span class="badge badge-primary">NEW</span>
                                        @elseif($order->status=='process')
                                        <span class="badge badge-warning">PROCESSING</span>
                                        @elseif($order->status=='delivered')
                                        <span class="badge badge-success">DELIVERED</span>
                                        @else
                                        <span class="badge badge-danger">{{$order->status}}</span>
                                        @endif
                                    </td>
                                    <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                                    <td><a class="tn" href="{{route('frontend.pages.account.detailorder',$order->id)}}" >View</a></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h6 class="text-center">No orders found!!! Please order some products</h6>
                        @endif
                    </div>
                </div> --}}

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
                                        {{-- <a href="#" class="btn btn-link btn-sm text-decoration-none">Chat</a>
                                        <a href="#" class="btn btn-link btn-sm text-decoration-none">View Shop</a> --}}
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
                                        <a href="https://wa.me/62894567890?text=Hello+I+would+like+to+contact+you+about+my+order" class="btn-contact-seller">Hubungi Penjual</a>
                                        {{-- <button class="btn-contact-seller" >
                                            Hubungi Penjual
                                        </button> --}}
                                        {{-- <a href="#" class="btn-cancel-order">Cancel Order</a> --}}
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
                                        {{-- <a href="#" class="btn btn-link btn-sm text-decoration-none">Chat</a>
                                        <a href="#" class="btn btn-link btn-sm text-decoration-none">View Shop</a> --}}
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

                                        {{-- <a href="#" class="btn-cancel-order">Cancel Order</a> --}}
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
                <!-- To Pay Orders Tab -->
                {{-- <div class="tab-pane fade" id="topay-orders" role="tabpanel" aria-labelledby="topay-orders-tab">
                    <div class="table-responsive">
                        @php
                            $toPayOrders = $orders->where('status', 'to pay');
                        @endphp
                        @if($toPayOrders->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($toPayOrders as $order)
                                    <div class="card mb-3 p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <!-- Store and Contact Section -->
                                            <div>
                                                <span class="badge bg-danger text-white">Star+</span>
                                                <strong>{{ $order->store_name }}</strong>
                                                <a href="#" class="btn btn-link btn-sm text-decoration-none">Chat</a>
                                                <a href="#" class="btn btn-link btn-sm text-decoration-none">View Shop</a>
                                            </div>
                                            <div class="text-danger">TO SHIP</div>
                                        </div>
                                        <!-- Product Details -->
                                        <div class="d-flex mb-3">
                                            <img src="{{ asset($order->product_image) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-1">{{ $order->product_name }}</h6>
                                                <p class="mb-0 text-muted">Variation: {{ $order->product_variation }}</p>
                                                <p class="mb-0">x{{ $order->quantity }}</p>
                                                <span class="badge bg-success text-white mt-1">Free Return</span>
                                            </div>
                                            <div class="ms-auto text-end">
                                                <span class="text-muted text-decoration-line-through">Rp{{ number_format($order->original_price, 0, ',', '.') }}</span><br>
                                                <strong class="text-danger">Rp{{ number_format($order->discounted_price, 0, ',', '.') }}</strong>
                                            </div>
                                        </div>
                                        <!-- Shipping Info -->
                                        <div class="text-muted mb-2">
                                            Products will be shipped out by <strong></strong>
                                        </div>
                                        <!-- Order Total and Actions -->
                                        <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                            <div>
                                                <span class="text-muted">Order Total:</span>
                                                <strong class="text-danger">Rp{{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                                            </div>
                                            <div>
                                                <a href="" class="btn btn-warning btn-sm me-2">Contact Seller</a>
                                                <a href="" class="btn btn-outline-secondary btn-sm">Cancel Order</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h6 class="text-center">No orders to pay found!</h6>
                        @endif
                    </div>
                </div> --}}

                

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
                                        {{-- <a href="#" class="btn btn-link btn-sm text-decoration-none">Chat</a>
                                        <a href="#" class="btn btn-link btn-sm text-decoration-none">View Shop</a> --}}
                                    </div>
                                    <div>
                                    
                                        {{-- <span>Order will be shipped out by <strong>28-12-2024</strong></span>
                                    
                                    <span class="badge ship-badge">To Ship</span> --}}
                                    {{-- @if($order->cancel && $order->cancel->status_pembatalan == 'pending')
                                        <span>Pending, Pembatalan sedang diajukan</span>
                                        <span class="badge new-badge">Pending</span>
                                    @else
                                        <span>Order will be shipped out by <strong>28-12-2024</strong></span>
                                        <span class="badge ship-badge">To Ship</span>
                                    @endif --}}

                                   
                                    @if($order->cancel && $order->cancel->status_pembatalan == 'pending')
                                        <span>Pending, Pembatalan sedang diajukan</span>
                                        <span class="badge new-badge">Pending</span>
                                    @elseif($order->cancel && $order->cancel->status_pembatalan == 'disetujui')
                                        <span class="text-success">Pembatalan Disetujui</span>
                                        <span class="badge new-badge">Disetujui</span>
                                    @elseif($order->cancel && $order->cancel->status_pembatalan == 'ditolak')
                                    {{-- <span class="text-danger">Pembatalan Ditolak. Pesanan akan diproses lebih lanjut dan akan dikirim pada tanggal <strong>23-08-2024</strong>.</span> --}}
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
                                        <a href="https://wa.me/62894567890?text=Hello+I+would+like+to+contact+you+about+my+order" class="btn-contact-seller"> Hubungi Penjual</a>
                                        {{-- <button class="btn-contact-seller" >
                                            Hubungi Penjual
                                        </button> --}}
                                        {{-- <a href="#" class="btn-cancel-order">Cancel Order</a> --}}
                                        <button type="button" class="btn-cancel-order" onclick="document.getElementById('form-alasan-{{ $order->id }}').style.display = 'block';">
                                            Batalkan Pesanan
                                        </button>
                                    </div>
                                </div>
                                <form action="{{ route('cancel.order') }}" method="POST">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                                   
                            
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
                        <h6 class="text-center">Tidak ada pesanan untuk dikirim yang ditemukan</h6>
                    @endif
                </div>
                {{-- <div class="tab-pane fade" id="toship-orders" role="tabpanel" aria-labelledby="toship-orders-tab">
                    <div class="table-responsive">
                        @php
                            $toShipOrders = $orders->where('status', 'to ship');
                        @endphp
                        @if($toShipOrders->count() > 0)
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($toShipOrders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->created_at->format('F d, Y') }}</td>
                                            <td><span class="badge badge-success">TO SHIP</span></td>
                                            <td>Rp{{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                            <td><a class="tn" href="{{ route('frontend.pages.account.detailorder', $order->id) }}">View</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <h6 class="text-center">No orders to ship found!</h6>
                        @endif
                    </div>
                </div> --}}
                
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
                                        {{-- <a href="#" class="btn btn-link btn-sm text-decoration-none">Chat</a>
                                        <a href="#" class="btn btn-link btn-sm text-decoration-none">View Shop</a> --}}
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
                                        {{-- <a href="#" class="btn-contact-seller">Order Received</a> --}}
                                        <form action="{{ route('order.updatestatus', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" class="btn-contact-seller" title="Received" >Pesanan Diterima</button>
                                        </form>
                                        {{-- <button class="btn-cancel-order" >
                                            Contact Seller
                                        </button> --}}
                                        {{-- <button class="btn-cancel-order" onclick="window.open('https://wa.me/62894567890?text=Hello%20I%20would%20like%20to%20contact%20you%20about%20my%20order', '_blank')">
                                            Contact Seller
                                        </button> --}}
                                        <a href="https://wa.me/62894567890?text=Hello+I+would+like+to+contact+you+about+my+order" class="btn-cancel-order">Hubungi Penjual</a>
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
                                        {{-- <a href="#" class="btn btn-link btn-sm text-decoration-none">Chat</a>
                                        <a href="#" class="btn btn-link btn-sm text-decoration-none">View Shop</a> --}}
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
                                        {{-- <a href="#" class="btn-contact-seller">Buy</a> --}}
                                        <a href="https://wa.me/62894567890?text=Hello+I+would+like+to+contact+you+about+my+order" class="btn-cancel-order">Hubungi Penjual</a>
                                        {{-- <button class="btn-cancel-order" >
                                            Hubungi Penjual
                                        </button> --}}
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
                                        {{-- <a href="#" class="btn btn-link btn-sm text-decoration-none">Chat</a>
                                        <a href="#" class="btn btn-link btn-sm text-decoration-none">View Shop</a> --}}
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
                                        {{-- <a href="#" class="btn-contact-seller">Buy</a> --}}
                                        {{-- <a href="#" class="btn-cancel-order">Contact Seller</a> --}}
                                        <a href="https://wa.me/62894567890?text=Hello+I+would+like+to+contact+you+about+my+order" class="btn-cancel-order" >
                                            Hubungi Penjual
                                        </a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">Tidak ditemukan pesanan yang dibatalkan</h6>
                    @endif
                        
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Popup -->
{{-- <div class="modal fade" id="cancelOrderModal" tabindex="-1" role="dialog" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form Alasan -->
                <form id="resonForm">
                    <div class="form-group">
                        <label for="ala">Reason:</label>
                        <textarea id="ala" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="subb">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}
{{-- <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelOrderModalLabel">Cancel Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="reasonForm">
                    <div class="form-group">
                        <label for="cancelReason">Reason for Cancellation</label>
                        <textarea class="form-control" id="cancelReason" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger">Submit Reason</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}

{{-- <script>
   $(document).ready(function () {
    var currentForm; // To store the form that triggered the modal

    // Event listener for Cancel Order button
    $('.btn-cancel-order').click(function () {
        currentForm = $(this).closest('form'); // Get the form related to this button
        $('#cancelOrderModal').modal('show'); // Show the modal
    });

    // Handle form submission inside the modal
    $('#reasonForm').on('submit', function (e) {
        e.preventDefault(); // Prevent default modal form submission
        var reason = $('#cancelReason').val().trim(); // Get the entered reason

        if (reason === "") {
            alert("Reason is required!");
            return;
        }

        // Fill the hidden input in the actual form
        currentForm.find('input[name="alasan"]').val(reason);

        // Submit the original form
        currentForm.submit();
    });
});

</script> --}}
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
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script> --}}
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

