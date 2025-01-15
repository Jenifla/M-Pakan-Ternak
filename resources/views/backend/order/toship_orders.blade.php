<div class="card-body">
  <div class="d-flex justify-content-end  mb-3">
    <!-- Form pencarian -->
    <form method="GET" action="{{ route('admin.orders', ['tab' => 'toship']) }}">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
  </div>
<div class="table-responsive">
    @if(count($toshipOrders)>0)
    <table class="table table-bordered table-hover" id="toshiporder-dataTable" width="100%" cellspacing="0">
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
        @foreach($toshipOrders as $index => $order)  
        
            <tr>
                <td>{{$toshipOrders->firstItem() + $index}}</td>
                <td>{{$order->order_number}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{$order->address->detail_alamat}}, {{$order->address->kode_pos}}, {{$order->address->kelurahan}}, {{$order->address->kecamatan}}, {{$order->address->kabupaten}}, {{$order->address->provinsi}}</td>
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
                    <span class="badge badge-primary">To Ship</span>
                </td>
                <td>
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</i></a>
                    <form action="{{ route('order.update.status', $order->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="to receive">
                      <button type="submit" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:80px; border-radius:20px" data-toggle="tooltip" title="Accept" data-placement="bottom">Shipped</button>
                  </form>
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>
    <div class="pagination-container d-flex justify-content-between align-items-center">
      <span>
          Showing {{ $toshipOrders->firstItem() }} to {{ $toshipOrders->lastItem() }} of {{ $toshipOrders->total() }} entries
      </span>
      <div>
          {{ $toshipOrders->links('pagination::bootstrap-4') }}
      </div>
  </div>
    @else
      <h6 class="text-center">No orders found!!!</h6>
    @endif
  </div>
</div>
