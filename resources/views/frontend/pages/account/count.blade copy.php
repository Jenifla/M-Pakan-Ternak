@extends('frontend.layouts.master')

@section('title','PT. Agro Apis Palacio || Account Page')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list">
                            <li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
                            <li class="active"><a href="javascript:void(0);">Account</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->
            
   <!-- Account Cust -->
   <div class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-auto">
                <div class="row">
                    <div class="col-md-3">
                        @include('frontend.pages.account.sidebar')
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content account dashboard-content pl-50">
                            <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0">Hello Rosie!</h3>
                                    </div>
                                    <div class="card-body">
                                        <p>
                                            From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>,<br />
                                            manage your <a href="#">shipping and billing addresses</a> and <a href="#">edit your password and account details.</a>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0">Your Orders</h3>
                                    </div>
                                    <div class="card-body">
                                        <!-- Additional Navigation for Order Status -->
                                        <ul class="nav nav-tabs" id="orderStatusTab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="all-orders-tab" data-bs-toggle="tab" href="#all-orders" role="tab" aria-controls="all-orders" aria-selected="true">All Orders</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="processing-orders-tab" data-bs-toggle="tab" href="#processing-orders" role="tab" aria-controls="processing-orders" aria-selected="false">New</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="processing-orders-tab" data-bs-toggle="tab" href="#processing-orders" role="tab" aria-controls="processing-orders" aria-selected="false">To Pay</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="processing-orders-tab" data-bs-toggle="tab" href="#processing-orders" role="tab" aria-controls="processing-orders" aria-selected="false">To Ship</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="processing-orders-tab" data-bs-toggle="tab" href="#processing-orders" role="tab" aria-controls="processing-orders" aria-selected="false">To Receive</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="completed-orders-tab" data-bs-toggle="tab" href="#completed-orders" role="tab" aria-controls="completed-orders" aria-selected="false">Completed</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="processing-orders-tab" data-bs-toggle="tab" href="#processing-orders" role="tab" aria-controls="processing-orders" aria-selected="false">Cancelled</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="processing-orders-tab" data-bs-toggle="tab" href="#processing-orders" role="tab" aria-controls="processing-orders" aria-selected="false">Return Refund</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <!-- All Orders Tab -->
                                            <div class="tab-pane fade show active" id="all-orders" role="tabpanel" aria-labelledby="all-orders-tab">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>#1357</td>
                                                                <td>March 45, 2020</td>
                                                                <td>Processing</td>
                                                                <td>$125.00 for 2 item</td>
                                                                <td><button class="btn-sm view-order-btn" data-order-id="1">View</button></td>
                                                            </tr>
                                                            <tr>
                                                                <td>#2468</td>
                                                                <td>June 29, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$364.00 for 5 item</td>
                                                                <td><a href="#order-detail-2468" class="btn-small d-block" data-bs-toggle="tab">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>#2366</td>
                                                                <td>August 02, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$280.00 for 3 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- Processing Orders Tab -->
                                            <div class="tab-pane fade" id="processing-orders" role="tabpanel" aria-labelledby="processing-orders-tab">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>#1357</td>
                                                                <td>March 45, 2020</td>
                                                                <td>Processing</td>
                                                                <td>$125.00 for 2 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <!-- Completed Orders Tab -->
                                            <div class="tab-pane fade" id="completed-orders" role="tabpanel" aria-labelledby="completed-orders-tab">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Order</th>
                                                                <th>Date</th>
                                                                <th>Status</th>
                                                                <th>Total</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>#2468</td>
                                                                <td>June 29, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$364.00 for 5 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                            <tr>
                                                                <td>#2366</td>
                                                                <td>August 02, 2020</td>
                                                                <td>Completed</td>
                                                                <td>$280.00 for 3 item</td>
                                                                <td><a href="#" class="btn-small d-block">View</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="track-orders" role="tabpanel" aria-labelledby="track-orders-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="mb-0">Orders tracking</h3>
                                    </div>
                                    <div class="card-body contact-from-area">
                                        <p>To track your order please enter your OrderID in the box below and press "Track" button. This was given to you on your receipt and in the confirmation email you should have received.</p>
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <form class="contact-form-style mt-30 mb-50" action="#" method="post">
                                                    <div class="input-style mb-20">
                                                        <label>Order ID</label>
                                                        <input name="order-id" placeholder="Found in your order confirmation email" type="text" />
                                                    </div>
                                                    <div class="input-style mb-20">
                                                        <label>Billing email</label>
                                                        <input name="billing-email" placeholder="Email you used during checkout" type="email" />
                                                    </div>
                                                    <button class="submit submit-auto-width" type="submit">Track</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address-tab">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="mb-0">Shipping Address</h5>
                                                <div class="add-address">
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAddressModal">Add Address</button>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="address-card">
                                                    <div class="address">
                                                        <a>Default</a>
                                                        <h3>Kevin Gilbert</h3>
                                                        <p>Desa Kebon Jeruk, No. 04, RT07/RW08,<br>
                                                        Kecambor, Kalimaya, Bali, ID, 65234</p>
                                                        <p><strong>Phone Number:</strong> +62-202-555-0118</p>
                                                    </div>
                                                    <div class="actions">
                                                        <a href="#">Edit</a>
                                                        <a href="#">SET AS DEFAULT</a>
                                                    </div>
                                                </div>
                                                <div class="address-card">
                                                    <div>
                                                        <h3>Kevin Gilbert</h3>
                                                        <p>Desa Kebon Jeruk, No. 04, RT07/RW08,<br>
                                                            Kecambor, Kalimaya, Bali, ID, 65234</p>
                                                        <p><strong>Phone Number:</strong> +62-202-555-0118</p>
                                                    </div>
                                                    <div class="actions">
                                                        <a href="#">Edit</a>
                                                        <a href="#">SET AS DEFAULT</a>
                                                    </div>
                                                </div>
                                                <div class="address-card">
                                                    <div>
                                                        <h3>Kevin Gilbert</h3>
                                                        <p>Desa Kebon Jeruk, No. 04, RT07/RW08,<br>
                                                            Kecambor, Kalimaya, Bali, ID, 65234</p>
                                                        <p><strong>Phone Number:</strong> +62-202-555-0118</p>
                                                    </div>
                                                    <div class="actions">
                                                        <a href="#">Edit</a>
                                                        <a href="#">SET AS DEFAULT</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            
                            <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Account Details</h5>
                                    </div>
                                    <div class="card-body">
                                        <p>Already have an account? <a href="page-login.html">Log in instead!</a></p>
                                        <form method="post" name="enq">
                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label>Full Name <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="dname" type="text" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Email Address <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="email" type="email" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Current Password <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="password" type="password" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>New Password <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="npassword" type="password" />
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label>Confirm Password <span class="required">*</span></label>
                                                    <input required="" class="form-control" name="cpassword" type="password" />
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Detail Content -->
                            <div class="tab-pane fade" id="order-details" role="tabpanel">
                                <h4>Order Detail</h4>
                                <div id="order-detail-content">
                                <!-- Konten detail order akan ditampilkan di sini -->
                                <p id="loading-detail">Loading...</p>
                                </div>
                                <button class="back-to-orders-btn btn btn-secondary mt-3">Back to Orders</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Account Cust -->


