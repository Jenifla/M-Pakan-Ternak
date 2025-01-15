<div class="card-body">
  <div class="d-flex justify-content-end  mb-3">
    <!-- Form pencarian -->
    <form method="GET" action="{{ route('admin.orders', ['tab' => 'completed']) }}">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>
  </div>
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
        @foreach($completedOrders as $index => $order)  
        
            <tr>
                <td>{{$completedOrders->firstItem() + $index}}</td>
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
                <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                <td>
                    <span class="badge badge-success">Completed</span>
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
          Showing {{ $completedOrders->firstItem() }} to {{ $completedOrders->lastItem() }} of {{ $completedOrders->total() }} entries
      </span>
      <div>
          {{ $completedOrders->links('pagination::bootstrap-4') }}
      </div>
  </div>
    @else
      <h6 class="text-center">No orders found!!!</h6>
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