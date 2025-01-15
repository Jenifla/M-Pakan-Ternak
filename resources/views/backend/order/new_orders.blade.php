<div class="card-body">
    <div class="d-flex justify-content-end  mb-3">
        <!-- Form pencarian -->
        <form method="GET" action="{{ route('admin.orders', ['tab' => 'new']) }}">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
      </div>
<div class="table-responsive">
    @if(count($newOrders)>0)
    <table class="table table-bordered table-hover" id="neworder-dataTable" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Order No.</th>
          <th>Product</th>
          <th>Address</th>
          <th>Payment Method</th>
          <th>Total</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($newOrders as $order)  
            <tr>
                <td>{{$order->order_number}}</td>
                <td>
                  @foreach($order->cart as $cartItem)
                      <div class="mt-3">
                          @if($cartItem->product->gambarProduk->isNotEmpty())
                            <img src="{{ asset($cartItem->product->gambarProduk->first()->gambar) }}" alt="Product Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover; border-radius:9px; margin-right:10px;">
                          @else
                            <img src="{{ asset('default-image.jpg') }}" alt="Default Image" class="me-3" style="width: 80px; height: 80px; object-fit: cover;">
                          @endif
                          <strong>{{ $cartItem->product->title }}</strong><br>
                      Quantity: {{ $cartItem->quantity }}<br>
                      </div>
                  @endforeach
                  
                </td>
                <td>{{$order->address->detail_alamat}}, {{$order->address->kode_pos}}, {{$order->address->kelurahan}}, {{$order->address->kecamatan}}, {{$order->address->kabupaten}}, {{$order->address->provinsi}}</td>
                <td>{{$order->payment->method_payment}}</td>
                <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                <td>
                  <span class="badge badge-warning">NEW</span>
                </td>
                <td>
                    <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</i></a>
                  @if($order->shipping->status_biaya == 0)
                      <!-- Jika admin harus menginputkan ongkir -->
                      <form action="{{ route('order.update.status', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        @if($order->payment->method_payment == 'cod')
                            <input type="hidden" name="status" value="to ship">
                            <input type="hidden" name="ongkir" value="">
                        @else
                            <input type="hidden" name="status" value="to pay">
                            <input type="hidden" name="ongkir" value="">
                        @endif
                        
                        <button type="submit" class="btn btn-primary btn-sm float-left mr-1 mb-2 ongBtn" style="height:30px; width:80px; border-radius:20px" data-toggle="tooltip" title="Accept" data-placement="bottom">Accepted</button>
                    </form>
                  @elseif($order->shipping->status_biaya == 1)
                      <form action="{{ route('order.update.status', $order->id) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('PUT')
                      <input type="hidden" name="status" value="to pay">
                      <button type="submit" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:80px; border-radius:20px" data-toggle="tooltip" title="Accept" data-placement="bottom">Accepted</button>
                  </form>
                  @endif

                <form action="{{ route('order.update.status', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rejected">
                    <input type="hidden" name="alasan" value=""> <!-- Alasan akan diisi sebelum submit -->
                    <button type="button" class="btn btn-danger btn-sm float-left mr-1 mb-2 dltBtn" data-id="{{ $order->id }}" style="height:30px; width:80px; border-radius:20px">
                        Rejected
                    </button>
                </form>
                </td>
            </tr>  
        @endforeach
      </tbody>
    </table>    
    <div class="pagination-container d-flex justify-content-between align-items-center">
        <span>
            Showing {{ $newOrders->firstItem() }} to {{ $newOrders->lastItem() }} of {{ $newOrders->total() }} entries
        </span>
        <div>
            {{ $newOrders->links('pagination::bootstrap-4') }}
        </div>
      </div>
    @else
      <h6 class="text-center">No orders found!!!</h6>
    @endif
  </div>
</div>


<!-- Modal Popup -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="rejectModalLabel">Reason for Rejection</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <!-- Form Alasan -->
              <form id="reasonForm">
                  <div class="form-group">
                      <label for="alasan">Reason:</label>
                      <textarea id="alasan" class="form-control" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
  </div>
</div>

<!-- Modal Popup -->
<div class="modal fade" id="ongkirModal" tabindex="-1" role="dialog" aria-labelledby="ongkirModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="ongkirModalLabel">Enter shipping costs</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <!-- Form Alasan -->
              <form id="ongkirForm">
                  <div class="form-group">
                      <label for="ongkir">Cost:</label>
                      <textarea id="ongkir" class="form-control" required></textarea>
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
  $(document).ready(function () {
      // Setup CSRF token for AJAX
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      // Event ketika tombol ditangkap
      $('.dltBtn').click(function (e) {
          e.preventDefault(); // Mencegah submit default form
          var form = $(this).closest('form'); // Form terkait tombol
          var dataID = $(this).data('id'); // Mengambil ID data dari tombol

          // Tampilkan modal popup
          $('#rejectModal').modal('show');

          // Ketika form modal di-submit
          $('#reasonForm').off('submit').on('submit', function (event) {
              event.preventDefault(); // Hindari submit default
              var alasan = $('#alasan').val(); // Ambil input alasan

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

<script>
  $(document).ready(function () {
      // Setup CSRF token for AJAX
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      // Event ketika tombol ditangkap
      $('.ongBtn').click(function (e) {
          e.preventDefault(); // Mencegah submit default form
          var form = $(this).closest('form'); // Form terkait tombol
          var dataID = $(this).data('id'); // Mengambil ID data dari tombol

          // Tampilkan modal popup
          $('#ongkirModal').modal('show');

          // Ketika form modal di-submit
          $('#ongkirForm').off('submit').on('submit', function (event) {
              event.preventDefault(); // Hindari submit default
              var ongkir = $('#ongkir').val(); // Ambil input alasan

              if (ongkir.trim() === "") {
                  alert("Ongkir is required!");
                  return;
              }

              // Isi field dalam form asli sebelum submit
              form.find('input[name="ongkir"]').val(ongkir);

              // Submit form asli
              form.submit();
          });
      });
  });
</script>

@endpush