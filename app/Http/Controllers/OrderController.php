<?php

namespace App\Http\Controllers;

use PDF;
use Helper;
use App\User;
use Notification;
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

    public function index()
{
    // Use paginate instead of get
    $allOrders = Order::orderBy('id','DESC')->paginate(10);
    $newOrders = Order::where('status', 'new')->paginate(10); // Adjust the number for your pagination
    $topayOrders = Order::where('status', 'to pay')->paginate(10);
    $toshipOrders = Order::where('status', 'to ship')->paginate(10);
    $toreceiveOrders = Order::where('status', 'to receive')->paginate(10);
    $completedOrders = Order::where('status', 'completed')->paginate(10);
    $cancelOrders = Order::where('status', 'cancel')->paginate(10);
    $rejectedOrders = Order::where('status', 'rejected')->paginate(10);

    return view('backend.order.index', compact('allOrders', 'newOrders', 'topayOrders', 'toshipOrders', 'toreceiveOrders', 'completedOrders', 'cancelOrders', 'rejectedOrders'));
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
        
         // Data pesanan awal
    // $orderData = [
    //     'order_number' => 'ORD-' . strtoupper(Str::random(10)),
    //     'user_id' => auth()->id(),
    //     'address_id' => $address->id,
    //     'shipping_id' => $request->shipping,
    //     'sub_total' => Helper::totalCartPrice(),
    //     'quantity' => Helper::cartCount(),
    //     'date_order' => now()
    // ];

    // // Perhitungan total dengan biaya pengiriman dan diskon
    // $shippingCost = Shipping::where('id', $orderData['shipping_id'])->value('price') ?? 0;
    // $orderData['total_amount'] = $orderData['sub_total'] + $shippingCost;
        // $order_data=$request->all();
        $order_data['order_number']='ORD-'.strtoupper(Str::random(10));
        $order_data['user_id']=$request->user()->id;
        $order_data['address_id'] = $address->id; 
        $order_data['shipping_id']=$request->shipping;
        $shipping=Shipping::where('id',$order_data['shipping_id'])->pluck('price');
        // // return session('coupon')['value'];
        // $order_data['sub_total']=Helper::totalCartPrice();
        $order_data['date_order']= now();
        $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0];
        // if(session('coupon')){
        //     $order_data['coupon']=session('coupon')['value'];
        // }
        // if($request->shipping){
        //     if(session('coupon')){
        //         $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
        //     }
        //     else{
        //         $order_data['total_amount']=Helper::totalCartPrice()+$shipping[0];
        //     }
        // }
        // else{
        //     if(session('coupon')){
        //         $order_data['total_amount']=Helper::totalCartPrice()-session('coupon')['value'];
        //     }
        //     else{
        //         $order_data['total_amount']=Helper::totalCartPrice();
        //     }
        // }
        
        

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
        // dd($users);        
        request()->session()->flash('success','Your product order has been placed. Thank you for shopping with us.');
        return redirect()->route('home');
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
    public function update(Request $request, $id)
    {
        $order=Order::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,process,delivered,cancel'
        ]);
        $data=$request->all();
        // return $request->status;
        if($request->status=='delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }
        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
        }
        return redirect()->route('order.index');
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
