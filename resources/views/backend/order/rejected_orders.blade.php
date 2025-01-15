<div class="card-body">
  <div class="d-flex justify-content-end  mb-3">
    <!-- Form pencarian -->
    <form method="GET" action="{{ route('admin.orders', ['tab' => 'rejected']) }}">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
  </div>
  <div class="table-responsive">
    @if(count($rejectedOrders)>0)
    <table class="table table-bordered table-hover" id="rejected-dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>#</th>
          <th>Order No.</th>
          <th>Name</th>
          <th>Reason</th>
          <th>Date Rejected</th>
          <th>Total</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rejectedOrders as $index => $order)  
            <tr>
                <td>{{$rejectedOrders->firstItem() + $index}}</td>
                <td>{{$order->order_number}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{$order->alasan}}</td>
                <td>{{$order->date_cancel}}</td>
                <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                <td>
                  @if($order->status=='cancel')
                    <span class="badge badge-warning">Cancel</span>
                  @elseif($order->status=='rejected')
                    <span class="badge badge-warning">Rejected</span>
                  @else
                  <span class="badge badge-warning">Pending</span>
                  @endif
                </td>
                <td>
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</i></a>
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>
    <div class="pagination-container d-flex justify-content-between align-items-center">
      <span>
          Showing {{ $rejectedOrders->firstItem() }} to {{ $rejectedOrders->lastItem() }} of {{ $rejectedOrders->total() }} entries
      </span>
      <div>
          {{ $rejectedOrders->links('pagination::bootstrap-4') }}
      </div>
  </div>
    @else
      <h6 class="text-center">No orders found!!!</h6>
    @endif
  </div>
</div>
