@extends('frontend.pages.account.account')

@section('title','Account Uset || Dashboard')

@section('account-content')
<!-- Order Detail Content -->
<div>
<div class="card">
    <div class="card-header">
        <h5>Order Details</h5>
    </div>
    <div class="card-body">
        @if($order)
        <div class="order-status">
            <div class="status-header">
              <span class="status-dot"> Order ID: <strong>{{ $order->order_number }}</strong></span>
              {{-- <span class="status-text">With courier en route</span> --}}
              @if($order->status=='new')
                <span class="badge new-badge">New</span>
                @elseif($order->status=='to pay')
                <span class="badge custom-badge">To Pay</span>
                @elseif($order->status=='to ship')
                <span class="badge ship-badge">To Ship</span>
                @elseif($order->status=='to receive')
                <span class="badge ship-badge">To Receive</span>
                @elseif($order->status=='completed')
                <span class="badge complated-badge">Completed</span>
                @elseif($order->status=='cancel')
                <span class="badge new-badge">Cancel</span>
                @elseif($order->status=='rejected')
                <span class="badge new-badge">Rejected</span>
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
                <p>Order made</p>
                <span>{{ $order->date_order }}</span>
              </div>
              <div class="step {{ in_array($order->status, ['to ship',  'to receive', 'completed']) ? 'active' : '' }}">
                <div class="icon-li">
                    <i class="ti ti-money"></i>
                </div>
                <p>Order paid</p>
                <span>{{ $order->date_order }}</span>
              </div>
              <div class="step {{ in_array($order->status, ['to ship',  'to receive', 'completed']) ? 'active' : '' }}">
                <div class="icon-li">
                  <i class="fa fa-truck"></i>
                </div>
                <p>Shipped</p>
                <span>{{ $order->date_order}}</span>
              </div>
              <div class="step {{ in_array($order->status, ['to receive', 'completed']) ? 'active' : '' }}">
                <div class="icon-li">
                  <i class="fa fa-check-circle"></i>
                </div>
                <p>Complete</p>
                <span>{{ $order->date_order }}</span>
              </div>
            </div>
            @endif
        </div>
        <section class="confirmation_part section_padding">
          <div class="order_boxes">
            <div class="row">
                
                  
              <div class="col-lg-6 col-lx-4">
                <div class="order-info">
                <div class="orderan">
                  <h4 class="text-left pb-4">Customer & Order Info</h4>
                  <table class="table table-borderless">
                        <tr class="">
                            <td>Nama</td>
                            <td> : {{$order->user->name}}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td> : {{$order->user->email}} </td>
                        </tr>
                        {{-- <tr>
                            <td>Quantity</td>
                            <td> : {{$order->quantity}}</td>
                        </tr> --}}
                        {{-- <tr>
                            <td>Order Status</td>
                            <td> : {{$order->status}}</td>
                        </tr>
                        <tr>
                            <td>Shipping Charge</td>
                            <td> : Rp {{$order->shipping->price}}</td>
                        </tr> --}}
                        {{-- <tr>
                          <td>Coupon</td>
                          <td> : Rp {{number_format($order->coupon,2)}}</td>
                        </tr> --}}
                        {{-- <tr>
                            <td>Total Amount</td>
                            <td> : Rp {{number_format($order->total_amount,2)}}</td>
                        </tr> --}}
                        <tr>
                            <!-- <td>Payment Method</td>
                            <td> : @if($order->payment->method_payment=='cod') Cash on Delivery @else Online @endif</td> -->
                            <td>Payment Method</td>
                            <td> : 
                                @if($order->payment->method_payment == 'cod')
                                    Cash on Delivery
                                @elseif($order->payment->method_payment == 'online payment')
                                    Online Payment/Transfer Bank
                                @endif
                            </td>
    
                        </tr>
                        <!-- <tr>
                            <td>Payment Status</td>
                            <td> : {{$order->payment->status}}</td>
                        </tr> -->
                        <tr>
                          <td>Payment Status</td>
                          <td> : 
                              @if($order->payment->status == 'paid')
                                  <span class="badge badge-success">Paid</span>
                              @elseif($order->payment->status == 'unpaid')
                                  <span class="badge badge-danger">Unpaid</span>
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
                    <p><strong>Phone Number:</strong>{{ $order->address->no_hp }}</p>
                </div>
                </div>
              </div>
            </div>
          </div>
        </section>
    
        
        
        {{-- <table class="table">
          <thead>
            <tr>
                
                <th>Product</th>
                <th>Qty.</th>
                <th>Price</th>
                <th>Total</th>
                
            </tr>
          </thead>
          @foreach($order->cart as $cart)
          <tbody>
            <tr>
                
                <td>
                    <div class="prdct">
                        @if($cart->product->gambarProduk->isNotEmpty())
                        <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                        @else
                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        @endif
                    
                    <div class="product-info">
                    <p class="product-name">{{$cart->product->title}}</p>
                    <p class="product-des">{!!($cart->product->summary)!!}</p>
                    </div>
                    </div>
                </td>
                <td></td>
                <td></td>
                <td>
                    <div class="prdct-price">
                        <h3>Rp{{$cart->price}}</h3>
                        <p>x{{$cart->quantity}}</p>
                    </div>
                    
                </td>
                <td></td>
                
    
            </tr>
          </tbody>
          @endforeach
          <tbody>
            <tr>
                <td class="label">Order Tax</td>
                <td class="value"></td>
                <td class="value"></td>
                <td class="value">Rp 2550.00</td>
            </tr>
            <tr>
                <td class="label">Discount</td>
                <td class="value">0.00</td>
            </tr>
            <tr>
                <td class="label">Shipping</td>
                <td class="value">Rp {{$order->shipping->price}}</td>
            </tr>
            <tr>
                <td class="label">Total Amount</td>
                <td class="value">Rp {{number_format($order->total_amount,2)}}</td>
            </tr>
        </tbody>
        </table> --}}
        <h5 class="text-left p-3">Order Items</h5>
        <div class="item-product">
            
        @foreach($order->cart as $cart)
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
                        <p class="text-price">Rp {{ number_format($cart->price, 0, ',', '.') }}</p>
                        <p class="text-price">x{{ $cart->quantity }}</p>
                    </div>
                </div>
                <div class="price">
                    <h6 class="mb-0 ">Rp {{ number_format($cart->price, 0, ',', '.') }}</h6>
                        <p class="mb-0">x{{ $cart->quantity }}</p>
                </div>
            
        </div>
        @endforeach
        </div>
        <h6 class="text-left pb-3">Order Summary</h6>
        <div class="info-total">
            <div class="label">
                <a class="text-center">Subtotal Order</a>
                
            </div>
            <div class="info-price">
                <a class="mb-0">Rp{{ $cart->amount }}</a>
            </div>
        
        </div>
        <div class="info-total">
            <div class="label">
                <a class="mb-0">Shipping</a>
                
            </div>
            <div class="info-price">
                <a class="mb-0">Rp {{$order->shipping->price}}</a>
            </div>
        
        </div>
        <div class="info-total">
            <div class="label">
                <a class="mb-0">Total Amount</a>
                
            </div>
            <div class="info-price">
                <a class="mb-0">Rp {{number_format($order->total_amount,2)}}</a>
            </div>
        
        </div>
        
        {{-- <table class="table summary col-lg-4 col-sm-6 col-12 mt-4">
          <tbody>
              <tr>
                  <td class="label">Subtotal Order</td>
                  
                  <td class="value">Rp 2.000.000</td>
              </tr>
              <tr>
                  <td class="label">Discount</td>
                  <td></td>
                  <td></td>
                  <td class="value">0.00</td>
              </tr>
              <tr>
                  <td class="label">Shipping</td>
                  <td class="value">Rp {{$order->shipping->price}}</td>
              </tr>
              <tr>
                  <td class="label">Total Amount</td>
                  <td class="value">Rp {{number_format($order->total_amount,2)}}</td>
              </tr>
          </tbody>
      </table> --}}
      {{-- <div class="paid mt-3">
          Paid Rp 9680.65
      </div> --}}
        @endif
    
    </div>
    <button class=" btn">Back to Orders</button>
</div>
</div>
@endsection
@push('styles')
<style>
    /* Container */
.order-status {
  /* font-family: Arial, sans-serif;
  max-width: 800px; */
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
  /* width: 10px;
  height: 10px;
  background-color: orange;
  border-radius: 50%;
  display: inline-block; */
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
        
        /* flex-direction: row;
        gap: 20px; */
    }

    .info-product{
        display: flex;
        margin-bottom: 5px;
        padding: 10px;
        
        justify-content: space-between;
        /* flex-direction: row;
        gap: 20px; */
    }

    .info-total{
        display: flex;
        margin-bottom: 8px;
        
        justify-content: space-between;
        /* flex-direction: row;
        gap: 20px; */
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
        /* margin-top: 20px;
        margin-right: 20px; */
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