<!-- Modal Structure -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="ti-close" aria-hidden="true"></span></button>
            </div>
            <div class="modal-body">
                <form class="form" method="POST">
                    <div class="checkout-form">
                        <p>New Address</p>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Full Name<span>*</span></label>
                                    <input type="text" name="first_name" placeholder="" value="{{old('first_name')}}" value="{{old('first_name')}}" required>
                                    @error('first_name')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    
                                    <label>Phone Number <span>*</span></label>
                                    <input type="number" name="phone" placeholder="" required value="{{old('phone')}}">
                                    @error('phone')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label for="select-provinsi" >Provinsi <span>*</span></label>
                                    <select  id="select-provinsi" name="provinsi" required>
                                        <option value="">- Pilih Provinsi -</option>
                                    </select>
                                    @error('provinsi')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Kabupaten <span>*</span></label>
                                    <select id="select-kabupaten" name="kabupaten" required disabled>
                                        <option value="">- Pilih Kabupaten -</option>
                                    </select>
                                    @error('kabupaten')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kecamatan -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Kecamatan <span>*</span></label>
                                    <select  id="select-kecamatan" name="kecamatan" required disabled>
                                        <option value="">- Pilih Kabupaten -</option>
                                    </select>
                                    @error('kecamatan')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kelurahan -->
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Kelurahan <span>*</span></label>
                                    <select  id="select-kelurahan" name="kelurahan" required disabled>
                                        <option value="">- Pilih Kabupaten -</option>
                                    </select>
                                    @error('kelurahan')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Postal Code</label>
                                    <input type="text" name="post_code" placeholder="" value="{{old('post_code')}}">
                                    @error('post_code')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Detail Alamat<span>*</span></label>
                                    <input type="text" name="address1" placeholder="" value="{{old('address1')}}">
                                    @error('address1')
                                        <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Jenis Alamat<span>*</span></label>
                                    <select name="jenis-alamat" id="jenis-alamat" required>
                                        <option value="">- Pilih Jenis Alamat -</option>
                                        <option value="">Rumah</option>
                                        <option value="">Kantor</option>
                                        <option value="">Gudang</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!--/ End Form -->
                    </div>
                
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Address</button>
            </div>
        </div>
    </div>
