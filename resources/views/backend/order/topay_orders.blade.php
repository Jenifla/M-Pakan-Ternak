<div class="card-body">
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
            @php 
                $counter = 1; 
            @endphp
        @foreach($topayOrders as $order)  
        
            <tr>
                <td>{{$counter++}}</td>
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
                <td>Rp{{number_format($order->total_amount,2)}}</td>
                <td>
                    <span class="badge badge-danger">To Pay</span>
                </td>
                <td>
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</i></a>
                    {{-- <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:80px;border-radius:20px" data-toggle="tooltip" title="edit" data-placement="bottom">Approve</i></a> --}}
                    <form action="{{ route('order.update.status', $order->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="to ship">
                      <button type="submit" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:80px; border-radius:20px" data-toggle="tooltip" title="Accept" data-placement="bottom">Approve</button>
                  </form>
                    {{-- <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                      @csrf 
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form> --}}
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>
    @else
      <h6 class="text-center">No orders found!!! Please order some products</h6>
    @endif
  </div>
</div>

  @push('scripts')
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
    
    $('#topayorder-dataTable').DataTable( {
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
{{-- <script>
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
</script> --}}
@endpush