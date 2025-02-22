<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use Hash;
use PDF;
use App\User;
use Newsletter;
use App\Models\Cart;
use App\Models\Post;
use App\Models\Order;
use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class FrontendController extends Controller
{
   
    public function index(Request $request){
        return redirect()->route($request->user()->role);
    }

    public function home(){
       
        $posts=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $banners=Banner::where('status','active')->limit(3)->orderBy('id','DESC')->get();
        // return $banner;
        $products=Product::with('gambarProduk')->where('status','active')->orderBy('id','DESC')->limit(8)->get();
        $productsmost=Product::with('gambarProduk')->where('status','active')->orderBy('id','DESC')->get();
        $category=Category::where('status','active')->where('is_parent',1)->orderBy('title','ASC')->get();
        // return $category;
        return view('frontend.index')
                ->with('posts',$posts)
                ->with('banners',$banners)
                ->with('product_lists',$products)
                ->with('product_most',$productsmost)
                ->with('category_lists',$category);
    }   

    public function account(){
        return view('frontend.pages.account.account');
    }
    public function accountdashboard(){
        return view('frontend.pages.account.content');
    }
    
    public function accountorder()
    {
        // Mengambil data order dengan relasi carts dan product menggunakan eager loading
        $orders = Order::with(['cart.product.gambarProduk', 'refund', 'cancel'])
                        ->where('user_id', auth()->user()->id)
                        ->orderBy('id', 'DESC')
                        ->get();
        $orderCounts = [
            'all' => Order::where('user_id', Auth::id())->count(), // Total jumlah pesanan untuk user yang login
            'new' => Order::where('user_id', Auth::id())->where('status', 'new')->count(), // Pesanan Baru untuk user yang login
            'topay' => Order::where('user_id', Auth::id())->where('status', 'to pay')->count(), // Belum Bayar untuk user yang login
            'toship' => Order::where('user_id', Auth::id())->where('status', 'to ship')->count(), // Dikemas untuk user yang login
            'toreceive' => Order::where('user_id', Auth::id())->where('status', 'to receive')->count(), // Dikirim untuk user yang login
            'completed' => Order::where('user_id', Auth::id())->where('status', 'completed')->count(), // Selesai untuk user yang login
            'cancelled' => Order::where('user_id', Auth::id())->where('status', 'cancel')->count(), // Pembatalan untuk user yang login
        ];

        $admin = User::where('role', 'admin')
        ->where('status', 'active')
        ->first();
                        
        foreach ($orders as $order) {
            $order->paymentDeadline = date('Y-m-d H:i:s', strtotime($order->updated_at . ' + 24 hours'));
            $order->shippedDeadline = date('Y-m-d', strtotime($order->updated_at . ' + 3 days'));
        }

        return view('frontend.pages.account.order', compact('orders', 'orderCounts', 'admin'));
    }

    public function orderShow($id)
    {
        $order=Order::with(['payment', 'user', 'cart.product.gambarProduk'])->find($id);
        return view('frontend.pages.account.detailorder')->with('order',$order);
    }
    public function invoice(Request $request){
        $order=Order::getAllOrder($request->id);
        // return $order;
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        // return $file_name;
        $pdf=PDF::loadview('frontend.pages.account.invoice',compact('order'));
        return $pdf->download($file_name);
    }
    public function accountaddress(){
        return view('frontend.pages.account.address');
    }
    public function accountdetail(){
        $user = Auth::user();
        return view('frontend.pages.account.myaccount', compact('user'));
    }

    public function accountUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'no_hp' => 'required|regex:/^62[0-9]{8,15}$/',
            'password' => 'nullable|string|min:8', // Password lama (opsional untuk verifikasi)
            'npassword' => 'nullable|string|min:8|confirmed', // Baru + konfirmasi
        ]);

        $user = Auth::user();

        // Update data pengguna
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->no_hp = $request->input('no_hp');

        // Perbarui password hanya jika kolom password baru diisi
        if ($request->filled('npassword')) {
            $user->password = Hash::make($request->input('npassword')); // Hash password baru
        }

        $user->save();

        return redirect()->route('account-dash')->with('success', 'Profil berhasil diperbarui.');
    }


    public function aboutUs(){
        return view('frontend.pages.about-us');
    }

    public function contact(){
        $admin = User::where('role', 'admin')
        ->where('status', 'active')
        ->first();
        return view('frontend.pages.contact')->with('admin',$admin);
    }

    public function productDetail($slug){
        $admin = User::where('role', 'admin')
        ->where('status', 'active')
        ->first();
        $product_detail= Product::getProductBySlug($slug);
        // dd($product_detail);
        return view('frontend.pages.product_detail')->with('product_detail',$product_detail)->with('admin',$admin);
    }

    // Order
    public function orderIndex(){
        $orders=Order::orderBy('id','DESC')->where('user_id',auth()->user()->id)->paginate(10);
        return view('user.order.index')->with('orders',$orders);
    }

    public function productGrids(){
        $products=Product::query();
        
        if(!empty($_GET['category'])){
            $slug=explode(',',$_GET['category']);
            // dd($slug);
            $cat_ids=Category::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id',$cat_ids);
            // return $products;
        }
        
        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='title'){
                $products=$products->where('status','active')->orderBy('title','ASC');
            }
            if($_GET['sortBy']=='price'){
                $products=$products->orderBy('price','ASC');
            }
        }

        if(!empty($_GET['price'])){
            $price=explode('-',$_GET['price']);
            $products->whereBetween('price',$price);
        }

        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        // Sort by number
        if(!empty($_GET['show'])){
            $products=$products->where('status','active')->paginate($_GET['show']);
        }
        else{
            $products=$products->where('status','active')->paginate(9);
        }
        // Sort by name , price, category

      
        return view('frontend.pages.product-grids')->with('products',$products)->with('recent_products',$recent_products);
    }
    public function productLists(){
        $products=Product::query();
        
        if(!empty($_GET['category'])){
            $slug=explode(',',$_GET['category']);
            // dd($slug);
            $cat_ids=Category::select('id')->whereIn('slug',$slug)->pluck('id')->toArray();
            // dd($cat_ids);
            $products->whereIn('cat_id',$cat_ids)->paginate;
            // return $products;
        }
        
        if(!empty($_GET['sortBy'])){
            if($_GET['sortBy']=='title'){
                $products=$products->where('status','active')->orderBy('title','ASC');
            }
            if($_GET['sortBy']=='price'){
                $products=$products->orderBy('price','ASC');
            }
        }

        if(!empty($_GET['price'])){
            $price=explode('-',$_GET['price']);
            $products->whereBetween('price',$price);
        }

        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        // Sort by number
        if(!empty($_GET['show'])){
            $products=$products->where('status','active')->paginate($_GET['show']);
        }
        else{
            $products=$products->where('status','active')->paginate(6);
        }
        // Sort by name , price, category

      
        return view('frontend.pages.product-lists')->with('products',$products)->with('recent_products',$recent_products);
    }
    public function productFilter(Request $request){
            $data= $request->all();
            // return $data;
            $showURL="";
            if(!empty($data['show'])){
                $showURL .='&show='.$data['show'];
            }

            $sortByURL='';
            if(!empty($data['sortBy'])){
                $sortByURL .='&sortBy='.$data['sortBy'];
            }

            $catURL="";
            if(!empty($data['category'])){
                foreach($data['category'] as $category){
                    if(empty($catURL)){
                        $catURL .='&category='.$category;
                    }
                    else{
                        $catURL .=','.$category;
                    }
                }
            }

            

            $priceRangeURL="";
            if(!empty($data['price_range'])){
                $priceRangeURL .='&price='.$data['price_range'];
            }
            if(request()->is('e-shop.loc/product-grids')){
                return redirect()->route('product-grids',$catURL.$priceRangeURL.$showURL.$sortByURL);
            }
            else{
                return redirect()->route('product-lists',$catURL.$priceRangeURL.$showURL.$sortByURL);
            }
    }
    public function productSearch(Request $request){
        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $products=Product::orwhere('title','like','%'.$request->search.'%')
                    ->orwhere('slug','like','%'.$request->search.'%')
                    ->orwhere('description','like','%'.$request->search.'%')
                    ->orwhere('summary','like','%'.$request->search.'%')
                    ->orwhere('price','like','%'.$request->search.'%')
                    ->orderBy('id','DESC')
                    ->paginate('9');
        return view('frontend.pages.product-grids')->with('products',$products)->with('recent_products',$recent_products);
    }

    
    public function productCat(Request $request){
        $category = Category::with('products')->where('slug', $request->slug)->first();
        // Paginasi produk berdasarkan kategori
        $products = $category->products()->paginate(10);
    
        $recent_products = Product::where('status', 'active')->orderBy('id', 'DESC')->limit(3)->get();
    
        if(request()->is('e-shop.loc/product-grids')){
            return view('frontend.pages.product-grids', [
                'products' => $products, // Ambil produk dari paginasi
                'recent_products' => $recent_products
            ]);
        }
        else{
            return view('frontend.pages.product-lists', [
                'products' => $products, // Ambil produk dari paginasi
                'recent_products' => $recent_products
            ]);
        }
    }
    
    
    public function productSubCat(Request $request){
        // $products=Category::getProductBySubCat($request->sub_slug);

        $category = Category::with('sub_products')->where('slug', $request->sub_slug)->first();

        $products = $category->sub_products()->paginate(10);
        // return $products;
        $recent_products=Product::where('status','active')->orderBy('id','DESC')->limit(3)->get();

        if(request()->is('e-shop.loc/product-grids')){
            return view('frontend.pages.product-grids')->with(['products'=> $products, 'recent_products'=>$recent_products]);
        }
        else{
            return view('frontend.pages.product-lists')->with(['products'=> $products, 'recent_products'=>$recent_products]);
        }

    }

    public function blog(){
        $post=Post::query();
        

        if(!empty($_GET['show'])){
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate($_GET['show']);
        }
        else{
            $post=$post->where('status','active')->orderBy('id','DESC')->paginate(9);
        }
        // $post=Post::where('status','active')->paginate(8);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogDetail($slug){
        $post=Post::getPostBySlug($slug);
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        // return $post;
        return view('frontend.pages.blog-detail')->with('post',$post)->with('recent_posts',$rcnt_post);
    }

    public function blogSearch(Request $request){
        // return $request->all();
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        $posts=Post::orwhere('title','like','%'.$request->search.'%')
            ->orwhere('quote','like','%'.$request->search.'%')
            ->orwhere('summary','like','%'.$request->search.'%')
            ->orwhere('description','like','%'.$request->search.'%')
            ->orwhere('slug','like','%'.$request->search.'%')
            ->orderBy('id','DESC')
            ->paginate(8);
        return view('frontend.pages.blog')->with('posts',$posts)->with('recent_posts',$rcnt_post);
    }

    public function blogFilter(Request $request){
        $data=$request->all();
        // return $data;
        $catURL="";
        if(!empty($data['category'])){
            foreach($data['category'] as $category){
                if(empty($catURL)){
                    $catURL .='&category='.$category;
                }
                else{
                    $catURL .=','.$category;
                }
            }
        }

        $tagURL="";
        if(!empty($data['tag'])){
            foreach($data['tag'] as $tag){
                if(empty($tagURL)){
                    $tagURL .='&tag='.$tag;
                }
                else{
                    $tagURL .=','.$tag;
                }
            }
        }
        // return $tagURL;
            // return $catURL;
        return redirect()->route('blog',$catURL.$tagURL);
    }

    

    public function blogByTag(Request $request){
        // dd($request->slug);
        $post=Post::getBlogByTag($request->slug);
        // return $post;
        $rcnt_post=Post::where('status','active')->orderBy('id','DESC')->limit(3)->get();
        return view('frontend.pages.blog')->with('posts',$post)->with('recent_posts',$rcnt_post);
    }

    // Login
    public function login(){
        return view('frontend.pages.login');
    }
    public function loginSubmit(Request $request){
        $data= $request->all();
        if(Auth::attempt(['email' => $data['email'], 'password' => $data['password'],'status'=>'active'])){
            Session::put('user',$data['email']);
            request()->session()->flash('success','Login Berhasil!');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('error','Email dan kata sandi tidak valid, silakan coba lagi!');
            return redirect()->back();
        }
    }

    public function logout(){
        Session::forget('user');
        Auth::logout();
        request()->session()->flash('success','Logout Berhasil');
        return back();
    }

    public function register(){
        return view('frontend.pages.register');
    }
    public function registerSubmit(Request $request){
        // return $request->all();
        $this->validate($request,[
            'name'=>'string|required|min:2',
            'email'=>'string|required|unique:users,email',
            'no_hp'=>'string|required|regex:/^62[0-9]{8,15}$/',
            'password'=>'required|min:6|confirmed',
        ]);
        $data=$request->all();
        // dd($data);
        $check=$this->create($data);
        Session::put('user',$data['email']);
        if($check){
            request()->session()->flash('success','Register Berhasil!');
            return redirect()->route('home');
        }
        else{
            request()->session()->flash('error','Silakan coba lagi!');
            return back();
        }
    }
    public function create(array $data){
        return User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'no_hp'=>$data['no_hp'],
            'password'=>Hash::make($data['password']),
            'status'=>'active'
            ]);
    }
    // Reset password
    public function showResetForm(){
        return view('auth.passwords.old-reset');
    }

    
}