</div>
<!-- End Modal -->
{{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    // Data dummy untuk simulasi detail order
    const orderDetailsData = {
        '1357': {
            orderNumber: '#1357',
            date: 'March 15, 2023',
            status: 'Processing',
            total: '$125.00',
            items: [
                { name: 'Product A', quantity: 2, price: '$50.00' },
                { name: 'Product B', quantity: 1, price: '$25.00' },
            ],
            address: '123 Feed Street, Farmtown, Country'
        },
        '2468': {
            orderNumber: '#2468',
            date: 'June 29, 2023',
            status: 'Completed',
            total: '$364.00',
            items: [
                { name: 'Product C', quantity: 3, price: '$100.00' },
                { name: 'Product D', quantity: 2, price: '$32.00' },
            ],
            address: '456 Supply Road, Barnsville, Country'
        }
    };

    // Event listener untuk tombol "View"
    document.querySelectorAll('.view-order').forEach(button => {
        button.addEventListener('click', function () {
            const orderId = this.getAttribute('data-order-id');
            const orderData = orderDetailsData[orderId];

            // Isi detail order di dalam konten #order-details
            const orderDetailsContent = `
                <h4>Order Details for ${orderData.orderNumber}</h4>
                <p><strong>Order Date:</strong> ${orderData.date}</p>
                <p><strong>Status:</strong> ${orderData.status}</p>
                <p><strong>Total:</strong> ${orderData.total}</p>
                <h5>Items:</h5>
                <ul>
                    ${orderData.items.map(item => `<li>${item.name} - ${item.quantity} x ${item.price}</li>`).join('')}
                </ul>
                <h5>Shipping Address:</h5>
                <p>${orderData.address}</p>
                <button class="btn btn-small back-to-orders">Back to Orders</button>
            `;

            // Masukkan konten detail ke dalam tab #order-details dan aktifkan tab
            document.getElementById('order-details').innerHTML = orderDetailsContent;
            document.querySelector('#orderStatusTab .nav-link.active').classList.remove('active');
            document.getElementById('order-details').classList.add('show', 'active');

            // Event listener untuk tombol "Back to Orders"
            document.querySelector('.back-to-orders').addEventListener('click', function () {
                document.getElementById('order-details').classList.remove('show', 'active');
                document.querySelector('#orderStatusTab .nav-link.active').classList.add('show', 'active');
            });
        });
    });
});

