<?php
// use Auth;
use App\Models\Cart;
use App\Models\Order;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\Category;
use App\Models\Shipping;
use App\Models\Address;


class Helper{
    
    public static function getAllCategory(){
        $category=new Category();
        $menu=$category->getAllParentWithChild();
        return $menu;
    } 
    
    public static function getHeaderCategory(){
        $category = new Category();
        // dd($category);
        $menu=$category->getAllParentWithChild();

        if($menu){
            ?>
            
            <li>
            <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                <?php
                    foreach($menu as $cat_info){
                        if($cat_info->child_cat->count()>0){
                            ?>
                            <li><a href="<?php echo route('product-cat',$cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach($cat_info->child_cat as $sub_menu){
                                        ?>
                                        <li><a href="<?php echo route('product-sub-cat',[$cat_info->slug,$sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                            <?php
                        }
                        else{
                            ?>
                                <li><a href="<?php echo route('product-cat',$cat_info->slug);?>"><?php echo $cat_info->title; ?></a></li>
                            <?php
                        }
                    }
                    ?>
                </ul>
            </li>
        <?php
        }
    }

    public static function productCategoryList($option='all'){
        if($option='all'){
            return Category::orderBy('id','DESC')->get();
        }
        return Category::has('products')->orderBy('id','DESC')->get();
    }

    
    // Cart Count
    // public static function cartCount($user_id=''){
    //     try {
    //         // Mengambil pengguna yang terautentikasi melalui JWT
    //         $user = JWTAuth::parseToken()->authenticate();
    
    //         // Jika pengguna ditemukan, ambil ID pengguna
    //         if ($user) {
    //             if ($user_id == "") {
    //                 $user_id = $user->id;
    //             }
    
    //             // Menghitung jumlah cart untuk pengguna yang terautentikasi
    //             return Cart::where('user_id', $user_id)
    //                        ->where('order_id', null)
    //                        ->sum('quantity');
    //         }
    //     } catch (JWTException $e) {
    //         // Token tidak valid atau terjadi kesalahan lain
    //         return 0;
    //     }

    //     return 0;
    // }

    public static function cartCount($user_id=''){
       
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::where('user_id',$user_id)->where('order_id',null)->sum('quantity');
        }
        else{
            return 0;
        }
    }

    // relationship cart with product
    public function product(){
        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public static function getAddresses($user_id ='')
    {
        if (Auth::check()) {
            // If no user_id is provided, use the ID of the authenticated user
            if ($user_id == '') {
                $user_id = auth()->user()->id;
            }

            // Retrieve addresses for the given user_id
            return Address::where('user_id', $user_id)->get();
        } else {
            return 0;
        }
    }

    public static function getAllProductFromCart($user_id=''){
        if(Auth::check()){
            if($user_id=="") $user_id=auth()->user()->id;
            return Cart::with('product.gambarProduk')->where('user_id',$user_id)->where('order_id',null)->get();
        }
        else{
            return 0;
        }
    }
    // Total amount cart
    // public static function totalCartPrice($user_id=''){
    //     if(Auth::check()){
    //         if($user_id=="") $user_id=auth()->user()->id;
    //         // return Cart::where('user_id',$user_id)->where('order_id',null)->sum('amount');
    //         return Cart::where('user_id',$user_id)->where('order_id',null);
    //     }
    //     else{
    //         return 0;
    //     }
    // }
    public static function totalCartPrice($user_id=''){
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
    
            // Ambil semua produk dalam keranjang untuk pengguna tertentu
            $cart_items = Cart::with('product')->where('user_id', $user_id)->where('order_id', null)->get();
            
            $total_price = 0;
            
            // Iterasi setiap item dalam keranjang untuk menghitung total harga
            foreach ($cart_items as $item) {
                $product = $item->product;
                $original_price = $product->price; // Harga asli produk
                $discount = $product->discount; // Diskon produk
                $price_after_discount = $original_price - ($original_price * $discount / 100); // Harga setelah diskon
                $total_price += $price_after_discount * $item->quantity; // Tambahkan total harga produk berdasarkan kuantitas
            }
    
            return $total_price; // Kembalikan total harga keranjang
        } else {
            return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id,$user_id){
        $order=Order::find($id);
        dd($id);
        if($order){
            $shipping_price=(float)$order->shipping->price;
            $order_price=self::orderPrice($id,$user_id);
            return number_format((float)($order_price+$shipping_price),2,'.','');
        }else{
            return 0;
        }
    }


    // Admin home
    public static function earningPerMonth(){
        $month_data=Order::where('status','delivered')->get();
        // return $month_data;
        $price=0;
        foreach($month_data as $data){
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price),2,'.','');
    }

    public static function shipping(){
        return Shipping::orderBy('id','DESC')->get();
    }
}

?>