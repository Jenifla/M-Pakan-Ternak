<div class="card-body">
  <div class="d-flex justify-content-end  mb-3">
    <!-- Form pencarian -->
    <form method="GET" action="{{ route('admin.orders', ['tab' => 'topay']) }}">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
  </div>
<div class="table-responsive">
    @if(count($topayOrders)>0)
    <table class="table table-bordered table-hover" id="topayorder-dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>#</th>
          <th>Order No.</th>
          <th>Name</th>
          <th>Order Date</th>
          <th>Payment Method</th>
          <th>Shipping Cost</th>
          <th>Total</th>
          <th>Status</th>
          <th>Action</th> 
        </tr>
      </thead>
      <tbody>
        @foreach($topayOrders as $index => $order)  
        
            <tr>
                <td>{{$topayOrders->firstItem() + $index }}</td>
                <td>{{$order->order_number}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{$order->date_order}}</td>
                <td>{{$order->payment->method_payment}}</td>
                <td>
                  @if($order->shipping->status_biaya == 0)
                    Rp{{$order->ongkir}}
                  @elseif($order->shipping->status_biaya == 1)
                    Rp{{$order->shipping->price}}
                  @endif
                </td>
                <td>Rp{{number_format($order->total_amount,0, ',', '.')}}</td>
                <td>
                    <span class="badge badge-danger">To Pay</span>
                </td>
                <td>
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</i></a>
                    <form action="{{ route('order.update.status', $order->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="to ship">
                      <button type="submit" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:80px; border-radius:20px" data-toggle="tooltip" title="Accept" data-placement="bottom">Approve</button>
                  </form>
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>
    <div class="pagination-container d-flex justify-content-between align-items-center">
      <span>
          Showing {{ $topayOrders->firstItem() }} to {{ $topayOrders->lastItem() }} of {{ $topayOrders->total() }} entries
      </span>
      <div>
          {{ $topayOrders->links('pagination::bootstrap-4') }}
      </div>
  </div>
    @else
      <h6 class="text-center">No orders found!!!</h6>
    @endif
  </div>
</div>
