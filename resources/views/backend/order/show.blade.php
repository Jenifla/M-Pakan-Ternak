@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">
<h5 class="card-header">Order Detail      <a href="{{route('order.pdf',$order->id)}}" class=" btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate PDF</a>
  </h5>
  <div class="card-body">
    @if($order)
    
    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h4 class="text-center pb-4">Order Info</h4>
              <table class="table table-borderless">
                    <tr class="">
                        <td>Order Number</td>
                        <td> : {{$order->order_number}}</td>
                    </tr>
                    <tr>
                        <td>Order Date</td>
                        <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}} </td>
                    </tr>
                    <tr>
                        <td>Order Status</td>
                        <td> : 
                            @if($order->status=='new')
                            <span class="badge badge-warning">NEW</span>
                            @elseif($order->status=='to pay')
                            <span class="badge badge-danger">To Pay</span>
                            @elseif($order->status=='to ship')
                            <span class="badge badge-primary">To Ship</span>
                            @elseif($order->status=='to receive')
                            <span class="badge badge-primary">To Receive</span>
                            @elseif($order->status=='completed')
                            <span class="badge badge-success">Completed</span>
                            @elseif($order->status=='cancel')
                            <span class="badge badge-warning">Cancel</span>
                            @else
                            <span class="badge badge-warning">Rejected</span>
                            {{-- <span class="badge badge-primary">{{$order->status}}</span> --}}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <!-- <td>Payment Method</td>
                        <td> : @if($order->payment->method_payment=='cod') Cash on Delivery @else Paypal @endif</td> -->
                        <td>Payment Method</td>
                        <td> : 
                            @if($order->payment->method_payment == 'cod')
                                Cash on Delivery
                            @elseif($order->payment->method_payment == 'online payment')
                                Online Payment/Transfer
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

          <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h4 class="text-center pb-4">Customer Info</h4>
              <table class="table table-borderless">
                    <tr class="">
                        <td>Full Name</td>
                        <td> : {{$order->user->name}}</td>
                    </tr>
                    <tr>
                        <td>Phone No.</td>
                        <td> : {{$order->user->no_hp}}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td> : {{$order->user->email}}</td>
                    </tr>
              </table>
              <h4 class="text-center pb-4">Shipping Info</h4>
              <table class="table table-borderless">
                    <tr>
                        {{-- <td>Address</td> --}}
                        <td><strong>{{ $order->address->full_nama }}</strong><br>{{ $order->address->kelurahan }}, {{ $order->address->detail_alamat }}<br>
                            {{ $order->address->kecamatan }}, {{ $order->address->kabupaten }}, {{ $order->address->provinsi }}, {{ $order->address->kode_pos }}<br>
                        <strong>Phone Number:</strong>{{ $order->address->no_hp }}
                        </td>
                    </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>

    <h4 class="text-center pb-4">Product Details</h4>
  <div class="table-responsive">
    <table class="table table-striped table-hover">
      <thead>
        <tr>
            <th>Product</th>
            <th>Qty.</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @php
            $subtotal_cart = 0; // Inisialisasi subtotal
            $total_items = 0; // Inisialisasi jumlah total barang
        @endphp
        @foreach($order->cart as $cart)
        @php
        $original_price = $cart->product['price']; // Harga asli produk
        $discount = $cart->product['discount']; // Diskon produk
        $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
        $total_price = $price_after_discount * $cart->quantity;
        $subtotal_cart += $total_price; 
        $total_items += $cart->quantity;
        @endphp
        <tr>
            {{-- <td>{{$cart->id}}</td> --}}
            <td>
                @if($cart->product->gambarProduk->isNotEmpty())
                <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
            @else
                <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
            @endif
            <div>
                <h6 class="one-line-text">{{ $cart->product->title }}</h6>
                
            </div></td>
            <td>{{$cart->quantity}}</td>
            <td>Rp{{$price_after_discount}}</td>
            <td>Rp{{number_format($total_price,2)}}</td>

        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
    <table class="table summary mt-4">
      <tbody>
          <tr>
              <td class="label">Subtotal Product</td>
              <td class="value">Rp{{number_format($subtotal_cart,2)}}</td>
          </tr>
          <tr>
              <td class="label">Shipping Cost</td>
              <td class="value">Rp
                @if ($order->shipping->status_biaya == 0)
                        {{ $order->ongkir, 0, ',', '.' }}
                    @else
                        {{ $order->shipping->price, 0, ',', '.' }}
                    @endif
              </td>
          </tr>
          <tr>
              <td class="label">Order Total</td>
              <td class="value">Rp{{number_format($order->total_amount,2)}}</td>
          </tr>
      </tbody>
  </table>
    @endif

  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#f8f9fc;
        padding: 20px;
        /* border: 5px solid #333; */
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px; 
    }
    .order-info h4,.shipping-info h4{
        /* text-decoration: underline; */
    }

    .summary {
            width: 100%;
            max-width: 400px;
            margin-left: auto;
        }
        .summary td {
          /* padding: 10px 15px; */
        }
        .summary .label {
            text-align: left;
            padding-right: 20px;
            font-weight: bold;
        }
        .summary .value {
            text-align: left;
            font-weight: bold;
        }
        .paid {
            font-size: 24px;
            font-weight: bold;
            text-align: right;
        }

        @media (max-width: 768px) {
        .order-info, .shipping-info {
            padding: 15px;
        }
        .summary {
            max-width: 100%;
        }
    }

</style>
@endpush
