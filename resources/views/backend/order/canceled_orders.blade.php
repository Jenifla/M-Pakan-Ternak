<div class="card-body">
<!-- Nav Tabs -->
@if(request()->is('admin/orders/*'))
<ul class="nav nav-tabs" id="cancelTab" role="tablist">
  
  <li class="nav-item">
      <a class="nav-link  {{ request()->is('admin/orders/canceled') ? 'active' : '' }}" id="wait-cancel-tab"  href="{{ route('admin.orders', ['tab' => 'canceled', 'subtab' => '']) }}" 
        role="tab" aria-controls="wait-cancel" aria-selected="false">Waiting for Response
        @if(!empty($pendingCancelCount) && $pendingCancelCount > 0)
                        <span class="count-badge">({{ $pendingCancelCount}})</span>
              @endif
      </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->is('admin/orders/canceled/wait-refund') ? 'active' : '' }}" id="wait-refund-tab"  href="{{ route('admin.orders', ['tab' => 'canceled', 'subtab' => 'wait-refund']) }}" 
      role="tab" aria-controls="wait-refund" aria-selected="false">Waiting for Refund
      @if(!empty($waitRefundCount) && $waitRefundCount > 0)
                        <span class="count-badge">({{ $waitRefundCount}})</span>
              @endif
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link {{ request()->is('admin/orders/canceled/all-cancel') ? 'active' : '' }}" id="wait-refund-tab"  href="{{ route('admin.orders', ['tab' => 'canceled', 'subtab' => 'all-cancel']) }}" 
      role="tab" aria-controls="wait-refund" aria-selected="false">Canceled
      @if(!empty($orderCounts['cancelled']) && $orderCounts['cancelled'] > 0)
                        <span class="count-badge">({{ $orderCounts['cancelled'] }})</span>
              @endif
    </a>
  </li>
