<?php

namespace App\Http\Controllers;

use PDF;
use Helper;
use App\User;
use Notification;
use App\Services\WhatsAppService;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\StatusNotification;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     $orders=Order::orderBy('id','DESC')->paginate(10);
    //     $newOrders = Order::where('status', 'new')->paginate(10);
    //     $processingOrders = Order::where('status', 'processing')->paginate(10);
    //     $deliveredOrders = Order::where('status', 'delivered')->paginate(10);
    //     $canceledOrders = Order::where('status', 'canceled')->paginate(10);
    //     return view('backend.order.index')->with('orders',$orders, 'newOrders', 'processingOrders', 'deliveredOrders', 'canceledOrders', $newOrders, $processingOrders, $deliveredOrders, $canceledOrders);
    // }

    public function index(Request $request)
{
    $search = $request->get('search');
    // Use paginate instead of get
    // $allOrders = Order::orderBy('id','DESC')->paginate(10);
    $allOrders = Order::orderBy('id', 'DESC')
    ->where(function ($query) use ($search) {
        if ($search) {
            $query->where('order_number', 'like', '%'.$search.'%')
                  ->orWhereHas('user', function ($query) use ($search) {
                      $query->where('name', 'like', '%'.$search.'%');
                  });
        }
    })
    ->paginate(10);
    $newOrders = Order::with(['payment', 'user', 'address', 'shipping', 'cart.product.gambarProduk'])->where('status', 'new')->paginate(10); // Adjust the number for your pagination
    $topayOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'to pay')->paginate(10);
    $toshipOrders = Order::with(['payment', 'user', 'address', 'cart.product.gambarProduk'])->where('status', 'to ship')->paginate(10);
    $toreceiveOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'to receive')->paginate(10);
    $completedOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'completed')->paginate(10);
    $cancelOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->whereIn('status', ['cancel', 'rejected'])->paginate(10);
    // $pendingcancel = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->whereIn('status', ['cancel', 'rejected'])->paginate(10);
    $pendingCancel = Order::with(['payment', 'user', 'cart.product.gambarProduk', 'cancel'])
    ->whereHas('cancel', function ($query) {
        $query->where('status_pembatalan', 'pending');
    })
    ->paginate(10);

    $rejectedOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'rejected')->paginate(10);

    return view('backend.order.index', compact('allOrders', 'newOrders', 'topayOrders', 'toshipOrders', 'toreceiveOrders', 'completedOrders', 'cancelOrders', 'pendingCancel', 'rejectedOrders'));
}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validationRules = [
            'payment_method' => 'required|in:cod,online payment',
        ];
    
        // Jika alamat baru, validasi alamat lengkap
        if (!$request->has('address_id')) {
            $validationRules = array_merge($validationRules, [
                'full_nama' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'provinsi' => 'required|string',
                'kabupaten' => 'required|string',
                'kecamatan' => 'required|string',
                'kelurahan' => 'required|string',
                'detail_alamat' => 'required|string',
                'kode_pos' => 'required|digits:5',
                'jenis_alamat' => 'in:Rumah,Kantor',
            ]);
        }

            // Validasi form checkout
            $request->validate($validationRules);

            // Proses alamat
            if ($request->has('address_id')) {
                $address = Address::find($request->address_id);
                if (!$address) {
                    return back()->withErrors(['address_id' => 'Alamat yang dipilih tidak ditemukan.']);
                }
            } else {
                // Buat alamat baru
                $address = new Address;
                $address->user_id = auth()->id();
                $address->full_nama = $request->full_nama;
                $address->no_hp = $request->no_hp;
                $address->provinsi = $request->provinsi;
                $address->kabupaten = $request->kabupaten;
                $address->kecamatan = $request->kecamatan;
                $address->kelurahan = $request->kelurahan;
                $address->kode_pos = $request->kode_pos;
                $address->detail_alamat = $request->detail_alamat;
                $address->jenis_alamat = $request->jenis_alamat;
                $address->is_default = 1; // Set sebagai alamat default jika perlu
                $address->save();
            }
                
        // return $request->all();

        if(empty(Cart::where('user_id',auth()->user()->id)->where('order_id',null)->first())){
            request()->session()->flash('error','Cart is Empty !');
            return back();
        }

        // Ambil informasi shipping
        $shipping = Shipping::find($request->shipping);
        $status_biaya = $shipping->status_biaya; // 1 = diketahui, 0 = belum diketahui
        $shipping_cost = $shipping->price;

        // Atur status pesanan berdasarkan metode pembayaran dan status biaya
        if ($status_biaya == 0) {
            $order_status = 'new';
        } else {
            $order_status = $request->payment_method == 'cod' ? 'to ship' : 'to pay';
        }
        
        // $order_data=$request->all();
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        $order_data['user_id']=$request->user()->id;
        $order_data['address_id'] = $address->id; 
        $order_data['shipping_id']=$request->shipping;
        // $shipping=Shipping::where('id',$order_data['shipping_id'])->pluck('price');
        // // return session('coupon')['value'];
        // $order_data['sub_total']=Helper::totalCartPrice();
        $order_data['date_order']= now();
        // $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0];
        $order_data['total_amount']=Helper::totalCartPrice()+$shipping_cost;
        $order_data['status'] = $order_status;
        
        

        $order=new Order();  
        $order->fill($order_data);
        if (!$order->save()) {
            return back()->with('error', 'Terjadi kesalahan saat menyimpan pesanan.');
        }
        // dd($order->id);
        $users=User::where('role','admin')->first();
        $details=[
            'title'=>'New Order Received',
            'actionURL'=>route('order.show',$order->id),
            'fas'=>'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));
       
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);

         // Simpan pembayaran
         $payment = new Payment();
         $payment->order_id = $order->id;
         $payment->user_id = auth()->id();
         $payment->method_payment = $request->payment_method;
        //  $payment->total_bayar = $order->total_amount;
         $payment->status = 'unpaid'; // Status pembayaran
         $payment->save();

         // Kirim pesan WA ke admin
        // Kirim pesan WA ke admin hanya jika status_biaya adalah 0 dan status pesanan adalah 'new'
        if ($status_biaya == 0 && $order_status == 'new') {
            $admin = User::where('role', 'admin')->where('status', 'active')->first();
            if ($admin) {
                $waMessage = "Terdapat pesanan baru:\n" .
                    "Nomor Pesanan: {$order->order_number}\n" .
                    "Total: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n" .
                    "Metode Pembayaran: {$request->payment_method}\n".
                    "Silakan verifikasi pesanan segera.";
                WhatsAppService::sendMessage($admin->no_hp, $waMessage);
            }
        }

        // $waMessage = "Pesanan baru telah diterima:\n\n" .
        //     "Nomor Pesanan: {$order->order_number}\n" .
        //     "Total: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n" .
        //     "Metode Pembayaran: {$request->payment_method}\n\n" .
        //     "Silakan verifikasi pesanan segera.";
        
        // WhatsAppService::sendMessage($nomorAdmin, $waMessage);
        // dd($users);        
        request()->session()->flash('success','Your product order has been placed. Thank you for shopping with us.');
        return redirect()->route('frontend.pages.account.order');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('backend.order.edit')->with('order',$order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updateStatus(Request $request, $orderId)
    {
        // Validasi status yang diterima dari request
        $validated = $request->validate([
            'status' => 'required|in:new,to pay,to ship,to receive,completed,cancel,rejected', // Tambahkan 'accepted' pada status valid
            'alasan' => 'required_if:status,rejected|required_if:status,cancel|string',
            'ongkir' => 'nullable|string',

        ]);

        // Temukan pesanan berdasarkan ID
        $order = Order::find($orderId);

        // Cek apakah pesanan ditemukan
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found!');
        }

        $buyer = $order->user; // Mengambil informasi pengguna (pembeli)
        $buyerPhone = $buyer->no_hp; // Ambil nomor HP pembeli
        $buyername= $buyer->name;
        $websiteUrl = 'https://www.example.com'; // Ganti dengan URL website perusahaan Anda
        // Perbarui status pesanan
        $order->status = $request->status;
        if ($request->status === 'to pay' && isset($request->ongkir)) {
            $order->ongkir = $request->ongkir; // Simpan nilai ongkir
            $order->total_amount += $request->ongkir; // Tambahkan ongkir ke total_amount
            $message = "Yth. {$buyername}\n Terima kasih telah berbelanja Pakan Ternak di website kami.\nKami ingin memberitahukan bahwa pesanan Anda dengan nomor {$order->order_number} telah disetujui\n
                            Total yang harus dibayar: Rp " . number_format($order->total_amount, 0, ',', '.') . " \n
                            Silakan lakukan pembayaran sebelum batas waktu yang telah ditentukan.\n
                            Untuk informasi lebih lanjut mengenai pesanan, kunjungi website kami: {$websiteUrl}\n
                            Terimakasih.";
                            WhatsAppService::sendMessage($buyerPhone, $message);
        }

        if ($request->status === 'to ship') {
            if ($order->shipping->status_biaya == 0 && $order->payment->method_payment == 'cod') {
                // Simpan ongkir di tabel Order jika pembayaran COD
                $validatedData = $request->validate([
                    'ongkir' => 'required|numeric|min:0',
                ]);
    
                $order->ongkir = $validatedData['ongkir'];
                $order->total_amount += $validatedData['ongkir']; // Tambahkan ongkir ke total_amount
                $message = "Yth. {$buyername}\nTerima kasih telah berbelanja Pakan Ternak di website kami.\nKami ingin memberitahukan bahwa pesanan Anda dengan nomor {$order->order_number} telah disetujui\nTotal yang harus dibayar: Rp " . number_format($order->total_amount, 0, ',', '.') . " \nPesanan akan dikemas segera mungkin\nUntuk informasi lebih lanjut mengenai pesanan, kunjungi website kami: {$websiteUrl}\nTerimakasih.";
                            WhatsAppService::sendMessage($buyerPhone, $message);
            } else {
                // // Logika untuk selain COD
                // if ($order->shipping->status_biaya == 0) {
                //     $validatedData = $request->validate([
                //         'ongkir' => 'required|numeric|min:0',
                //     ]);
    
                //     $order->shipping->update(['ongkir' => $validatedData['ongkir']]);
                // }
    
                // Perbarui data di tabel pembayaran untuk non-COD
                $payment = $order->payment;
                if ($payment && $payment->method_payment !== 'cod') {
                    $payment->status = 'paid'; // Ubah status menjadi paid
                    $payment->date_payment = now(); // Tanggal pembayaran saat ini
                    $payment->total_bayar = $order->total_amount; // Total bayar sama dengan total_amount di pesanan
                    $payment->save();
                }
            }
            // Perbarui data di tabel pembayaran
            // $payment = $order->payment; // Ambil data pembayaran terkait pesanan
            // if ($payment) {
            //     $payment->status = 'paid'; // Ubah status menjadi paid
            //     $payment->date_payment = now(); // Tanggal pembayaran saat ini
            //     $payment->total_bayar = $order->total_amount; // Total bayar sama dengan total_amount di pesanan
            //     $payment->save(); // Simpan perubahan di tabel pembayaran
            // }
        }
        
        if ($request->status === 'to receive') {
            $order->date_shipped = now(); // Mengisi tanggal saat ini
        }
        if ($request->status === 'cancel') {
            $order->date_cancel = now(); // Mengisi tanggal saat ini
            $order->alasan = $request->alasan;
            $message = "Yth. {$buyername}\n".
                            "Kami memberitahu bahwa pesanan Anda dengan nomor {$order->order_number} telah ditolak. Dengan alasan {$request->alasan}.\n".
                            "Untuk informasi lebih lanjut atau jika Anda membutuhkan bantuan lebih lanjut, kami siap membantu Anda. Silakan kunjungi situs web kami di {$websiteUrl}\n".
                            "Terima kasih.";
                            WhatsAppService::sendMessage($buyerPhone, $message);
        }
        // Jika status diterima, update stok produk
        if ($request->status == 'completed') {
            $order->date_received = now();
            // Loop melalui item di pesanan dan kurangi stok produk
            foreach ($order->cart as $cartItem) {
                $product = $cartItem->product;

                // Kurangi stok berdasarkan jumlah yang dipesan
                $product->stock -= $cartItem->quantity;
                $product->save();
            }
        }

        // Jika status dibatalkan, kembalikan stok produk
        // if ($request->status == 'cancel' || $request->status == 'rejected') {
        //     foreach ($order->cart as $cartItem) {
        //         $product = $cartItem->product;

        //         // Tambahkan kembali stok berdasarkan jumlah yang dibatalkan
        //         $product->stock += $cartItem->quantity;
        //         $product->save();
        //     }
        // }

        if ($request->status === 'rejected') {
            $order->alasan = $request->alasan; 
            $message =  "Yth. {$buyername}\n".
                            "Kami memberitahu bahwa pesanan Anda dengan nomor {$order->order_number} telah ditolak. Dengan alasan {$request->alasan}.\n".
                            "Untuk informasi lebih lanjut atau jika Anda membutuhkan bantuan lebih lanjut, kami siap membantu Anda. Silakan kunjungi situs web kami di {$websiteUrl}\n".
                            "Terima kasih.";
                            WhatsAppService::sendMessage($buyerPhone, $message);
        }

        // Simpan perubahan
        $status=$order->save();
        if($status){
    
            // Kirim pesan ke nomor pembeli melalui WhatsApp
            
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
        }

        // Redirect dengan pesan sukses
        return redirect()->route('order.index');
    }

    
    public function updateOrder(Request $request, $orderId)
    {
        // Validasi status yang diterima dari request
        $validated = $request->validate([
            'status' => 'required|in:new,to pay,to ship,to receive,completed,cancel,rejected', // Tambahkan 'accepted' pada status valid
            'alasan' => 'required_if:status,rejected|required_if:status,cancel|string',
        ]);

        // Temukan pesanan berdasarkan ID
        $order = Order::find($orderId);

        // Cek apakah pesanan ditemukan
        if (!$order) {
            return redirect()->back()->with('error', 'Order not found!');
        }

        // Perbarui status pesanan
        $order->status = $request->status;
        // if ($request->status === 'to ship') {
        //     // Mengisi tanggal saat ini
        // }
        if ($request->status === 'to receive') {
            $order->date_shipped = now(); // Mengisi tanggal saat ini
        }
        if ($request->status === 'cancel') {
            $order->date_cancel = now(); // Mengisi tanggal saat ini
            $order->alasan = $request->alasan;
        }
        // Jika status diterima, update stok produk
        if ($request->status == 'completed') {
            $order->date_received = now();
            // Loop melalui item di pesanan dan kurangi stok produk
            foreach ($order->cart as $cartItem) {
                $product = $cartItem->product;

                // Kurangi stok berdasarkan jumlah yang dipesan
                $product->stock -= $cartItem->quantity;
                $product->save();
            }
        }

        // Jika status dibatalkan, kembalikan stok produk
        if ($request->status == 'cancel' || $request->status == 'rejected') {
            foreach ($order->cart as $cartItem) {
                $product = $cartItem->product;

                // Tambahkan kembali stok berdasarkan jumlah yang dibatalkan
                $product->stock += $cartItem->quantity;
                $product->save();
            }
        }

        if ($request->status === 'rejected') {
            $order->alasan = $request->alasan; 
        }

        // Simpan perubahan
        $status=$order->save();
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
        }

        // Redirect dengan pesan sukses
        return redirect()->route('frontend.pages.account.order');
    }

    private function sendWhatsAppMessage($nomorHp, $pesan)
{
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array(
            'target' => $nomorHp,
            'message' => $pesan,
            'countryCode' => '62', //optional
        ),
        CURLOPT_HTTPHEADER => array(
            'Authorization: '
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
}

    public function buyAgain(Request $request, Order $order)
    {
        // Validasi agar hanya pemilik pesanan dapat membeli kembali
        if ($order->user_id != auth()->id()) {
            return back()->with('error', 'Unauthorized action.');
        }

        foreach ($order->cart as $cartItem) {
            $product = $cartItem->product;

            if (!$product) {
                continue; // Lewati jika produk tidak ditemukan
            }

            $existingCart = Cart::where('user_id', auth()->id())
                ->where('order_id', null)
                ->where('product_id', $product->id)
                ->first();

            // Jika produk sudah ada di keranjang
            if ($existingCart) {
                $newQuantity = $existingCart->quantity + $cartItem->quantity;

                // Validasi stok
                if ($product->stock < $newQuantity) {
                    return back()->with('error', "Stock not sufficient for {$product->title}.");
                }

                $existingCart->quantity = $newQuantity;
                $existingCart->save();
            } else {
                // Jika produk belum ada di keranjang
                if ($product->stock < $cartItem->quantity) {
                    return back()->with('error', "Stock not sufficient for {$product->title}.");
                }

                Cart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                ]);
            }
        }

        return redirect()->route('cart')->with('success', 'Products have been added to your cart.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order=Order::find($id);
        if($order){
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->route('order.index');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    

    // PDF generate
    public function pdf(Request $request){
        $order=Order::getAllOrder($request->id);
        // return $order;
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        // return $file_name;
        $pdf=PDF::loadview('backend.order.pdf',compact('order'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
