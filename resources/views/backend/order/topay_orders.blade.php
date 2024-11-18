<div class="table-responsive">
    @if(count($topayOrders)>0)
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
        @foreach($topayOrders as $order)  
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
    {{-- <span style="float:right">{{$orders->links()}}</span> --}}
    
    <div class="mt-3">
      {{ $topayOrders->links() }} <!-- This generates the pagination links -->
  </div>
    @else
      <h6 class="text-center">No orders found!!! Please order some products</h6>
    @endif
  </div>