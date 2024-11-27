<?php

use App\Services\RajaOngkirService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ShippingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['register'=>false]);

Route::get('user/login','FrontendController@login')->name('login.form');
Route::post('user/login','FrontendController@loginSubmit')->name('login.submit');
Route::get('user/logout','FrontendController@logout')->name('user.logout');

Route::get('user/register','FrontendController@register')->name('register.form');
Route::post('user/register','FrontendController@registerSubmit')->name('register.submit');
// Reset password
Route::post('password-reset', 'FrontendController@showResetForm')->name('password.reset'); 
// Socialite 
Route::get('login/{provider}/', 'Auth\LoginController@redirect')->name('login.redirect');
Route::get('login/{provider}/callback/', 'Auth\LoginController@Callback')->name('login.callback');

Route::get('/','FrontendController@home')->name('home');

// Frontend Routes
Route::get('/home', 'FrontendController@index');
Route::get('/account','FrontendController@account')->name('account');
Route::get('/account-dash','FrontendController@accountdashboard')->name('account-dash')->middleware('user');
Route::get('/account-order','FrontendController@accountorder')->name('frontend.pages.account.order')->middleware('user');
Route::get('/account-order/show/{id}','FrontendController@orderShow')->name('frontend.pages.account.detailorder')->middleware('user');
Route::get('/account-address','FrontendController@accountaddress')->name('account-address')->middleware('user');
Route::get('/account-myaccount','FrontendController@accountdetail')->name('account-my')->middleware('user');
Route::put('/account-update', 'FrontendController@accountUpdate')->name('account.update');
Route::get('/about-us','FrontendController@aboutUs')->name('about-us');
Route::get('/contact','FrontendController@contact')->name('contact');
Route::post('/contact/message','MessageController@store')->name('contact.store');
Route::get('product-detail/{slug}','FrontendController@productDetail')->name('product-detail');
Route::post('/product/search','FrontendController@productSearch')->name('product.search');
Route::get('/product-cat/{slug}','FrontendController@productCat')->name('product-cat');
Route::get('/product-sub-cat/{slug}/{sub_slug}','FrontendController@productSubCat')->name('product-sub-cat');
Route::get('/product-brand/{slug}','FrontendController@productBrand')->name('product-brand');
// Cart section
Route::get('/add-to-cart/{slug}','CartController@addToCart')->name('add-to-cart')->middleware('user');
Route::post('/add-to-cart','CartController@singleAddToCart')->name('single-add-to-cart')->middleware('user');
Route::get('cart-delete/{id}','CartController@cartDelete')->name('cart-delete');
Route::post('cart-update','CartController@cartUpdate')->name('cart.update');

Route::get('/cart',function(){
    return view('frontend.pages.cart');
})->name('cart');
Route::get('/checkout','AddressController@showAddressForm')->name('checkout')->middleware('user');
// Route::get('/checkout','CartController@checkout')->name('checkout')->middleware('user');

Route::post('cart/order','OrderController@store')->name('cart.order');
Route::get('order/pdf/{id}','OrderController@pdf')->name('order.pdf');
Route::get('/income','OrderController@incomeChart')->name('product.order.income');
// Route::get('/user/chart','AdminController@userPieChart')->name('user.piechart');
Route::get('order/invoice/{id}','FrontendController@invoice')->name('order.invoice');
Route::get('/product-grids','FrontendController@productGrids')->name('product-grids');
Route::get('/product-lists','FrontendController@productLists')->name('product-lists');
Route::match(['get','post'],'/filter','FrontendController@productFilter')->name('shop.filter');

// Blog
Route::get('/blog','FrontendController@blog')->name('blog');
Route::get('/blog-detail/{slug}','FrontendController@blogDetail')->name('blog.detail');
Route::get('/blog/search','FrontendController@blogSearch')->name('blog.search');
Route::post('/blog/filter','FrontendController@blogFilter')->name('blog.filter');
Route::get('blog-cat/{slug}','FrontendController@blogByCategory')->name('blog.category');
Route::get('blog-tag/{slug}','FrontendController@blogByTag')->name('blog.tag');

// Address
Route::resource('/address','AddressController');
Route::post('/address/{id}',[AddressController::class, 'setDefaultAddress'])->name('set-default');
Route::post('/address-store', [AddressController::class, 'store'])->name('address.store');
Route::get('/get-address/{id}', [AddressController::class, 'edit'])->name('address.get');
Route::delete('/del-address/{id}', [AddressController::class, 'destroy'])->name('address.delete');

