<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CategoryPostController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PayPalController;

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

Route::group(['middleware' => 'checklogin'], function () {

    Route::group(['middleware' => 'admin'], function () {

        //Admin Dashboard
        Route::get('/dashboard', [AdminController::class, 'show_dashboard'])->name('dashboard');

        //User
        Route::get('/all-user', [AuthenController::class, 'getAllUser']);
        Route::post('/update-role-user', [AuthenController::class, 'updateRoleUser']);

        //CategoryProductController

        Route::get('/add-category-product', [CategoryProductController::class, 'add_category_product']);
        Route::get('/all-category-product', [CategoryProductController::class, 'all_category_product']);
        Route::get('/unactive-category-product/{categoryproduct_id}', [CategoryProductController::class, 'unactive_category_product']);
        Route::get('/active-category-product/{categoryproduct_id}', [CategoryProductController::class, 'active_category_product']);
        Route::get('/edit-category-product/{categoryproduct_id}', [CategoryProductController::class, 'edit_category_product']);
        Route::get('/delete-category-product/{categoryproduct_id}', [CategoryProductController::class, 'delete_category_product']);

        Route::post('/update-category-product/{categoryproduct_id}', [CategoryProductController::class, 'update_category_product']);
        Route::post('/save-category-product', [CategoryProductController::class, 'save_category_product']);

        //BrandController
        Route::get('/add-brand-product', [BrandController::class, 'add_brand_product']);
        Route::get('/all-brand-product', [BrandController::class, 'all_brand_product']);
        Route::get('/unactive-brand-product/{brand_id}', [BrandController::class, 'unactive_brand_product']);
        Route::get('/active-brand-product/{brand_id}', [BrandController::class, 'active_brand_product']);
        Route::get('/edit-brand-product/{brand_id}', [BrandController::class, 'edit_brand_product']);
        Route::get('/delete-brand-product/{brand_id}', [BrandController::class, 'delete_brand_product']);

        Route::post('/update-brand-product/{brand_id}', [BrandController::class, 'update_brand_product']);
        Route::post('/save-brand-product', [BrandController::class, 'save_brand_product']);

        //Danh muc bai viet
        Route::get('/add-post', [PostController::class, 'add_post']);
        Route::get('/all-post', [PostController::class, 'all_post']);
        Route::get('/edit-post/{post_id}', [PostController::class, 'edit_post']);
        Route::get('/delete-post/{post_id}', [PostController::class, 'delete_post']);
        Route::get('/bai-viet/{post_slug}', [PostController::class, 'bai_viet']);

        Route::post('/save-post', [PostController::class, 'save_post']);
        Route::post('/update-post/{cate_post_id}', [PostController::class, 'update_post']);

        //Category Post
        Route::get('/add-category-post', [CategoryPostController::class, 'add_category_post']);
        Route::get('/all-category-post', [CategoryPostController::class, 'all_category_post']);
        Route::get('/edit-category-post/{cate_post_id}', [CategoryPostController::class, 'edit_category_post']);
        Route::get('/delete-category-post/{cate_post_id}', [CategoryPostController::class, 'delete_category_post']);

        Route::post('/save-category-post', [CategoryPostController::class, 'save_category_post']);
        Route::post('/update-category-post/{cate_post_id}', [CategoryPostController::class, 'update_category_post']);


        //ProductController
        Route::get('/all-product', [ProductController::class, 'all_product']);
        Route::post('tab-new-product', [ProductController::class, 'tab_new_product']);

        Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
        Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);
        Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);

        Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);
        Route::post('/save-product', [ProductController::class, 'save_product']);
        Route::get('/add-product', [ProductController::class, 'add_product']);
        Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
    });
});

Route::get('/trang-chu', [HomeController::class, 'index']);

Route::get('/logout', [AuthenController::class, 'logout'])->name('logout');

Route::get('/login', [AuthenController::class, 'getFormLogin'])->name('login');
Route::post('/login', [AuthenController::class, 'login'])->name('auth.login');

