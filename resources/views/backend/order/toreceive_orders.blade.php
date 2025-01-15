<div class="card-body">
  <div class="d-flex justify-content-end  mb-3">
    <!-- Form pencarian -->
    <form method="GET" action="{{ route('admin.orders', ['tab' => 'toreceive']) }}">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
  </div>
<div class="table-responsive">
    @if(count($toreceiveOrders)>0)
    <table class="table table-bordered table-hover" id="toreceiveorder-dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>#</th>
          <th>Order No.</th>
          <th>Name</th>
          <th>Shipping Date</th>
          <th>Shipping Cost</th>
          <th>Total</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($toreceiveOrders as $index => $order)  
      
            <tr>
                <td>{{$toreceiveOrders->firstItem() + $index}}</td>
                <td>{{$order->order_number}}</td>
                <td>{{$order->user->name}}</td>
                <td>{{$order->date_shipped}}</td>
                <td>
                  @if($order->shipping->status_biaya == 0)
                    Rp{{$order->ongkir}}
                  @elseif($order->shipping->status_biaya == 1)
                    Rp{{$order->shipping->price}}
                  @endif
                </td>
                <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                <td>
                    <span class="badge badge-primary">To Receive</span>
                </td>
                <td>
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</i></a>
                    <form action="{{ route('order.update.status', $order->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="completed">
                      <button type="submit" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:80px; border-radius:20px" data-toggle="tooltip" title="Received" data-placement="bottom">Received</button>
                  </form>
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>
    <div class="pagination-container d-flex justify-content-between align-items-center">
      <span>
          Showing {{ $toreceiveOrders->firstItem() }} to {{ $toreceiveOrders->lastItem() }} of {{ $toreceiveOrders->total() }} entries
      </span>
      <div>
          {{ $toreceiveOrders->links('pagination::bootstrap-4') }}
      </div>
    </div>
    @else
      <h6 class="text-center">No orders found!!!</h6>
    @endif
  </div>
</div>

<!-- Modal Popup -->
<div class="modal fade" id="rjtModal" tabindex="-1" role="dialog" aria-labelledby="rjtModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="rjtModalLabel">Reason for Change</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <!-- Form Alasan -->
              <form id="resonForm">
                  <div class="form-group">
                      <label for="alsan">Reason:</label>
                      <textarea id="alsan" class="form-control" required></textarea>
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


<script>
  $(document).ready(function() {
    // Ketika tombol Rejected diklik
    $('#rejectBtn').click(function() {
        // Menampilkan form alasan
        $('#reasonForm').show();
        // Menyembunyikan tombol Rejected
        $(this).hide();
    });
  });
</script>


<script>
  $(document).ready(function () {
      // Setup CSRF token for AJAX
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      // Event ketika tombol ditangkap
      $('.jctBtn').click(function (e) {
          e.preventDefault(); // Mencegah submit default form
          var form = $(this).closest('form'); // Form terkait tombol
          var dataID = $(this).data('id'); // Mengambil ID data dari tombol

          // Tampilkan modal popup
          $('#rjtModal').modal('show');

          // Ketika form modal di-submit
          $('#resonForm').off('submit').on('submit', function (event) {
              event.preventDefault(); // Hindari submit default
              var alasan = $('#alsan').val(); // Ambil input alasan

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