Route::get('/get/shipping', [ShippingController::class, 'getShippingOptions']);

Route::get('/provinces', [RajaOngkirService::class, 'getProvinces']);
Route::get('/cities/{provinceId}', [RajaOngkirService::class, 'getCities']);
Route::post('/calculate-shipping-cost', [RajaOngkirService::class, 'getShippingCost']);
Route::get('/get-cities/{provinceId}', [CartController::class, 'getCities'])->name('get.cities');
Route::post('/calculate-shipping-cost', [CartController::class, 'calculateShippingCost']);

// Route::post('/addres/add', 'AddressController@store')->name('address.add');
// // Route untuk menampilkan form edit alamat
// Route::get('/addresses/{id}/edit', 'AddressController@')->name('address.edit');

// // Route untuk memperbarui alamat
// Route::put('/addresses/{id}', 'AddressController@')->name('address.update');

// // Route untuk menghapus alamat
// Route::delete('/addresses/{id}', 'AddressController@')->name('address.destroy');



// Payment
Route::post('/midtrans/token', 'PaymentController@generateToken')->name('midtrans.token');

//order
Route::get('/order',"FrontendController@orderIndex")->name('account.order.index');
Route::post('/buy-again/{order}', 'OrderController@buyAgain')->name('buy.again');
Route::put('/order/{orderId}/update', 'OrderController@updateOrder')->name('order.updatestatus');

//Cancelation
Route::post('/cancel', 'CancellationController@store')->name('cancel.order');

// Backend section start

Route::group(['prefix'=>'/admin','middleware'=>['auth','admin']],function(){
    Route::get('/','AdminController@index')->name('admin');
    Route::get('/file-manager',function(){
        return view('backend.layouts.file-manager');
    })->name('file-manager');
    // user route
    Route::resource('users','UsersController');
    // Banner
    Route::resource('banner','BannerController');
    // Profile
    Route::get('/profile','AdminController@profile')->name('admin-profile');
    Route::post('/profile/{id}','AdminController@profileUpdate')->name('profile-update');
    // Category
    Route::resource('/category','CategoryController');
    Route::get('/category-data', 'CategoryController@getCategories')->name('category.data');

    // Product
    Route::resource('/product','ProductController');
    // Ajax for sub category
    Route::post('/category/{id}/child','CategoryController@getChildByParent');
   
    // Post
    Route::resource('/post','PostController');
    
    // Order
    Route::resource('/order','OrderController');
    Route::put('/order/{orderId}/update-status', 'OrderController@updateStatus')->name('order.update.status');
    Route::put('/order/{orderId}/update', 'CancellationController@updateStatus')->name('order.cancel.update');



    // Shipping
    Route::resource('/shipping','ShippingController');
    Route::post('/shipping/{id}','ShippingController@update')->name('shipping-update');
    
    // Settings
    Route::get('settings','AdminController@settings')->name('settings');
    Route::post('setting/update','AdminController@settingsUpdate')->name('settings.update');

    // Notification
    Route::get('/notification/{id}','NotificationController@show')->name('admin.notification');
    Route::get('/notifications','NotificationController@index')->name('all.notification');
    Route::delete('/notification/{id}','NotificationController@delete')->name('notification.delete');
    // Password Change
    Route::get('change-password', 'AdminController@changePassword')->name('change.password.form');
    Route::post('change-password', 'AdminController@changPasswordStore')->name('change.password');
});










// User section start
Route::group(['prefix'=>'/user','middleware'=>['user']],function(){
    Route::get('/','HomeController@index')->name('user');
     // Profile
     Route::get('/profile','HomeController@profile')->name('user-profile');
     Route::post('/profile/{id}','HomeController@profileUpdate')->name('user-profile-update');
    //  Order
    Route::get('/order',"HomeController@orderIndex")->name('user.order.index');
    Route::get('/order/show/{id}',"HomeController@orderShow")->name('user.order.show');
    Route::delete('/order/delete/{id}','HomeController@userOrderDelete')->name('user.order.delete');
    
    // Password Change
    Route::get('change-password', 'HomeController@changePassword')->name('user.change.password.form');
    Route::post('change-password', 'HomeController@changPasswordStore')->name('change.password');

});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});