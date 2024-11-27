<div class="card-body">
<!-- Nav Tabs -->
<ul class="nav nav-tabs" id="cancelTab" role="tablist">
  <li class="nav-item">
      <a class="nav-link show active" id="all-cancel-tab" data-toggle="tab" href="#all-cancel" role="tab" aria-controls="all-cancel" aria-selected="true">Canceled</a>
  </li>
  <li class="nav-item">
      <a class="nav-link" id="wait-cancel-tab" data-toggle="tab" href="#wait-cancel" role="tab" aria-controls="wait-cancel" aria-selected="false">Waiting for Response</a>
  </li>
  {{-- <li class="nav-item">
      <a class="nav-link" id="real-cancel-tab" data-toggle="tab" href="#real-cancel" role="tab" aria-controls="real-cancel" aria-selected="false">Canceled</a>
  </li> --}}
</ul>
<div class="tab-content">
  <div class="tab-pane fade show active" id="all-cancel" role="tabpanel" aria-labelledby="all-cancel-tab">
    <div class="table-responsive">
      @if(count($cancelOrders)>0)
      <table class="table table-bordered table-hover" id="allcancel-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Order No.</th>
            <th>Name</th>
            <th>Reason</th>
            <th>Date Cancelled</th>
            <th>Total</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @php 
                $counter = 1; 
          @endphp
          @foreach($cancelOrders as $order)  
              <tr>
                  <td>{{$counter++}}</td>
                  <td>{{$order->order_number}}</td>
                  <td>{{$order->user->name}}</td>
                  <td>{{$order->alasan}}</td>
                  <td>{{$order->date_cancel}}</td>
                  <td>Rp{{number_format($order->total_amount,2)}}</td>
                  <td>
                    @if($order->status=='cancel')
                      <span class="badge badge-warning">Cancel</span>
                    @elseif($order->status=='rejected')
                      <span class="badge badge-warning">Rejected</span>
                      {{-- <span class="badge badge-primary">{{$order->status}}</span> --}}
                    @else
                    <span class="badge badge-warning">Pending</span>
                    @endif
                  </td>
                  <td>
                      <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</i></a>
                      {{-- <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
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
      {{-- <span style="float:right">{{$orders->links()}}</span> --}}
      
      <div class="mt-3">
        {{ $cancelOrders->links() }} <!-- This generates the pagination links -->
      </div>
      @else
        <h6 class="text-center">No orders found!!! Please order some products</h6>
      @endif
    </div>
  </div>

  <div class="tab-pane fade" id="wait-cancel" role="tabpanel" aria-labelledby="wait-cancel-tab">
    <div class="table-responsive">
      @if(count($pendingCancel)>0)
      <table class="table table-bordered table-hover" id="waitcancel-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Order No.</th>
            <th>Name</th>
            <th>Reason</th>
            <th>Date Requested</th>
            <th>Total Order</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @php 
                $counter = 1; 
          @endphp
          @foreach($pendingCancel as $order)  
          
              <tr>
                  <td>{{$counter++}}</td>
                  <td>{{$order->order_number}}</td>
                  <td>{{$order->user->name}}</td>
                  <td>{{$order->alasan}}</td>
                  <td>{{$order->cancel->tgl_diajukan}}</td>
                  <td>Rp{{number_format($order->total_amount,2)}}</td>
                  <td>
                   
                      <span class="badge badge-warning">Pending</span>
                  </td>
                  <td>
                      <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</a>
                      {{-- <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:80px;border-radius:20px" data-toggle="tooltip" title="edit" data-placement="bottom">
                        Accepted</a> --}}

                      <form action="{{ route('order.cancel.update', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status_pembatalan" value="disetujui">
                        <button type="submit" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:80px; border-radius:20px" data-toggle="tooltip" title="Accept" data-placement="bottom">Accepted</button>
                      </form>
                      <form method="POST" action="{{ route('order.cancel.update', $order->id) }}">
                        @csrf 
                        @method('PUT')
        
                        <input type="hidden" name="status_pembatalan" value="ditolak">
        
                        <!-- Hidden input field for the reason, specific to this order -->
                        <div id="reasonContainer_{{ $order->id }}" style="display: none;">
                            <textarea name="alasan" id="alasan_{{ $order->id }}" rows="3" placeholder="Enter reason..."></textarea>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="closeReasonForm({{ $order->id }})" style="margin-top: 5px;">Close</button>
                        </div>
        
                        <!-- Rejected button, with unique ID for each order -->
                        <button type="button" class="btn btn-danger btn-sm cancelBtn" data-id="{{ $order->id }}" style="height:30px; width:80px; border-radius:20px" data-toggle="tooltip" data-placement="bottom" title="Rejected" onclick="showReasonForm({{ $order->id }})">
                            Rejected
                        </button>
        
                        <!-- Submit button, initially hidden -->
                        <button type="submit" class="btn btn-primary btn-sm" style="display:none;" id="submitBtn_{{ $order->id }}">Submit</button>
                    </form>
                  </td>
              </tr>  
          @endforeach
        </tbody>
      </table>
      {{-- <span style="float:right">{{$orders->links()}}</span> --}}
      
      <div class="mt-3">
        {{ $pendingCancel->links() }} <!-- This generates the pagination links -->
      </div>
      @else
        <h6 class="text-center">No orders found!!! Please order some products</h6>
      @endif
    </div>
    <!-- Modal Popup -->
{{-- <div class="modal fade" id="cencelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true" style="z-index:1050; ">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="cancelModalLabel">Reason for Rejection</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <!-- Form Alasan -->
              <form id="cancelForm">
                  <div class="form-group">
                      <label for="lasan">Reason:</label>
                      <textarea id="lasan" class="form-control" required></textarea>
                  </div>
                  <button type="submit" class="btn btn-primary">Submit</button>
              </form>
          </div>
      </div>
  </div>
</div> --}}
  </div>
  
  <div class="tab-pane fade" id="real-cancel" role="tabpanel" aria-labelledby="real-cancel-tab">
    <div class="table-responsive">
      @if(count($cancelOrders)>0)
      <table class="table table-bordered table-hover" id="realcancel-dataTable" width="100%" cellspacing="0">
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
          @php 
                $counter = 1; 
          @endphp
          @foreach($cancelOrders as $order)  
          @php
              $shipping_charge=DB::table('shippings')->where('id',$order->shipping_id)->pluck('price');
          @endphp 
              <tr>
                  <td>{{$counter++}}</td>
                  <td>{{$order->order_number}}</td>
                  <td>{{$order->first_name}} {{$order->last_name}}</td>
                  <td>{{$order->email}}</td>
                  <td>{{$order->quantity}}</td>
                  <td>@foreach($shipping_charge as $data) $ {{number_format($data,2)}} @endforeach</td>
                  <td>${{number_format($order->total_amount,2)}}</td>
                  <td>
                    @if($order->status=='cancel')
                      <span class="badge badge-warning">Cancel</span>
                    @else
                      <span class="badge badge-warning">Rejected</span>
                      {{-- <span class="badge badge-primary">{{$order->status}}</span> --}}
                    @endif
                  </td>
                  <td>
                      <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</i></a>
                      {{-- <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
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
      {{-- <span style="float:right">{{$orders->links()}}</span> --}}
      
      <div class="mt-3">
        {{ $cancelOrders->links() }} <!-- This generates the pagination links -->
      </div>
      @else
        <h6 class="text-center">No orders found!!! Please order some products</h6>
      @endif
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
    
    $('#allcancel-dataTable').DataTable( {
          "columnDefs":[
              {
                  "orderable":false,
                  "targets":[5]
              }
          ]
      } );

      $('#waitcancel-dataTable').DataTable( {
          "columnDefs":[
              {
                  "orderable":false,
                  "targets":[5]
              }
          ]
      } );

      $('#realcancel-dataTable').DataTable( {
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
  // Function to show the reason input field when the "Rejected" button is clicked
  function showReasonForm(orderId) {
      // Show the reason input field for the specific order
      document.getElementById('reasonContainer_' + orderId).style.display = 'block';
      
      // Hide the "Rejected" button for this order and show the submit button
      document.querySelector('.cancelBtn[data-id="' + orderId + '"]').style.display = 'none';
      document.getElementById('submitBtn_' + orderId).style.display = 'inline-block';
  }

  // Function to hide the reason input field when the "Close" button is clicked
  function closeReasonForm(orderId) {
      // Hide the reason input field for the specific order
      document.getElementById('reasonContainer_' + orderId).style.display = 'none';
      
      // Show the "Rejected" button for this order again and hide the submit button
      document.querySelector('.cancelBtn[data-id="' + orderId + '"]').style.display = 'inline-block';
      document.getElementById('submitBtn_' + orderId).style.display = 'none';
  }
</script>

{{-- <script>
  $(document).ready(function () {
      // Setup CSRF token for AJAX
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

      // Event ketika tombol ditangkap
      $('.cancelBtn').click(function (e) {
          e.preventDefault(); // Mencegah submit default form
          var form = $(this).closest('form'); // Form terkait tombol
          var dataID = $(this).data('id'); // Mengambil ID data dari tombol

          $('#wait-cancel-tab').tab('show'); 
          // Tampilkan modal popup
          console.log("Button clicked, dataID: " + dataID);
          $('#cancelModal').modal('show');

          // Ketika form modal di-submit
          $('#cancelForm').off('submit').on('submit', function (event) {
              event.preventDefault(); // Hindari submit default
              var lasan = $('#lasan').val(); // Ambil input alasan

              if (lasan.trim() === "") {
                  alert("Reason is required!");
                  return;
              }

              // Isi field dalam form asli sebelum submit
              form.find('input[name="alasan"]').val(lasan);

              // Submit form asli
              form.submit();
          });
      });
  });
</script> --}}
@endpush