Route::get('/register', [AuthenController::class, 'getFormRegister'])->name('auth.formregister');
Route::post('/register-auth', [AuthenController::class, 'register_auth'])->name('auth.register');


Route::post('/load-more-product', [HomeController::class, 'load_more_product']);
Route::post('/load-more-selling-product', [HomeController::class, 'load_more_selling_product']);
Route::get('/', [HomeController::class, 'index']);
Route::post('/tim-kiem', [HomeController::class, 'search']);
Route::post('/autocomplete-ajax', [HomeController::class, 'autocomplete_ajax']);

Route::post('/update-quick-cart', [HomeController::class, 'update_quick_cart']);
Route::get('/show-quick-cart', [HomeController::class, 'show_quick_cart']);

//blog
Route::get('/danh-muc-bai-viet/{post_slug}', [PostController::class, 'danh_muc_bai_viet']);
Route::get('/lien-he', [ContactController::class, 'lien_he']);
Route::get('/information', [ContactController::class, 'information']);
Route::post('/save-info', [ContactController::class, 'save_info']);
Route::post('/update-info/{info_id}', [ContactController::class, 'update_info']);


// //Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{category_id}', [CategoryProductController::class, 'show_category_home'])->name('category_products');
Route::get('/thuong-hieu-san-pham/{brand_id}', [BrandController::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}', [ProductController::class, 'details_product']);
// {{URL::to('chi-tiet-san-pham/'.$product->product_id)}}
Route::get('/tag/{product_tag}', [ProductController::class, 'tag']);

Route::get('/admin', [AdminController::class, 'index']);
// Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
//Route::get('/logout', [AdminController::class, 'logout']);

Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);



//Gallery

Route::get('/add-gallery/{product_id}', [GalleryController::class, 'add_gallery']);
Route::post('/select-gallery', [GalleryController::class, 'select_gallery']);
Route::post('/insert-gallery/{product_id}', [GalleryController::class, 'insert_gallery']);
Route::get('/update-gallery-name', [GalleryController::class, 'update_gallery_name']);
Route::get('/delete-gallery', [GalleryController::class, 'delete_gallery']);
Route::post('/update-gallery', [GalleryController::class, 'update_gallery']);




//Product

//Order
Route::get('/print-order/{order_code}', [OrderController::class, 'print_order']);
Route::get('/manage-order', [OrderController::class, 'manage_order']);
Route::get('/view-order/{order_code}', [OrderController::class, 'view_order']);
Route::post('/destroy-order', [OrderController::class, 'destroy_order']);
Route::post('/update-qty', [OrderController::class, 'update_qty']);

// Route::get('/manage-order',[CheckoutController::class, 'manage_order']);
// Route::get('/admin', 'AdminController@index');

Route::get('/trang-chu', [HomeController::class, 'index']);

//Coupon
Route::post('/check-coupon', [CouponController::class, 'check_coupon']);
Route::post('/insert-coupon-code', [CouponController::class, 'insert_coupon_code']);
Route::get('/insert-coupon', [CouponController::class, 'insert_coupon']);
Route::get('/list-coupon', [CouponController::class, 'list_coupon']);
Route::get('/delete-coupon/{coupon_id}', [CouponController::class, 'delete_coupon']);
Route::get('/unset-coupon', [CouponController::class, 'unset_coupon']);

//Login google
Route::get('/login-customer-google', [AdminController::class, 'login_customer_google']);
Route::get('/customer/google/callback', [AdminController::class, 'callback_customer_google']);


//cart
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);
Route::post('/update-cart-qty', [CartController::class, 'update_cart_qty']);
Route::post('/update-cart', [CartController::class, 'update_cart']);