</script> --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
      
          // Fungsi untuk menampilkan detail order berdasarkan orderId
          function showOrderDetail(orderId) {
            // Simulasi mengambil detail order berdasarkan ID (gunakan Ajax atau metode lain di sini)
            setTimeout(function() {
              // Gantikan konten dengan data detail order (misal, bisa ditarik dari server)
              $("#order-detail-content").html(`
                <p>Detail untuk Order ID: ${orderId}</p>
                <p>Order Description: This is a detailed description for order #${orderId}.</p>
                <p>Status: Pending</p>
                <p>Total: $100.00</p>
              `);
              // Hapus teks "Loading..."
              $("#loading-detail").remove();
            }, 1000);
          }
      
          // Saat tombol "View" diklik, tampilkan detail order dan sembunyikan daftar orders
          $(".view-order-btn").click(function() {
            var orderId = $(this).data("order-id");
            
            // Menampilkan konten detail order
            $("#order-details").removeClass("fade").addClass("show active");
            $("#orders").removeClass("show active").addClass("fade");
      
            // Panggil fungsi untuk menampilkan detail order berdasarkan orderId
            showOrderDetail(orderId);
          });
      
          // Saat tombol "Back to Orders" diklik, kembali ke tampilan daftar orders
          $(".back-to-orders-btn").click(function() {
            $("#order-details").removeClass("show active").addClass("fade");
            $("#orders").removeClass("fade").addClass("show active");
          });
      
        });
      </script>

      
    <script>
        $(document).ready(function() {
            // Optional: You can also manually trigger the modal if needed
            $('.btn-primary').click(function() {
                $('#addAddressModal').modal('show');
            });
        });
    </script>
    <script>
        // Optionally add your JS here for handling form submission, etc.
        document.getElementById('saveAddressBtn').addEventListener('click', function() {
            const recipientName = document.getElementById('recipientName').value;
            const addressLine = document.getElementById('addressLine').value;
            const phoneNumber = document.getElementById('phoneNumber').value;

            // Handle the address saving logic here
            console.log('Address saved:', {
                recipientName,
                addressLine,
                phoneNumber
            });

            // Close the modal after saving
            $('#addAddressModal').modal('hide');
        });
    </script>

<script>
    document.querySelectorAll('a[data-bs-toggle="tab"]').forEach(function(tabElement) {
  tabElement.addEventListener('click', function(event) {
    event.preventDefault();
    var tabTrigger = new bootstrap.Tab(tabElement);
    tabTrigger.show();
  });
});
</script>
{{-- <script src="{{asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
	<script src="{{ asset('frontend/js/select2/js/select2.min.js') }}"></script>
	<script>
		$(document).ready(function() { $("select.select2").select2(); });
  		$('select.nice-select').niceSelect();
	</script> --}}