</ul>
@endif
<div class="tab-content">
  @if(request()->route('tab') == 'canceled' && request()->route('subtab') == '')
  {{-- {{ dd('Tab aktif, data akan ditampilkan di sini!', 'Tab memiliki embel-embel tab: ' . request()->route('tab'), 'Tab memiliki embel-embel subtab: ' . request()->route('subtab')) }} --}}
  <div class="tab-pane fade {{ request()->route('tab') == 'canceled' && request()->route('subtab') == '' ? 'show active' : '' }}">
    <div class="d-flex justify-content-end  mb-3">
      <!-- Form pencarian -->
      <form method="GET" action="{{ route('admin.orders', ['tab' => 'canceled', 'subtab' => '']) }}">
          <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">

              <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">Search</button>
              </div>
          </div>
      </form>
    </div>
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
          @foreach($pendingCancel as $index => $order)  
          
              <tr>
                  <td>{{$pendingCancel->firstItem() + $index}}</td>
                  <td>{{$order->order_number}}</td>
                  <td>{{$order->user->name}}</td>
                  <td>{{$order->alasan}}</td>
                  <td>{{$order->cancel->tgl_diajukan}}</td>
                  <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                  <td>
                   
                      <span class="badge badge-warning">Pending</span>
                  </td>
                  <td>
                      <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</a>

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
      <div class="pagination-container d-flex justify-content-between align-items-center">
        <span>
            Showing {{ $pendingCancel->firstItem() }} to {{ $pendingCancel->lastItem() }} of {{ $newOrders->total() }} entries
        </span>
        <div>
            {{ $pendingCancel->links('pagination::bootstrap-4') }}
        </div>
      </div>
      
      @else
        <h6 class="text-center">No orders found!!!</h6>
      @endif
    </div>
  </div>
  @endif

  @if(request()->route('tab') == 'canceled' && request()->route('subtab') == 'wait-refund')
  <div class="tab-pane fade {{ request()->route('tab') == 'canceled' && request()->route('subtab') == 'wait-refund' ? 'show active' : '' }}">
    <div class="d-flex justify-content-end  mb-3">
      <!-- Form pencarian -->
      <form method="GET" action="{{ route('admin.orders', ['tab' => 'canceled', 'subtab' => 'wait-refund']) }}">
          <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">

              <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">Search</button>
              </div>
          </div>
      </form>
    </div>
    <div class="table-responsive">
      @if(count($waitrefundOrders)>0)
      <table class="table table-bordered table-hover" id="waitrefund-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Order No.</th>
            <th>Name</th>
            <th>Reason</th>
            <th>Bank Name</th>
            <th>Bank Account Number</th>
            <th>Bank Holder</th>
            <th>Total Order</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($waitrefundOrders as $index => $order)  
          
              <tr>
                  <td>{{$waitrefundOrders->firstItem() + $index}}</td>
                  <td>{{$order->order_number}}</td>
                  <td>{{$order->user->name}}</td>
                  <td>{{$order->alasan}}</td>
                  <td>{{$order->refund->bank_name}}</td>
                  <td>{{$order->refund->bank_account}}</td>
                  <td>{{$order->refund->bank_holder}}</td>
                  <td>Rp{{number_format($order->total_amount, 0, ',', '.')}}</td>
                  <td>
                   
                      <span class="badge badge-warning">Pending</span>
                  </td>
                  <td>
                      <a href="{{route('order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1 mb-2" style="height:30px; width:100px;border-radius:20px" data-toggle="tooltip" title="view" data-placement="bottom">View Details</a>
                        <a href="{{route('refund.edit',$order->refund->id)}}" class="btn btn-primary btn-sm float-left mr-1 mb-2" style="height:30px; width:130px; border-radius:20px" data-toggle="tooltip" title="update" data-placement="bottom">Update Refund</button>
                  </td>
              </tr>  
          @endforeach
        </tbody>
      </table>
      <div class="pagination-container d-flex justify-content-between align-items-center">
        <span>
            Showing {{ $waitrefundOrders->firstItem() }} to {{ $waitrefundOrders->lastItem() }} of {{ $waitrefundOrders->total() }} entries
        </span>
        <div>
            {{ $waitrefundOrders->links('pagination::bootstrap-4') }}
        </div>
      </div>
      
      @else
        <h6 class="text-center">No orders found!!!</h6>
      @endif
    </div>
    
  </div>
  @endif

  @if(request()->route('tab') == 'canceled' && request()->route('subtab') == 'all-cancel')
  <div class="tab-pane fade {{ request()->route('tab') == 'canceled' && request()->route('subtab') == 'all-cancel' ? 'show active' : '' }}">
    <div class="d-flex justify-content-end  mb-3">
      <!-- Form pencarian -->
      <form method="GET" action="{{ route('admin.orders', ['tab' => 'canceled', 'subtab' => 'all-cancel']) }}">
          <div class="input-group">
              <input type="text" class="form-control" name="search" placeholder="Search" value="{{ request()->get('search') }}">

              <div class="input-group-append">
                  <button class="btn btn-primary" type="submit">Search</button>
              </div>
          </div>
      </form>
    </div>
    <div class="table-responsive">
      @if(count($canceledOrders)>0)
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
          @foreach($canceledOrders as $index => $order)  
              <tr>
                  <td>{{$canceledOrders->firstItem() + $index}}</td>
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
            Showing {{ $canceledOrders->firstItem() }} to {{ $canceledOrders->lastItem() }} of {{ $canceledOrders->total() }} entries
        </span>
        <div>
            {{ $canceledOrders->links('pagination::bootstrap-4') }}
        </div>
      </div>
      
      @else
        <h6 class="text-center">No orders found!!! </h6>
      @endif
    </div>
  </div>
  @endif
  
</div>
</div>



@push('scripts')

<script>
  document.querySelectorAll('.nav-link').forEach(tab => {
    tab.addEventListener('click', function () {
      document.getElementById('active_tab').value = this.id.replace('-tab', '');
    });
  });

  // Mengatur tab aktif saat halaman dimuat
  document.addEventListener('DOMContentLoaded', function () {
    const params = new URLSearchParams(window.location.search);
    const activeTab = params.get('active_tab');
    if (activeTab) {
      document.querySelector(`#${activeTab}-tab`).classList.add('active');
      document.querySelector(`#${activeTab}`).classList.add('show', 'active');
      document.querySelectorAll('.nav-link').forEach(link => {
        if (link.id !== `${activeTab}-tab`) {
          link.classList.remove('active');
        }
      });
    }
  });
</script>

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
@endpush