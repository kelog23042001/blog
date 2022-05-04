<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeController;


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
Route::get('/', [HomeController::class, 'index']);
Route::post('/tim-kiem', [HomeController::class, 'search']);

// //Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{category_id}',[CategoryProductController::class, 'show_category_home']);
Route::get('/thuong-hieu-san-pham/{brand_id}',[BrandController::class, 'show_brand_home']);
Route::get('/chi-tiet-san-pham/{product_id}',[ProductController::class, 'details_product']);

Route::get('/admin',[AdminController::class, 'index']);
Route::get('/dashboard',[AdminController::class, 'show_dashboard']);
Route::get('/logout',[AdminController::class, 'logout']);

Route::post('/admin-dashboard',[AdminController::class, 'dashboard']);

//CategoryProductController
Route::get('/add-category-product',[CategoryProductController::class, 'add_category_product']);
Route::get('/all-category-product',[CategoryProductController::class, 'all_category_product']);
Route::get('/unactive-category-product/{categoryproduct_id}',[CategoryProductController::class, 'unactive_category_product']);
Route::get('/active-category-product/{categoryproduct_id}',[CategoryProductController::class, 'active_category_product']);
Route::get('/edit-category-product/{categoryproduct_id}',[CategoryProductController::class, 'edit_category_product']);
Route::get('/delete-category-product/{categoryproduct_id}',[CategoryProductController::class, 'delete_category_product']);

Route::post('/update-category-product/{categoryproduct_id}',[CategoryProductController::class, 'update_category_product']);
Route::post('/save-category-product',[CategoryProductController::class, 'save_category_product']);

//BrandController
Route::get('/add-brand-product',[BrandController::class, 'add_brand_product']);
Route::get('/all-brand-product',[BrandController::class, 'all_brand_product']);
Route::get('/unactive-brand-product/{brand_id}',[BrandController::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_id}',[BrandController::class, 'active_brand_product']);
Route::get('/edit-brand-product/{brand_id}',[BrandController::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_id}',[BrandController::class, 'delete_brand_product']);

Route::post('/update-brand-product/{brand_id}',[BrandController::class, 'update_brand_product']);
Route::post('/save-brand-product',[BrandController::class, 'save_brand_product']);

//ColoreController
Route::get('/add-color-product',[ColorController::class, 'add_color_product']);
Route::get('/all-color-product',[ColorController::class, 'all_color_product']);
Route::get('/unactive-color-product/{color_id}',[ColorController::class, 'unactive_color_product']);
Route::get('/active-color-product/{color_id}',[ColorController::class, 'active_color_product']);
Route::get('/edit-color-product/{color_id}',[ColorController::class, 'edit_color_product']);
Route::get('/delete-color-product/{color_id}',[ColorController::class, 'delete_color_product']);

Route::post('/update-color-product/{color_id}',[ColorController::class, 'update_color_product']);
Route::post('/save-color-product',[ColorController::class, 'save_color_product']);

//SizeController
Route::get('/add-size-product',[SizeController::class, 'add_size_product']);
Route::get('/all-size-product',[SizeController::class, 'all_size_product']);
Route::get('/unactive-size-product/{color_id}',[SizeController::class, 'unactive_size_product']);
Route::get('/active-size-product/{color_id}',[SizeController::class, 'active_size_product']);
Route::get('/edit-size-product/{color_id}',[SizeController::class, 'edit_size_product']);
Route::get('/delete-size-product/{color_id}',[SizeController::class, 'delete_color_product']);

Route::post('/update-size-product/{color_id}',[SizeController::class, 'update_size_product']);
Route::post('/save-size-product',[SizeController::class, 'save_size_product']);

//ProductController
Route::get('/add-product',[ProductController::class, 'add_product']);
Route::get('/all-product',[ProductController::class, 'all_product']);
Route::get('/unactive-product/{product_id}',[ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}',[ProductController::class, 'active_product']);
Route::get('/edit-product/{product_id}',[ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}',[ProductController::class, 'delete_product']);

Route::post('/update-product/{product_id}',[ProductController::class, 'update_product']);
Route::post('/save-product',[ProductController::class, 'save_product']);

//Order
Route::get('/manage-order',[CheckoutController::class, 'manage_order']);

// Route::get('/admin', 'AdminController@index');

Route::get('/trang-chu', [HomeController::class, 'index']);

//cart
Route::post('/save-cart',[CartController::class, 'save_cart']);
Route::get('/show_cart',[CartController::class, 'show_cart']);
//cart delete
Route::get('/detele-to-cart/{rowId}',[CartController::class, 'detele_to_cart']);
//cart update quantity
Route::post('/update-cart-qty',[CartController::class, 'update_cart_qty']);

//Checkout
Route::get('/login-checkout',[CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout',[CheckoutController::class, 'logout_checkout']);
Route::get('/checkout',[CheckoutController::class, 'checkout']);
Route::get('/payment',[CheckoutController::class, 'payment']);

Route::post('/order-place',[CheckoutController::class, 'order_place']);
Route::post('/add-customer',[CheckoutController::class, 'add_customer']);
Route::post('/login-customer',[CheckoutController::class, 'login_customer']);
Route::post('/save-checkout-customer',[CheckoutController::class, 'save_checkout_customer']);

