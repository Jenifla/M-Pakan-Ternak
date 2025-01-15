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
            request()->session()->flash('error','Produk Tidak Valid');
            return back();
        }        
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Produk Tidak Valid');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price+ $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stok tidak cukup!.');
            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            //$price = ($product->price-($product->price*$product->discount)/100);
            $cart->quantity = 1;
            //$cart->amount=$price*$cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stok tidak cukup!.');
            $cart->save();
            
        }
        request()->session()->flash('success','Produk telah ditambahkan ke keranjang');
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
            return back()->with('error','Stok tidak cukup!.');
        }
        if ( ($request->quant[1] < 1) || empty($product) ) {
            request()->session()->flash('error','Produk Tidak Valid');
            return back();
        }    

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();

        // return $already_cart;

        if($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
            $already_cart->amount = ($product->price * $request->quant[1])+ $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stok tidak cukup!.');

            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            //$price = ($product->price-($product->price*$product->discount)/100);
            $cart->quantity = $request->quant[1];
            //$cart->amount=($price * $request->quant[1]);
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stok tidak cukup!.');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('success','Produk telah ditambahkan ke keranjang');
        return back();       
    } 

    
    
    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success','Produk Keranjang berhasil dihapus');
            return back();  
        }
        request()->session()->flash('error','Kesalahan, silakan coba lagi');
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
                    if ($cart->product->stock <= 0) {
                        // Jika stok produk = 0
                        $productName = $cart->product->title; 
                        request()->session()->flash('error', 'Stok produk "' . $productName . '" habis. Silakan hapus produk dari keranjang.');
                        return back();
                    } elseif ($cart->product->stock < $quant) {
                        // Jika stok produk < kuantitas yang diminta
                        $productName = $cart->product->title; 
                        request()->session()->flash('error', 'Stok produk "' . $productName . '" tidak mencukupi.');
                        return back();
                    }
                    
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant  : $cart->product->stock;
                    // return $cart;
                    $cart->save();
                    $success = 'Keranjang berhasil diperbarui!';
                }else{
                    $error[] = 'Keranjang Tidak Valid!';
                }
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Keranjang Tidak Valid!');
        }    
    }

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

}
