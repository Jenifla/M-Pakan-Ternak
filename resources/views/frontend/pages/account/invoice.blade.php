<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .invoice-container {
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header img {
      max-height: 80px;
    }

    .header h1 {
      color: #d21d1d;
      font-size: 2.5rem;
      margin: 10px 0;
    }

    .company-info {
      text-align: center;
      font-size: 0.9rem;
      color: #666;
    }

    .bill-to {
      background: transparent;
      /* padding: 10px 10px; */
      margin-top: 20px;
      border-top: 1px solid #d21d1d;
      margin-bottom: 20px;
      border-bottom: 1px solid #d21d1d;
    }

    .bill-to strong{
      color: #d21d1d;
    }
    .invoice-details {
      
      margin-bottom: 20px;
    }

    .invoice-details table {
            border-collapse: collapse; /* Menggabungkan batas */
            width: 100%; /* Mengatur lebar tabel */
        }
        .invoice-details table th, .invoice-details table td {
          background: transparent;
          color: #333;
            border: none; /* Menghilangkan border */
            padding: 10px; /* Menambahkan padding untuk sel */
            text-align: left; /* Menyelaraskan teks ke kiri */
        }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    table th, table td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    table th {
      background: #d21d1d;
      color: #fff;
      font-weight: bold;
    }

    .totals {
      text-align: right;
    }

    .totals .balance-due {
      font-size: 1.5rem;
      color: #d21d1d;
    }

    .notes, .terms {
      margin-top: 20px;
      font-size: 0.9rem;
      color: #666;
    }

    .terms {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="invoice-container">
    <div class="header">
      <img src="{{ public_path('images/Logo optima feed.png') }}" alt="Logo" style="max-height: 70px; width: 90px">
      <h1>INVOICE</h1>
      {{-- <p class="company-info">148B, Northern Street Greater South Avenue New York 10001 U.S.A</p> --}}
    </div>

    <div class="bill-to">
      <p><strong>Customer Name:  </strong>{{$order->user->name}}</p>
      <p><strong>Number Telephone:</strong> {{$order->user->no_hp}}</p>
      <p><strong>Shipping To: </strong><br>
        {{ $order->address->full_nama }}<br>{{ $order->address->kelurahan }}, {{ $order->address->detail_alamat }}<br>
        {{ $order->address->kecamatan }}, {{ $order->address->kabupaten }}, {{ $order->address->provinsi }}, {{ $order->address->kode_pos }}<br>
        {{ $order->address->no_hp }}</p>
      
    </div>

    <div class="invoice-details">
      <table>
        <thead>
          <tr>
            <th>Order Number</th>
            <th>Order Date</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{$order->order_number}}</td>
            <td>{{ date('d/m/Y', strtotime($order->date_order)) }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <table>
      <thead>
        <tr>
          <th>Product</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
        </tr>
      </thead>
      <tbody>
        @php
            $subtotal_cart = 0; // Inisialisasi subtotal
            $total_items = 0; // Inisialisasi jumlah total barang
        @endphp
        @foreach($order->cart_info as $cart)
        @php 
        $product=DB::table('products')
                    ->select('title', 'price', 'discount')
                    ->where('id', $cart->product_id)
                    ->first();
        // Hitung harga setelah diskon
        $discountedPrice = $product->price - ($product->price * ($product->discount / 100));
        $subtotal = $discountedPrice * $cart->quantity;
        $subtotal_cart += $subtotal; 
        $total_items += $cart->quantity;
    @endphp
        <tr>
          <td>
            <span>{{$product->title}}</span>
        </td>
        <td>Rp{{number_format($discountedPrice, 0, ',', '.')}}</td>
        <td>x{{$cart->quantity}}</td>
        <td>Rp{{number_format($subtotal, 0, ',', '.')}}</td> 
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="totals">
      <p>Subtotal Product: <strong>Rp{{number_format($subtotal_cart, 0, ',', '.')}}</</strong></p>
      <p>Shipping Cost: <strong>Rp @if ($order->shipping->status_biaya == 0)
        {{ $order->ongkir, 0, ',', '.' }}
    @else
        {{ $order->shipping->price, 0, ',', '.' }}
    @endif</strong></p>
      <h3 class="balance-due">Total: Rp{{number_format($order->total_amount, 0, ',', '.')}}</h3>
    </div>

    <div class="notes">
      <p>PT. Agro Apis Palacio<br>
        Randuagung, Sukomoro, Kec. Magetan, Kabupaten Magetan, Jawa Timur 63391</p>
    </div>
  </div>
</body>
</html>



