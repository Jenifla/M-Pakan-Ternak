@extends('frontend.pages.account.account')

@section('title','Account Uset || Dashboard')

@section('account-content')
<div >
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Your Orders</h3>
        </div>
        <div class="card-body">
            <!-- Additional Navigation for Order Status -->
            <ul class="nav nav-tabs" id="orderStatusTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="all-orders-tab" data-bs-toggle="tab" href="#all-orders" role="tab" aria-controls="all-orders" aria-selected="true">All Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="new-orders-tab" data-bs-toggle="tab" href="#new-orders" role="tab" aria-controls="new-orders" aria-selected="false">New</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="topay-orders-tab" data-bs-toggle="tab" href="#topay-orders" role="tab" aria-controls="topay-orders" aria-selected="false">To Pay</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toship-orders-tab" data-bs-toggle="tab" href="#toship-orders" role="tab" aria-controls="toship-orders" aria-selected="false">To Ship</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="toreceive-orders-tab" data-bs-toggle="tab" href="#toreceive-orders" role="tab" aria-controls="toreceive-orders" aria-selected="false">To Receive</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="completed-orders-tab" data-bs-toggle="tab" href="#completed-orders" role="tab" aria-controls="completed-orders" aria-selected="false">Completed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="cancelled-orders-tab" data-bs-toggle="tab" href="#cancelled-orders" role="tab" aria-controls="cancelled-orders" aria-selected="false">Cancelled</a>
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
                                            <span>Your order is under verification <strong></strong></span>
                                            @elseif($order->status=='to pay')
                                            <span>Please complete your payment before <strong>28-12-2024</strong></span>
                                            @elseif($order->status=='to ship')
                                            <span>Order will be shipped out by <strong>28-12-2024</strong></span>
                                            @elseif($order->status=='to receive')
                                            <span>Order will be Receive out by <strong>28-12-2024</strong></span>
                                            @elseif($order->status=='completed')
                                            <span>Order Receive at <strong>28-12-2024</strong></span>
                                            @elseif($order->status=='cancel')
                                            <span>Order Cancelled at <strong>28-12-2024</strong></span>
                                            @elseif($order->status=='rejected')
                                            <span>Order Rejected at <strong>28-12-2024</strong></span>
                                            @else
                                            <span class="badge new-badge">{{$order->status}}</span>
                                            @endif

                                    {{-- <span class="badge new-badge">New</span> --}}
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
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($cart->price, 0, ',', '.') }}</p>
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
                                            <a href="#" class="btn-contact-seller">Contact Seller</a>
                                            <a href="#" class="btn-cancel-order">Cancel Order</a>
                                            @elseif($order->status=='to pay')
                                            <a href="#" class="btn-contact-seller pay-now" data-order-id="{{ $order->id }}">Pay Now</a>
                                            <a href="#" class="btn-cancel-order">Cancel Order</a>
                                            @elseif($order->status=='to ship')
                                            <a href="#" class="btn-contact-seller">Contact Seller</a>
                                            <a href="#" class="btn-cancel-order">Cancel Order</a>
                                            @elseif($order->status=='to receive')
                                            <a href="#" class="btn-contact-seller">Order Received</a>
                                            <a href="#" class="btn-cancel-order">Contact Seller</a>
                                            @elseif($order->status=='completed')
                                            <a href="#" class="btn-contact-seller">Review</a>
                                            <a href="#" class="btn-cancel-order">Contact Seller</a>
                                            @elseif($order->status=='cancel')
                                            <a href="#" class="btn-contact-seller">Buy</a>
                                            <a href="#" class="btn-cancel-order">Contact Seller</a>
                                            @elseif($order->status=='rejected')
                                            <a href="#" class="btn-contact-seller">Buy</a>
                                            <a href="#" class="btn-cancel-order">Contact Seller</a>
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
                        <h6 class="text-center">No new orders found</h6>
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
                                    
                                        <span>Your order is under verification <strong></strong></span>
                                    
                                    <span class="badge new-badge">New</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($cart->price, 0, ',', '.') }}</p>
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
                                        <a href="#" class="btn-contact-seller">Contact Seller</a>
                                        <a href="#" class="btn-cancel-order">Cancel Order</a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">No new orders found</h6>
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
                                    
                                        <span>Please complete your payment before <strong>28-12-2024</strong></span>
                                    
                                    <span class="badge custom-badge">To Pay</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($cart->price, 0, ',', '.') }}</p>
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
                                        <a href="#" class="btn-contact-seller pay-now" data-order-id="{{ $order->id }}">Pay Now</a>
                                        <a href="#" class="btn-cancel-order">Cancel Order</a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">No new orders found</h6>
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
                                    
                                        <span>Order will be shipped out by <strong>28-12-2024</strong></span>
                                    
                                    <span class="badge ship-badge">To Ship</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($cart->price, 0, ',', '.') }}</p>
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
                                        <a href="#" class="btn-contact-seller">Contact Seller</a>
                                        <a href="#" class="btn-cancel-order">Cancel Order</a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">No orders to ship found</h6>
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
                                    
                                        <span>Order will be Receive out by <strong>28-12-2024</strong></span>
                                    
                                    <span class="badge ship-badge">To Receive</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($cart->price, 0, ',', '.') }}</p>
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
                                        <a href="#" class="btn-contact-seller">Order Received</a>
                                        <a href="#" class="btn-cancel-order">Contact Seller</a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">No orders to receive found</h6>
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
                                    
                                        <span>Order Receive at <strong>28-12-2024</strong></span>
                                    
                                    <span class="badge complated-badge">Completed</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($cart->price, 0, ',', '.') }}</p>
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
                                        <a href="#" class="btn-contact-seller">Review</a>
                                        <a href="#" class="btn-cancel-order">Contact Seller</a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">No complated orders found</h6>
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
                                    
                                        <span>Order Cancelled at <strong>28-12-2024</strong></span>
                                    
                                    <span class="badge new-badge">Cancel</span>
                                    </div>
                                </div>
                                <!-- Product Details -->
                                 <!-- Loop untuk setiap item di dalam cart -->
                                 <div class="info-product">
                                    @foreach($order->cart as $cart)
                                    <div class="prdct">
                                        @if($cart->product->gambarProduk->isNotEmpty())
                                            <img src="{{ asset($cart->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                                        @else
                                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $cart->product->title }}</h6>
                                            <p class="mb-0 text-muted">Rp {{ number_format($cart->price, 0, ',', '.') }}</p>
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
                                        <a href="#" class="btn-contact-seller">Buy</a>
                                        <a href="#" class="btn-cancel-order">Contact Seller</a>
                                    </div>
                                </div>
                                
                            </div>
                        </a>
                        @endforeach
                    @else
                        <h6 class="text-center">No cancelled orders found</h6>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
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

@endsection
@push('styles')
<style>
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

    .info-product{
        display: flex;
        flex-direction: column;
        
    }
    
}
</style>
@endpush

