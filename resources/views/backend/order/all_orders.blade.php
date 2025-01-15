<div class="card-body">
    <div class="d-flex justify-content-end  mb-3">
        <!-- Form pencarian -->
        <form method="GET" action="{{route('order.index')}}">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
<div class="table-responsive">
    @if(count($allOrders)>0)
    <table class="table table-bordered table-hover" id="allorder-dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>#</th>
          <th>Order No.</th>
          <th>Name</th>
          <th>Order Date</th>
          <th>Payment Method</th>
          <th>Total</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($allOrders as $index => $order)  
        
        @php
            $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
        @endphp 
            <tr>
                <td>{{$allOrders->firstItem() + $index }}</td>
                <td>{{$order->order_number}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{$order->date_order}}</td>
                <td>{{$order->payment->method_payment}}</td>
                <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                <td>
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
                    @elseif($order->status=='refunded')
                      <span class="badge badge-warning">Refunded</span>
                    @else
                      <span class="badge badge-warning">Rejected</span>
                    @endif
                </td>
                <td>
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:130px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</a>
                    
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>

    
    <div class="pagination-container d-flex justify-content-between align-items-center">
        <span>
            Showing {{ $allOrders->firstItem() }} to {{ $allOrders->lastItem() }} of {{ $allOrders->total() }} entries
        </span>
        <div>
            {{ $allOrders->links('pagination::bootstrap-4') }}
        </div>
    </div>
    
    @else
      <h6 class="text-center">No orders found!!! Please order some products</h6>
    @endif
  </div>
</div>

