<div class="card-body">
<div class="table-responsive">
    @if(count($completedOrders)>0)
    <table class="table table-bordered table-hover" id="completeorder-dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>#</th>
          <th>Order No.</th>
          <th>Name</th>
          <th>Date Received</th>
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
        @foreach($completedOrders as $order)  
        
            <tr>
                <td>{{$counter++}}</td>
                <td>{{$order->order_number}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{$order->date_received}}</td>
                <td>
                  @if($order->shipping->status_biaya == 0)
                    Rp{{$order->ongkir}}
                  @elseif($order->shipping->status_biaya == 1)
                    Rp{{$order->shipping->price}}
                  @endif
                </td>
                <td>Rp{{number_format($order->total_amount,2)}}</td>
                <td>
                    <span class="badge badge-success">Completed</span>
                </td>
                <td>
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</i></a>
                    {{-- <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="edit" data-placement="bottom">Print Invoice</i></a> --}}
                    {{-- <form method="POST" action="{{route('order.destroy',[$order->id])}}">
                      @csrf 
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" data-placement="bottom" title="Delete">Change status</i></button>
                    </form> --}}
                    {{-- <form id="rejectForm" action="{{ route('order.update.status', $order->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="rejected">
                  
                      <!-- Tombol Rejected -->
                      <button type="button" class="btn btn-danger btn-sm float-left mr-1 mb-2" style="height:30px; width:130px; border-radius:20px" data-toggle="tooltip" title="Reject" data-placement="bottom" id="rejectBtn">
                        Change status
                      </button>
                  
                      <!-- Form alasan akan muncul setelah tombol diklik -->
                      <div id="reasonForm" style="display: none;">
                          <label for="alasan">Reason for Change:</label>
                          <textarea name="alasan" id="alasan" class="form-control" required></textarea>
                          <button type="submit" class="btn btn-primary mt-2">Submit</button>
                      </div>
                  </form> --}}

                  {{-- <form action="{{ route('order.update.status', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rejected">
                    <input type="hidden" name="alasan" value=""> <!-- Alasan akan diisi sebelum submit -->
                    <button type="button" class="btn btn-danger btn-sm float-left mr-1 mb-2 jetBtn" data-id="{{ $order->id }}" style="height:30px; width:130px; border-radius:20px">
                      Change status
                    </button>
                </form> --}}
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>
    {{-- <span style="float:right">{{$orders->links()}}</span> --}}
    
    <div class="mt-3">
      {{ $completedOrders->links() }} <!-- This generates the pagination links -->
  </div>
    @else
      <h6 class="text-center">No orders found!!! Please order some products</h6>
    @endif
  </div>
</div>

<!-- Modal Popup -->
<div class="modal fade" id="jetModal" tabindex="-1" role="dialog" aria-labelledby="jetModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="jetModalLabel">Reason for Change</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <!-- Form Alasan -->
              <form id="sonForm">
                  <div class="form-group">
                      <label for="asan">Reason:</label>
                      <textarea id="asan" class="form-control" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
  </div>
</div>

@push('scripts')
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
    
    $('#completeorder-dataTable').DataTable( {
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
<script>
  $(document).ready(function () {
      // Setup CSRF token for AJAX
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      // Event ketika tombol ditangkap
      $('.jetBtn').click(function (e) {
          e.preventDefault(); // Mencegah submit default form
          var form = $(this).closest('form'); // Form terkait tombol
          var dataID = $(this).data('id'); // Mengambil ID data dari tombol

          // Tampilkan modal popup
          $('#jetModal').modal('show');

          // Ketika form modal di-submit
          $('#sonForm').off('submit').on('submit', function (event) {
              event.preventDefault(); // Hindari submit default
              var alasan = $('#asan').val(); // Ambil input alasan

              if (alasan.trim() === "") {
                  alert("Reason is required!");
                  return;
              }

              // Isi field dalam form asli sebelum submit
              form.find('input[name="alasan"]').val(alasan);

              // Submit form asli
              form.submit();
          });
      });
  });
</script>
@endpush