<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#select-provinsi').niceSelect();
    // Load Provinsi
    fetch('/wilayah/provinsi.json')
        .then(response => response.json())
        .then(data => {
            const provinsiSelect = document.getElementById('select-provinsi');
            data.forEach(provinsi => {
                const option = document.createElement('option');
                option.value = provinsi.id;
                option.textContent = provinsi.nama;
                console.log(`Menambahkan Provinsi: ${provinsi.nama} dengan ID: ${provinsi.id}`);
                provinsiSelect.appendChild(option);
            });
            console.log('Provinsi loaded:', data);
            // Memperbarui tampilan nice select
            if (typeof $.fn.niceSelect === 'function') {
                $(provinsiSelect).niceSelect('update');
            }
        })
        .catch(error => console.error('Error loading provinsi:', error));

    // Event listener for Provinsi change
    $('#select-provinsi').on('change', function () {
        const provinsiId = $(this).val();
        console.log(`Provinsi Id : `, provinsiId)
        loadKabupaten(provinsiId);
        resetDropdowns(['select-kabupaten', 'select-kecamatan', 'select-kelurahan']); // Reset dropdown di bawahnya
        // $('#select-kecamatan').prop('disabled', true); // Nonaktifkan dropdown kecamatan
        // $('#select-kelurahan').prop('disabled', true); // Nonaktifkan dropdown kelurahan
    });

    // Function to load Kabupaten
    function loadKabupaten(provinsiId) {
        fetch(`/wilayah/kabupaten/${provinsiId}.json`)
            .then(response => response.json())
            .then(data => {
                const kabupatenSelect = document.getElementById('select-kabupaten');
                kabupatenSelect.innerHTML = '<option value="">- Pilih Kabupaten -</option>'; // Reset opsi
                data.forEach(kabupaten => {
                    const option = document.createElement('option');
                    option.value = kabupaten.id;
                    option.textContent = kabupaten.nama;
                    console.log(`Menambahkan Kabupaten: ${kabupaten.nama} dengan ID: ${kabupaten.id}`);
                    kabupatenSelect.appendChild(option);
                });
                kabupatenSelect.disabled = false; // Enable kabupaten dropdown
                console.log('Kabupaten loaded:', data);
                $(kabupatenSelect).niceSelect('update');
            })
            .catch(error => console.error('Error loading kabupaten:', error));
    }

    // Event listener for Kabupaten change
    $('#select-kabupaten').on('change', function () {
        const kabupatenId = $(this).val();
        console.log(`Kabupaten Id : `, kabupatenId)
        loadKecamatan(kabupatenId);
        resetDropdowns(['select-kecamatan', 'select-kelurahan']);
    });

    // Function to load Kecamatan
    function loadKecamatan(kabupatenId) {
        fetch(`/wilayah/kecamatan/${kabupatenId}.json`)
            .then(response => response.json())
            .then(data => {
                const kecamatanSelect = document.getElementById('select-kecamatan');
                kecamatanSelect.innerHTML = '<option value="">- Pilih Kecamatan -</option>'; // Reset opsi
                data.forEach(kecamatan => {
                    const option = document.createElement('option');
                    option.value = kecamatan.id;
                    option.textContent = kecamatan.nama;
                    kecamatanSelect.appendChild(option);
                });
                kecamatanSelect.disabled = false; // Enable kecamatan dropdown
                console.log('Kecamatan loaded:', data);
                $(kecamatanSelect).niceSelect('update');
            })
            .catch(error => console.error('Error loading kecamatan:', error));
    }

    // Event listener for Kecamatan change
    $('#select-kecamatan').on('change', function () {
        const kecamatanId = $(this).val();
        console.log(`Kecamatan Id : `, kecamatanId)
        loadKelurahan(kecamatanId);
        resetDropdowns(['select-kelurahan']);
    });

    // Function to load Kelurahan
    function loadKelurahan(kecamatanId) {
        fetch(`/wilayah/kelurahan/${kecamatanId}.json`)
            .then(response => response.json())
            .then(data => {
                const kelurahanSelect = document.getElementById('select-kelurahan');
                kelurahanSelect.innerHTML = '<option value="">- Pilih Kelurahan -</option>'; // Reset opsi
                data.forEach(kelurahan => {
                    const option = document.createElement('option');
                    option.value = kelurahan.id;
                    option.textContent = kelurahan.nama;
                    kelurahanSelect.appendChild(option);
                });
                kelurahanSelect.disabled = false; // Enable kelurahan dropdown
                console.log('Kelurahan loaded:', data);
                $(kelurahanSelect).niceSelect('update');
            })
            .catch(error => console.error('Error loading kelurahan:', error));
    }

    // Fungsi untuk mereset dropdown
    function resetDropdowns(dropdownIds) {
            dropdownIds.forEach(id => {
                const selectElement = document.getElementById(id);
                selectElement.innerHTML = '<option value="">- Pilih -</option>'; // Reset opsi
                selectElement.disabled = true; // Menonaktifkan dropdown
                $(selectElement).niceSelect('update'); // Memperbarui nice select
            });
        }
});

