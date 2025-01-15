@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Order Lists</h6>
    </div>
    <div class="card-body">
      <!-- Nav Tabs -->
      <ul class="nav nav-tabs" id="orderTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/orders/all') || !request()->route('tab') ? 'active' : '' }}" 
               href="{{ route('admin.orders', ['tab' => 'all', 'subtab' => '']) }}" role="tab" 
               aria-controls="all-orders" aria-selected="true">All Orders
                @if(!empty($orderCounts['all']) && $orderCounts['all'] > 0)
                    <span class="count-badge">({{ $orderCounts['all'] }})</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/orders/new') ? 'active' : '' }}" 
               href="{{ route('admin.orders', ['tab' => 'new', 'subtab' => '']) }}" role="tab" 
               aria-controls="new-orders" aria-selected="false">New Orders
                @if(!empty($orderCounts['new']) && $orderCounts['new'] > 0)
                    <span class="count-badge">({{ $orderCounts['new'] }})</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/orders/topay') ? 'active' : '' }}" 
               href="{{ route('admin.orders', ['tab' => 'topay', 'subtab' => '']) }}" role="tab" 
               aria-controls="topay-orders" aria-selected="false">To Pay
                @if(!empty($orderCounts['topay']) && $orderCounts['topay'] > 0)
                    <span class="count-badge">({{ $orderCounts['topay'] }})</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/orders/toship') ? 'active' : '' }}" 
               href="{{ route('admin.orders', ['tab' => 'toship', 'subtab' => '']) }}" role="tab" 
               aria-controls="toship-orders" aria-selected="false">To Ship
                @if(!empty($orderCounts['toship']) && $orderCounts['toship'] > 0)
                    <span class="count-badge">({{ $orderCounts['toship'] }})</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/orders/toreceive') ? 'active' : '' }}" 
               href="{{ route('admin.orders', ['tab' => 'toreceive', 'subtab' => '']) }}" role="tab" 
               aria-controls="toreceive-orders" aria-selected="false">To Receive
                @if(!empty($orderCounts['toreceive']) && $orderCounts['toreceive'] > 0)
                    <span class="count-badge">({{ $orderCounts['toreceive'] }})</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/orders/completed') ? 'active' : '' }}" 
               href="{{ route('admin.orders', ['tab' => 'completed', 'subtab' => '']) }}" role="tab" 
               aria-controls="completed-orders" aria-selected="false">Completed
                @if(!empty($orderCounts['completed']) && $orderCounts['completed'] > 0)
                    <span class="count-badge">({{ $orderCounts['completed'] }})</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/orders/canceled*') || request()->is('admin/orders/wait') ? 'active' : '' }}" 
               href="{{ route('admin.orders', ['tab' => 'canceled', 'subtab' => '']) }}" role="tab" 
               aria-controls="canceled-orders" aria-selected="false">Canceled
                @if(!empty($totalCount) && $totalCount > 0)
                    <span class="count-badge">({{ $totalCount}})</span>
                @endif
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('admin/orders/rejected') ? 'active' : '' }}" 
               href="{{ route('admin.orders', ['tab' => 'rejected', 'subtab' => '']) }}" role="tab" 
               aria-controls="rejected-orders" aria-selected="false">Rejected
                @if(!empty($orderCounts['rejected']) && $orderCounts['rejected'] > 0)
                    <span class="count-badge">({{ $orderCounts['rejected'] }})</span>
                @endif
            </a>
        </li>
    </ul>

    <div class="tab-content">
      @foreach(['all', 'new', 'topay', 'toship', 'toreceive', 'completed', 'canceled', 'rejected'] as $tab)
      <div class="tab-pane fade {{ request()->route('tab') == $tab || (!request()->route('tab') && $tab == 'all') ? 'show active' : '' }}" 
        id="{{ $tab }}-orders" role="tabpanel" 
        aria-labelledby="{{ $tab }}-orders-tab">
       @include('backend.order.' . $tab . '_orders', ['order' => ${$tab . 'Orders'}])
   </div>
      
      @endforeach
  </div>
    
      
    </div>
</div>
@endsection


