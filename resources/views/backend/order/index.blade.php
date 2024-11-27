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
            <a class="nav-link show active" id="all-orders-tab" data-toggle="tab" href="#all-orders" role="tab" aria-controls="all-orders" aria-selected="true">All Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="new-orders-tab" data-toggle="tab" href="#new-orders" role="tab" aria-controls="new-orders" aria-selected="false">New Orders</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="topay-orders-tab" data-toggle="tab" href="#topay-orders" role="tab" aria-controls="topay-orders" aria-selected="false">To Pay</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="toship-orders-tab" data-toggle="tab" href="#toship-orders" role="tab" aria-controls="toship-orders" aria-selected="false">To Ship</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="toreceive-orders-tab" data-toggle="tab" href="#toreceive-orders" role="tab" aria-controls="toreceive-orders" aria-selected="false">To Receive</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="completed-orders-tab" data-toggle="tab" href="#completed-orders" role="tab" aria-controls="completed-orders" aria-selected="false">Completed</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="canceled-orders-tab" data-toggle="tab" href="#canceled-orders" role="tab" aria-controls="canceled-orders" aria-selected="false">Cancel/Reject</a>
        </li>

    </ul>

    <div class="tab-content">
      <!-- New Orders Table -->
      <div class="tab-pane fade show active" id="all-orders" role="tabpanel" aria-labelledby="all-orders-tab">
        @include('backend.order.all_orders', ['order' => $allOrders])
      </div>

      <!-- New Orders Table -->
      <div class="tab-pane fade" id="new-orders" role="tabpanel" aria-labelledby="new-orders-tab">
        @include('backend.order.new_orders', ['order' => $newOrders])
    </div>

      <!-- To Pay Orders Table -->
      <div class="tab-pane fade" id="topay-orders" role="tabpanel" aria-labelledby="topay-orders-tab">
          @include('backend.order.topay_orders', ['order' => $topayOrders])
      </div>

      <!-- To Ship Orders Table -->
      <div class="tab-pane fade" id="toship-orders" role="tabpanel" aria-labelledby="toship-orders-tab">
          @include('backend.order.toship_orders', ['order' => $toshipOrders])
      </div>

      <!-- To Receive Orders Table -->
      <div class="tab-pane fade" id="toreceive-orders" role="tabpanel" aria-labelledby="toreceive-orders-tab">
          @include('backend.order.toreceive_orders', ['order' => $toreceiveOrders])
      </div>

      <!-- Completed Orders Table -->
      <div class="tab-pane fade" id="completed-orders" role="tabpanel" aria-labelledby="completed-orders-tab">
        @include('backend.order.complete_orders', ['order' => $completedOrders])
      </div>

      <!-- Canceled Orders Table -->
      <div class="tab-pane fade" id="canceled-orders" role="tabpanel" aria-labelledby="canceled-orders-tab">
        @include('backend.order.cancel_orders', ['order' => $cancelOrders])
      </div>
  </div>
    
      {{-- <div class="table-responsive">
        @if(count($orders)>0)
        <table class="table table-bordered table-hover" id="order-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>#</th>
              <th>Order No.</th>
              <th>Name</th>
              <th>Address</th>
              <th>Payment Method</th>
              <th>Shipping Cost</th>
              <th>Total</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($orders as $order)  
            @php
                $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
            @endphp 
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->order_number}}</td>
                    <td>{{$order->first_name}} {{$order->last_name}}</td>
                    <td>{{$order->email}}</td>
                    <td>{{$order->quantity}}</td>
                    <td>@foreach($shipping_charge as $data) $ {{number_format($data,2)}} @endforeach</td>
                    <td>${{number_format($order->total_amount,2)}}</td>
                    <td>
                        @if($order->status=='new')
                          <span class="badge badge-primary">NEW</span>
                        @elseif($order->status=='process')
                          <span class="badge badge-warning">Processing</span>
                        @elseif($order->status=='delivered')
                          <span class="badge badge-success">Delivered</span>
                        @else
                          <span class="badge badge-danger">{{$order->status}}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                        <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>  
            @endforeach
          </tbody>
        </table>
        <span style="float:right">{{$orders->links()}}</span>
        @else
          <h6 class="text-center">No orders found!!! Please order some products</h6>
        @endif
      </div> --}}
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: block;
      }
  </style>
@endpush

{{-- @push('scripts')
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#order-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[5]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush --}}