</script>

@endsection
@push('styles')
<style>
    .page-content{
        margin-top: 150px;
        margin-bottom: 150px;
    }

    /* .container{
        margin-left: 50px;
        margin-right: 50px;
    } */

    .dashboard-menu .nav-link {
    display: block;
    padding: 10px 20px;
    border: 1px solid #F7941D;
    border-radius: 20px;
    background-color: #f8f9fa;
    color: #333;
    margin-bottom: 10px;
    text-align: left;
    transition: background-color 0.3s ease, color 0.3s ease;
}

.dashboard-menu .nav-link:hover {
    background-color: #ff2c2b;
    color: #fff;
}

.dashboard-menu .nav-link.active {
    background-color: #F7941D;
    color: white;
    border-color: #F7941D;
}

.card{
    border: none;
    width: 100%;
}

.card-header{
    background: transparent;
    border-bottom: none;
}

.address-card {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .address-card h3 {
            margin: 0;
            font-size: 16px;
        }
        .address-card p {
            margin: 5px 0;
            font-size: 14px;
            color: #666;
        }

        .address-card .address a{
            color: #ff6f00;
            border: 1px solid #666;
        }
        .address-card .actions {
            text-align: right;
        }
        .address-card .actions a {
            display: block;
            margin-bottom: 10px;
            color: #ff6f00;
            text-decoration: none;
            font-size: 14px;
        }
        .address-card .actions a:last-child {
            color: #007bff;
        }
        .add-address {
            text-align: right;
            margin-bottom: 20px;
        }
        .add-address button {
            background-color: #F7941D;
            color: #fff;
            border: none;
            padding: 13px 32px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 30px;
        }
        .add-address button:hover{
            background-color: #ff2c2b;
        }
        .modal-body{
            margin-top: 5%;
        }

        .form-select {
			height: 30px;
			width: 100%;
		}
		.form-select .nice-select {
			border: none;
			border-radius: 0px;
			height: 40px;
			background: #f6f6f6 !important;
			padding-left: 45px;
			padding-right: 40px;
			width: 100%;
		}
		.list li{
			margin-bottom:0 !important;
		}
		.list li:hover{
			background:#F7941D !important;
			color:white !important;
		}
		.form-select .nice-select::after {
			top: 14px;
		}


 .checkout-form {
	margin-left: 5%;
    margin-right: 5%;
}
 .checkout-form h2 {
	font-size: 25px;
	color: #333;
	font-weight: 700;
	line-height: 27px;
}
.checkout-form p {
	font-size: 16px;
	color: #333;
	font-weight: 400;
	margin-top: 12px;
	margin-bottom: 30px;
}
 .form{}
.form .form-group {
	margin-bottom: 25px;
}
.form .form-group label{
	color:#333;
	position:relative;
}
.form .form-group label span {
	color: #ff2c18;
	display: inline-block;
	position: absolute;
	right: -12px;
	top: 4px;
	font-size: 16px;
}
.form .form-group input {
	width: 100%;
	height: 45px;
	line-height: 50px;
	padding: 0 20px;
	border-radius: 3px;
	border-radius: 0px;
	color: #333 !important;
	border: none;
	background: #F6F7FB;
}
.form .form-group input:hover{
	
}
.nice-select {
	width: 100%;
	height: 45px;
	line-height: 50px;
	margin-bottom: 25px;
	background: #F6F7FB;
	border-radius: 0px;
	border:none;
}
 .nice-select .list {
	width: 100%;
	height: 300px;
	overflow: scroll;
}
 .nice-select .list li{}
.nice-select .list li.option{
	color:#333;
}
 .nice-select .list li.option:hover{
	background:#F6F7FB;
	color:#333;
}
 .form .address input {
	margin-bottom: 15px;
}
 .form .address input:last-child{
	margin:0;
}
</style>
@endpush