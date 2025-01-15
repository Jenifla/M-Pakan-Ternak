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

    public function index(Request $request)
{
    $search = $request->get('search');
    $activeTab = $request->get('active_tab', 'wait-cancel');
    $searchQuery = function ($query) use ($search) {
        if ($search) {
            // Search within the order number
            $query->where('order_number', 'like', '%'.$search.'%')
                ->orWhere('date_order', 'like', '%' . $search . '%')
                ->orWhere('date_shipped', 'like', '%' . $search . '%')
                ->orWhere('date_received', 'like', '%' . $search . '%')
                ->orWhere('date_cancel', 'like', '%' . $search . '%')
                ->orWhere('alasan', 'like', '%' . $search . '%')
                ->orWhere('total_amount', 'like', '%' . $search . '%')
                ->orWhere('status', 'like', '%' . $search . '%')
        
                // Search within the user (name)
                ->orWhereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', '%'.$search.'%');
                })

                // Search within the payment method (payment method name)
                ->orWhereHas('payment', function ($query) use ($search) {
                    $query->where('method_payment', 'like', '%'.$search.'%');
                })

                // Search within the address 
                ->orWhereHas('address', function ($query) use ($search) {
                    $query->where('provinsi', 'like', '%'.$search.'%')
                        ->orWhere('kabupaten', 'like', '%' . $search . '%')
                        ->orWhere('kecamatan', 'like', '%' . $search . '%')
                        ->orWhere('kelurahan', 'like', '%' . $search . '%')
                        ->orWhere('detail_alamat', 'like', '%' . $search . '%')
                        ->orWhere('kode_pos', 'like', '%' . $search . '%');
                })

                ->orWhereHas('cancel', function ($query) use ($search) {
                    $query->where('tgl_diajukan', 'like', '%'.$search.'%')
                        ->orWhere('alasan', 'like', '%' . $search . '%');
                })

                ->orWhereHas('refund', function ($query) use ($search) {
                    $query->where('bank_name', 'like', '%'.$search.'%')
                        ->orWhere('bank_account', 'like', '%' . $search . '%')
                        ->orWhere('bank_holder', 'like', '%' . $search . '%');
                })

                // Search within the cart and product (product name or SKU)
                ->orWhereHas('cart', function ($query) use ($search) {
                    $query->whereHas('product', function ($query) use ($search) {
                        $query->where('title', 'like', '%'.$search.'%');
                    });
                });

                
        }
    };

    $allOrders = Order::orderBy('id', 'DESC')
        ->where($searchQuery)
        ->paginate(10)
        ->appends(['search' => $search]);
    $newOrders = Order::with(['payment', 'user', 'address', 'shipping', 'cart.product.gambarProduk'])->where('status', 'new')->where($searchQuery)->paginate(10)->appends(['search' => $search]); // Adjust the number for your pagination
    $topayOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'to pay')->where($searchQuery)->paginate(10)->appends(['search' => $search]);
    // $toshipOrders = Order::with(['payment', 'user', 'address', 'cart.product.gambarProduk'])->where('status', 'to ship')->paginate(10);
    $toreceiveOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'to receive')->where($searchQuery)->paginate(10)->appends(['search' => $search]);
    $completedOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'completed')->where($searchQuery)->paginate(10)->appends(['search' => $search]);
    $canceledOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'cancel')->where($searchQuery)->paginate(10)->appends(['search' => $search]);
    $refundOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'refunded')->where($searchQuery)->paginate(10)->appends(['search' => $search]);
    $toshipOrders = Order::with(['payment', 'user', 'address', 'cart.product.gambarProduk'])->where('status', 'to ship')->where($searchQuery)
    ->whereDoesntHave('cancel', function ($query) {
        $query->where('status_pembatalan', 'pending');
    })
    ->paginate(10)->appends(['search' => $search]);

    // Mendapatkan pesanan yang sudah dibatalkan oleh admin dan membutuhkan pengembalian dana
    $waitrefundOrders = Order::with(['refund', 'payment', 'user', 'cart.product.gambarProduk'])
    ->whereHas('cancel', function ($query) {
        $query->where('status_pembatalan', 'disetujui'); // Status pembatalan yang disetujui
    })
    ->whereHas('payment', function ($query) {
        $query->where('method_payment', 'online payment'); // Metode pembayaran online
    })
    ->whereHas('refund', function ($query) {
        $query->whereIn('status', ['pending', 'approved']); // Metode pembayaran online
    })->where($searchQuery)
    ->paginate(10)
    ->appends(['search' => $search]);

    $allrefundOrders = Order::with(['refund', 'payment', 'user', 'cart.product.gambarProduk'])
    ->where('status', 'refunded') // Kondisi pertama: Pesanan yang sudah refunded
    ->orWhere(function ($query) {
        $query->whereHas('cancel', function ($subQuery) {
            $subQuery->where('status_pembatalan', 'disetujui'); // Pembatalan disetujui
        })
        ->whereHas('payment', function ($subQuery) {
            $subQuery->where('method_payment', 'online payment'); // Metode pembayaran online
        });
    })
    ->where($searchQuery)
    ->paginate(10)
    ->appends(['search' => $search]);

    // $pendingcancel = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->whereIn('status', ['cancel', 'rejected'])->paginate(10);
    $pendingCancel = Order::with(['payment', 'user', 'cart.product.gambarProduk', 'cancel'])
    ->whereHas('cancel', function ($query) {
        $query->where('status_pembatalan', 'pending');
    })
    ->where($searchQuery)
    ->paginate(10)
    ->appends(['search' => $search]);

    $rejectedOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'rejected')->where($searchQuery)->paginate(10)->appends(['search' => $search]);

    $orderCounts = [
        'all' => Order::count(), // Total jumlah pesanan untuk user yang login
        'new' => Order::where('status', 'new')->count(), // Pesanan Baru untuk user yang login
        'topay' => Order::where('status', 'to pay')->count(), // Belum Bayar untuk user yang login
        'toship' => Order::where('status', 'to ship')
        ->whereDoesntHave('cancel', function ($query) {
            $query->where('status_pembatalan', 'pending');
        })
        ->count(), // Dikemas untuk user yang login
        'toreceive' => Order::where('status', 'to receive')->count(), // Dikirim untuk user yang login
        'completed' => Order::where('status', 'completed')->count(), // Selesai untuk user yang login
        'cancelled' => Order::where('status', 'cancel')->count(), // Pembatalan untuk user yang login
        'rejected' => Order::where('status', 'rejected')->count(), 
    ];
    // Jumlah data Pending Cancel
    $pendingCancelCount = Order::whereHas('cancel', function ($query) {
        $query->where('status_pembatalan', 'pending');
    })->count();

    // Jumlah data Wait Refund
    $waitRefundCount = Order::whereHas('cancel', function ($query) {
        $query->where('status_pembatalan', 'disetujui'); // Status pembatalan yang disetujui
    })
    ->whereHas('payment', function ($query) {
        $query->where('method_payment', 'online payment'); // Metode pembayaran online
    })
    ->whereHas('refund', function ($query) {
        $query->whereIn('status', ['pending', 'approved']); // Status refund pending atau approved
    })->count();

    // Jumlah data Cancel Orders
    $cancelOrdersCount = Order::where('status', 'cancel')->count();

    // Total dari semua jumlah
    $totalCount = $pendingCancelCount + $waitRefundCount + $cancelOrdersCount;

    if ($activeTab === 'wait-cancel') {
        $pendingCancel = Order::with(['payment', 'user', 'cart.product.gambarProduk', 'cancel'])
                        ->whereHas('cancel', function ($query) {
                            $query->where('status_pembatalan', 'pending');
                        })
                        ->where($searchQuery)
                        ->paginate(10)
                        ->appends(['search' => $search]);
    } elseif ($activeTab === 'wait-refund') {
        $waitrefundOrders = Order::with(['refund', 'payment', 'user', 'cart.product.gambarProduk'])
                            ->whereHas('cancel', function ($query) {
                                $query->where('status_pembatalan', 'disetujui'); // Status pembatalan yang disetujui
                            })
                            ->whereHas('payment', function ($query) {
                                $query->where('method_payment', 'online payment'); // Metode pembayaran online
                            })
                            ->whereHas('refund', function ($query) {
                                $query->whereIn('status', ['pending', 'approved']); // Metode pembayaran online
                            })->where($searchQuery)
                            ->paginate(10)
                            ->appends(['search' => $search]);
    } elseif ($activeTab === 'all-cancel') {
        $canceledOrders = Order::with(['payment', 'user', 'cart.product.gambarProduk'])->where('status', 'cancel')->where($searchQuery)->paginate(10)->appends(['search' => $search]);
    }


    return view('backend.order.index', compact( 'activeTab', 'pendingCancelCount', 'waitRefundCount','orderCounts', 'totalCount', 'allOrders', 'newOrders', 'topayOrders', 'toshipOrders', 'toreceiveOrders', 'completedOrders', 'canceledOrders', 'pendingCancel', 'rejectedOrders', 'refundOrders', 'waitrefundOrders', 'allrefundOrders'));
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
        // dd($users);        
        request()->session()->flash('success','Pesanan produk berhasil dilakukan. Terima kasih telah berbelanja dengan kami.');
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
        $websiteUrl = 'https://optimafeed.apis.co.id/';
        // Perbarui status pesanan
        $order->status = $request->status;
        // Perbarui status pesanan di tab new order
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
            // Perbarui status pesanan di tab new order
            if ($order->shipping->status_biaya == 0 && $order->payment->method_payment == 'cod') {
                // Simpan ongkir di tabel Order jika pembayaran COD
                $validatedData = $request->validate([
                    'ongkir' => 'required|numeric|min:0',
                ]);
    
                $order->ongkir = $validatedData['ongkir'];
                $order->total_amount += $validatedData['ongkir']; // Tambahkan ongkir ke total_amount
                $message = "Yth. {$buyername}\nTerima kasih telah berbelanja Pakan Ternak di website kami.\nKami ingin memberitahukan bahwa pesanan anda dengan nomor {$order->order_number} telah disetujui\nTotal yang harus dibayar: Rp " . number_format($order->total_amount, 0, ',', '.') . " \nPesanan akan dikemas segera mungkin\nUntuk informasi lebih lanjut mengenai pesanan, kunjungi website kami: {$websiteUrl}\nTerimakasih.";
                            WhatsAppService::sendMessage($buyerPhone, $message);
            } else {
                // Perbarui status pesanan di tab topay order
                // Perbarui data di tabel pembayaran untuk non-COD
                $payment = $order->payment;
                if ($payment && $payment->method_payment !== 'cod') {
                    $payment->status = 'paid'; // Ubah status menjadi paid
                    $payment->date_payment = now(); // Tanggal pembayaran saat ini
                    $payment->total_bayar = $order->total_amount; // Total bayar sama dengan total_amount di pesanan
                    $payment->save();
                }
            }
        }
        
        // Perbarui status pesanan di tab toship order
        if ($request->status === 'to receive') {
            $order->date_shipped = now(); // Mengisi tanggal saat ini
        }

        // Perbarui status pesanan di tab toreceive order
        // Jika status diterima, update stok produk
        if ($request->status == 'completed') {
            $order->date_received = now();
            if ($order->payment->method_payment === 'cod') {
                $order->payment->status = 'paid';
                $order->payment->date_payment = now();
                $order->payment->save();
            }
            // Loop melalui item di pesanan dan kurangi stok produk
            foreach ($order->cart as $cartItem) {
                $product = $cartItem->product;

                // Kurangi stok berdasarkan jumlah yang dipesan
                $product->stock -= $cartItem->quantity;
                $product->save();
            }
        }

        // Perbarui status pesanan di tab new order
        if ($request->status === 'rejected') {
            $order->date_cancel = now();
            $order->alasan = $request->alasan; 
            $message =  "Yth. {$buyername}\n".
                            "Kami memberitahu bahwa pesanan anda dengan nomor {$order->order_number} telah ditolak. Dengan alasan {$request->alasan}.\n".
                            "Untuk informasi lebih lanjut atau jika anda membutuhkan bantuan lebih lanjut, kami siap membantu anda. Silakan kunjungi situs web kami di {$websiteUrl}\n".
                            "Terima kasih.";
                            WhatsAppService::sendMessage($buyerPhone, $message);
        }

        // Simpan perubahan
        $status=$order->save();
        if($status){
    
            // Kirim pesan ke nomor pembeli melalui WhatsApp
            
            request()->session()->flash('success','Order updated successfully');
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
            return redirect()->back()->with('error', 'Pesanan tidak ditemukan!');
        }

        // Perbarui status pesanan
        $order->status = $request->status;
        
        if ($request->status === 'cancel') {
            $order->date_cancel = now(); // Mengisi tanggal saat ini
            $order->alasan = $request->alasan;
        }
        // Jika status diterima, update stok produk
        if ($request->status == 'completed') {
            $order->date_received = now();
            if ($order->payment->method_payment === 'cod') {
                $order->payment->status = 'paid';
                $order->payment->date_payment = now();
                $order->payment->save();
            }
            // Loop melalui item di pesanan dan kurangi stok produk
            foreach ($order->cart as $cartItem) {
                $product = $cartItem->product;

                // Kurangi stok berdasarkan jumlah yang dipesan
                $product->stock -= $cartItem->quantity;
                $product->save();
            }
        }

        // Simpan perubahan
        $status=$order->save();
        if($status){
            request()->session()->flash('success','Pesanan berhasil diperbarui');
        }
        else{
            request()->session()->flash('error','Terjadi kesalahan saat memperbarui pesanan');
        }

        // Redirect dengan pesan sukses
        return redirect()->route('frontend.pages.account.order');
    }

    public function buyAgain(Request $request, Order $order)
    {
        // Validasi agar hanya pemilik pesanan dapat membeli kembali
        if ($order->user_id != auth()->id()) {
            return back()->with('error', 'Tindakan yang tidak sah.');
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
                    return back()->with('error', "Stok tidak cukup untuk {$product->title}.");
                }

                $existingCart->quantity = $newQuantity;
                $existingCart->save();
            } else {
                // Jika produk belum ada di keranjang
                if ($product->stock < $cartItem->quantity) {
                    return back()->with('error', "Stok tidak cukup untuk {$product->title}.");
                }

                Cart::create([
                    'user_id' => auth()->id(),
                    'product_id' => $product->id,
                    'quantity' => $cartItem->quantity,
                ]);
            }
        }

        return redirect()->route('cart')->with('success', 'Produk telah ditambahkan ke keranjang belanja Anda.');
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
    
}