Route::get('/delete-all-product', [CartController::class, 'delete_all_product']);
Route::get('/gio-hang', [CartController::class, 'gio_hang']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/del-product/{session_id}', [CartController::class, 'delete_product']);
Route::get('/show-cart-qty', [CartController::class, 'show_cart_qty']);
Route::get('/hover-cart', [CartController::class, 'hover_cart']);

//cart delete
Route::get('/detele-to-cart/{rowId}', [CartController::class, 'detele_to_cart']);


//Checkout

Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::get('/del-fee', [CheckoutController::class, 'del_fee']);

Route::post('/calculate-fee', [CheckoutController::class, 'calculate_fee']);
Route::post('/order-place', [CheckoutController::class, 'order_place']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);

Route::post('/save-checkout-customer', [CheckoutController::class, 'save_checkout_customer']);
Route::post('/select-delivery-home', [CheckoutController::class, 'select_delivery_home']);
Route::post('/confirm-order', [CheckoutController::class, 'confirm_order']);

Route::get('/confirm-order', [CheckoutController::class, 'confirm_order']);


//Login customer by GOOGLE
Route::get('/login-customer-google', [AdminController::class, 'login_customer_google']);
Route::get('/customer/google/callback', [AdminController::class, 'callback_customer_google']);


//send mail
Route::get('/send-mail', [HomeController::class, 'send_mail']);

//Delivery
Route::get('/delivery', [DeliveryController::class, 'delivery']);
Route::post('/select-delivery', [DeliveryController::class, 'select_delivery']);
Route::post('/insert-delivery', [DeliveryController::class, 'insert_delivery']);
Route::post('/select-feeship', [DeliveryController::class, 'select_feeship']);
Route::post('/update-delivery', [DeliveryController::class, 'update_delivery']);

//Banner
Route::get('/manage-banner', [BannerController::class, 'manage_banner']);
Route::get('/add-banner', [BannerController::class, 'add_banner']);
Route::post('/insert-slider', [BannerController::class, 'insert_slider']);
Route::get('/unactive-slide/{slider_id}', [BannerController::class, 'unactive_slide']);
Route::get('/active-slide/{slider_id}', [BannerController::class, 'active_slide']);

//Authentication roles

// Route::get('/login-auth', [AuthController::class, 'login_auth']);

// Route::get('/register-auth', [AuthController::class, 'register_auth']);
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);



//load comment
Route::post('/load-comment', [ProductController::class, 'load_comment']);
Route::post('/send-comment', [ProductController::class, 'send_comment']);

// admin comment
Route::get('/comment', [ProductController::class, 'list_comment']);
Route::post('/allow-comment', [ProductController::class, 'allow_comment']);
Route::post('/reply-comment', [ProductController::class, 'reply_comment']);

//rating
Route::post('/rating', [ProductController::class, 'rating']);

Route::post('/filter-by-date', [AdminController::class, 'filter_by_date']);
Route::post('/dashboard-filter', [AdminController::class, 'dashboard_filter']);

Route::post('/day-order', [AdminController::class, 'day_order']);

//send mail
Route::get('/send-example', [MailController::class, 'send_example']);
Route::get('/send-coupon/{coupon_code}', [MailController::class, 'send_coupon']);
// Route::get('/send-coupon/{coupon_time}/{coupon_condition}/{coupon_number}/{coupon_name}/{coupon_code}',[MailController::class, 'send_coupon']);

Route::get('/mail-order', [MailController::class, 'mail_order']);

///history-order
Route::get('/history-order', [OrderController::class, 'history_order']);
Route::get('/view-history-order/{order_code}', [OrderController::class, 'view_history_order']);

//PayPal
Route::get('create-transaction', [PayPalController::class, 'createTransaction'])->name('createTransaction');
Route::get('process-transaction', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('success-transaction', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('cancel-transaction', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');

//Payment online
Route::post('/vnpay_payment', [CheckoutController::class, 'vnpay_payment']);
Route::post('/momo_payment', [CheckoutController::class, 'momo_payment']);

Route::get('/test', [HomeController::class, 'test']);
