<?php

namespace App\Http\Controllers;
use Auth;
use Helper;
use App\Models\Cart;
use App\Models\Product;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\RajaOngkirService;

class CartController extends Controller
{
    public function getCartCount(Request $request)
    {
        // Menghitung jumlah cart untuk pengguna yang terautentikasi
        $cartCount = Helper::cartCount();

        // Mengembalikan response dengan jumlah cart
        return response()->json(['cart_count' => $cartCount]);
    }
    
    protected $product=null;
    protected $rajaOngkir;
    public function __construct(Product $product, RajaOngkirService $rajaOngkir){
        $this->product=$product;
        $this->rajaOngkir = $rajaOngkir;
    }

    public function addToCart(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }        
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price+ $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price-($product->price*$product->discount)/100);
            $cart->quantity = 1;
            $cart->amount=$cart->price*$cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $cart->save();
            
        }
        request()->session()->flash('success','Product has been added to cart');
        return back();       
    }  

    public function singleAddToCart(Request $request){
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        // dd($request->quant[1]);


        $product = Product::where('slug', $request->slug)->first();
        if($product->stock <$request->quant[1]){
            return back()->with('error','Out of stock, You can add other products.');
        }
        if ( ($request->quant[1] < 1) || empty($product) ) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }    

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();

        // return $already_cart;

        if($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
            $already_cart->amount = ($product->price * $request->quant[1])+ $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');

            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->price = ($product->price-($product->price*$product->discount)/100);
            $cart->quantity = $request->quant[1];
            $cart->amount=($product->price * $request->quant[1]);
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('success','Product has been added to cart.');
        return back();       
    } 
    
    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success','Cart removed successfully');
            return back();  
        }
        request()->session()->flash('error','Error please try again');
        return back();       
    }     

    public function cartUpdate(Request $request){
        // dd($request->all());
        if($request->quant){
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k=>$quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if($quant > 0 && $cart) {
                    // return $quant;

                    if($cart->product->stock < $quant){
                        request()->session()->flash('error','Out of stock');
                        return back();
                    }
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant  : $cart->product->stock;
                    // return $cart;
                    
                    if ($cart->product->stock <=0) continue;
                    $after_price=($cart->product->price-($cart->product->price*$cart->product->discount)/100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Cart updated successfully!';
                }else{
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Cart Invalid!');
        }    
    }

    // public function addToCart(Request $request){
    //     // return $request->all();
    //     if(Auth::check()){
    //         $qty=$request->quantity;
    //         $this->product=$this->product->find($request->pro_id);
    //         if($this->product->stock < $qty){
    //             return response(['status'=>false,'msg'=>'Out of stock','data'=>null]);
    //         }
    //         if(!$this->product){
    //             return response(['status'=>false,'msg'=>'Product not found','data'=>null]);
    //         }
    //         // $session_id=session('cart')['session_id'];
    //         // if(empty($session_id)){
    //         //     $session_id=Str::random(30);
    //         //     // dd($session_id);
    //         //     session()->put('session_id',$session_id);
    //         // }
    //         $current_item=array(
    //             'user_id'=>auth()->user()->id,
    //             'id'=>$this->product->id,
    //             // 'session_id'=>$session_id,
    //             'title'=>$this->product->title,
    //             'summary'=>$this->product->summary,
    //             'link'=>route('product-detail',$this->product->slug),
    //             'price'=>$this->product->price,
    //             'photo'=>$this->product->photo,
    //         );
            
    //         $price=$this->product->price;
    //         if($this->product->discount){
    //             $price=($price-($price*$this->product->discount)/100);
    //         }
    //         $current_item['price']=$price;

    //         $cart=session('cart') ? session('cart') : null;

    //         if($cart){
    //             // if anyone alreay order products
    //             $index=null;
    //             foreach($cart as $key=>$value){
    //                 if($value['id']==$this->product->id){
    //                     $index=$key;
    //                 break;
    //                 }
    //             }
    //             if($index!==null){
    //                 $cart[$index]['quantity']=$qty;
    //                 $cart[$index]['amount']=ceil($qty*$price);
    //                 if($cart[$index]['quantity']<=0){
    //                     unset($cart[$index]);
    //                 }
    //             }
    //             else{
    //                 $current_item['quantity']=$qty;
    //                 $current_item['amount']=ceil($qty*$price);
    //                 $cart[]=$current_item;
    //             }
    //         }
    //         else{
    //             $current_item['quantity']=$qty;
    //             $current_item['amount']=ceil($qty*$price);
    //             $cart[]=$current_item;
    //         }

    //         session()->put('cart',$cart);
    //         return response(['status'=>true,'msg'=>'Cart successfully updated','data'=>$cart]);
    //     }
    //     else{
    //         return response(['status'=>false,'msg'=>'You need to login first','data'=>null]);
    //     }
    // }

    // public function removeCart(Request $request){
    //     $index=$request->index;
    //     // return $index;
    //     $cart=session('cart');
    //     unset($cart[$index]);
    //     session()->put('cart',$cart);
    //     return redirect()->back()->with('success','Successfully remove item');
    // }

    public function checkout(Request $request){
        $user = auth()->user();
        $response = $this->rajaOngkir->getProvinces();
        $provinces = $response['rajaongkir']['results'];

        // Jika ada ID provinsi yang dipilih, ambil data kota
        $cities = [];
        if ($request->has('province_id')) {
            $provinceId = $request->input('province_id');
            $responseCities = $this->rajaOngkir->getCities($provinceId);
            $cities = $responseCities['rajaongkir']['results'];
        }

        return view('frontend.pages.checkout', compact('provinces', 'cities', 'user'));
    }

    public function getCities(Request $request)
    {
        $provinceId = $request->provinceId;
        // dd($provinceId);
        // Ambil kota berdasarkan provinsi
        $response = $this->rajaOngkir->getCities($provinceId);
        $cities = $response['rajaongkir']['results'];

        return response()->json($cities);
    }

    // public function calculateShippingCost(Request $request)
    // {
    //     // Ambil ID kota asal (misalnya, ID kota asal tetap 501 atau ID kota pengguna)
    //     $origin = 251; // ID kota asal

    //     // Ambil ID kota tujuan dari form input
    //     $destination = $request->destination; // ID kota tujuan yang dipilih pengguna

    //     // Ambil berat barang dari data produk di keranjang
    //     $cartItems = $request->cart_items; // Anggap cart_items adalah array produk di keranjang

    //     $weight = 0;
    //     foreach ($cartItems as $item) {
    //         // Mengambil berat dari data produk yang ada di keranjang
    //         $product = Product::find($item['product_id']); // Temukan produk berdasarkan ID
    //         $weight += $product->weight * $item['quantity']; // Tambahkan berat produk * kuantitas
    //     }

    //     // Set default courier sebagai POS
    //     $courier = 'pos';

    //     // Hitung ongkos kirim
    //     $cost = $this->rajaOngkir->getShippingCost($origin, $destination, $weight, $courier);

    //     // Kembalikan ongkos kirim dalam bentuk response JSON
    //     return response()->json($cost);
    // }

    public function calculateShippingCost(Request $request)
    {
        // Ambil data dari request
        $origin = $request->input('origin');        // Kota asal
        $destination = $request->input('destination');  // Kota tujuan
        $weight = $request->input('weight');        // Berat barang
        $courier = $request->input('courier');      // Nama kurir

        // Validasi input (optional, tergantung kebutuhan)
        $validated = $request->validate([
            'origin' => 'required|integer',
            'destination' => 'required|integer',
            'weight' => 'required|integer',
            'courier' => 'required|string',
        ]);

        try {
            // Panggil service untuk mendapatkan ongkos kirim
            $shippingCost = $this->rajaOngkir->getShippingCost($origin, $destination, $weight, $courier);

            // Kembalikan hasil ongkos kirim dalam response JSON
            return response()->json($shippingCost);
        } catch (\Exception $e) {
            // Tangani error jika ada
            return response()->json([
                'error' => 'Gagal mendapatkan ongkos kirim',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
