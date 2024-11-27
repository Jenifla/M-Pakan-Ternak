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
          {{-- <th>Shipping Cost</th> --}}
          <th>Total</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
          {{-- <tr>
            <td>1</td>
            <td>#1234</td>
            <td>Kaliya Sayong</td>
            <td>Keroncom, No.12 Blok Q, Laguna, Pertama, ID 23421</td>
            <td>COD</td>
            <td>Rp 35.000,00</td>
            <td>Rp190.000,00</td>
            <td>
                
                  <span class="badge badge-primary">NEW</span>
                
            </td>
            <td>
                <a href="" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
                <a href="" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                <form method="POST" action="">
                  @csrf 
                  @method('delete')
                      <button class="btn btn-danger btn-sm dltBtn"  style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                </form>
            </td>
        </tr>   --}}
        @php 
                $counter = 1; 
        @endphp
        @foreach($allOrders as $order)  
        
        @php
            $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
        @endphp 
            <tr>
                <td>{{$counter++}}</td>
                <td>{{$order->order_number}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{$order->date_order}}</td>
                <td>{{$order->payment->method_payment}}</td>
                {{-- <td>@foreach($shipping_charge as $data) Rp {{number_format($data,2)}} @endforeach</td> --}}
                <td>Rp{{number_format($order->total_amount,2)}}</td>
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
                    @else
                      <span class="badge badge-warning">Rejected</span>
                      {{-- <span class="badge badge-primary">{{$order->status}}</span> --}}
                    @endif
                </td>
                <td>
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:130px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</a>
                    {{-- <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                      @csrf 
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form> --}}
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>

    {{-- <div class="pagination-info">
        Showing {{ $allOrders->firstItem() }} to {{ $allOrders->lastItem() }} of {{ $allOrders->total() }} entries
    </div> --}}
    {{-- <div>
        <!-- Menampilkan informasi Pagination -->
        
    </div> --}}
    <div class="pagination-container d-flex justify-content-between align-items-center">
        <span>
            Showing {{ $allOrders->firstItem() }} to {{ $allOrders->lastItem() }} of {{ $allOrders->total() }} entries
        </span>
        <div>
            {{ $allOrders->links('pagination::bootstrap-4') }}
        </div>
    </div>
    
    
    {{-- @php
        dd($allOrders->links());
        @endphp --}}
    
    {{-- <span style="float:right">{{$allOrders->links()}}</span> --}}
    
    {{-- <div class="mt-3">
      {{ $allOrders->links() }} <!-- This generates the pagination links -->
    </div> --}}
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
      
    //   $(document).ready(function(){
    //       $('#allorder-dataTable').DataTable({
    //           // Konfigurasi DataTables, di mana pagination di-handle oleh Laravel
    //           "paging": false, // Matikan fitur pagination di DataTables
    //           "searching": true, // Izinkan pencarian
    //           "ordering": true, // Izinkan pengurutan
    //           "info": false // Matikan informasi jumlah data (Showing x to y of z entries)
    //       });
    //   });


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