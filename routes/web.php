<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchContrller;
use App\Http\Controllers\SellerDashboard;
use App\Http\Controllers\SellerDashboardLogin;
use App\Http\Controllers\SellerDashboardProducts;
use App\Http\Controllers\SellerDashboardProfile;
use App\Http\Controllers\SellerDashboardCategories;
use App\Http\Controllers\SellerDashboardDiscounts;
use App\Http\Controllers\SellerDashboardNewsletters;
use App\Http\Controllers\SellerDashboardOrders;
use App\Http\Controllers\SellerDashboardStock;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('home');
});

Auth::routes();

Route::post('/register', [RegisterController::class, 'register']);


Route::post('/register-district', [CommonController::class, 'getDistricts']);

Route::post('/register-cities', [CommonController::class, 'getCities']);


Route::get('/customer-care', function () {
    return view('customer_care');
})->name('customer-care');

Route::get('/search', function () {
    return view('search');
})->name('search');

Route::get('/c', function () {
    return view('categories');
});

Route::get('/sc', function () {
    return view('sub-categories');
});

Route::get('/store', function () {
    return view('store-home');
});
Route::get('/p', function () {
    return view('products');
});


Route::get('/seller/dashboard', [SellerDashboard::class, 'index'])->name('seller.dashboard');


Route::get('/seller/dashboard/profile', [SellerDashboardProfile::class, 'sellerProfile'])->name('seller.profile');
Route::post('/seller/dashboard/profile/change-profile-image', [SellerDashboardProfile::class, 'sellerProfileChange']);
Route::post('/seller/dashboard/profile/change-store-image', [SellerDashboardProfile::class, 'sellerStoreChange']);
Route::post('/seller/dashboard/profile/change-hotline', [SellerDashboardProfile::class, 'sellerHotlineChange']);
Route::post('/seller/dashboard/profile/change-delivery-districts', [SellerDashboardProfile::class, 'sellerDDChange'])->name('[seller.editDistrict');

Route::get('/seller/dashboard/products', [SellerDashboardProducts::class, 'manageProducts'])->name('product.list');
Route::post('/seller/dashboard/product-edit', [SellerDashboardProducts::class, 'updateProduct'])->name('product.update');
Route::post('/seller/dashboard/product-details', [SellerDashboardProducts::class, 'productDetails'])->name('product.details');
Route::post('/seller/dashboard/products-delete', [SellerDashboardProducts::class, 'deleteProduct'])->name('product.destroy');
Route::post('/seller/dashboard/products-add-new', [SellerDashboardProducts::class, 'addNewProduct'])->name('product.add');

Route::get('/seller/dashboard/categories', [SellerDashboardCategories::class, 'manageCategories'])->name('category.list');
Route::post('/seller/dashboard/categories-add-new', [SellerDashboardCategories::class, 'addNewCategory'])->name('categories.add');
Route::post('/seller/dashboard/categories-delete', [SellerDashboardCategories::class, 'deleteCategory'])->name('categories.destroy');
Route::post('/seller/dashboard/categories-details', [SellerDashboardCategories::class, 'categoryDetails'])->name('categories.details');
Route::post('/seller/dashboard/categories-update', [SellerDashboardCategories::class, 'updateCategory'])->name('categories.update');

Route::get('/seller/dashboard/stock', [SellerDashboardStock::class, 'manageStock'])->name('stock.list');
Route::post('/seller/dashboard/stock-add-new', [SellerDashboardStock::class, 'addNewStock'])->name('stock.add');
Route::post('/seller/dashboard/stock-delete', [SellerDashboardStock::class, 'deleteStock'])->name('stock.destroy');
Route::post('/seller/dashboard/change-stock-status', [SellerDashboardStock::class, 'changeStockStatus'])->name('stock.change');

Route::post('/seller/dashboard/clear-session', [SellerDashboard::class, 'clearSession']);
Route::post('/seller/dashboard/change-sidebar-status', [SellerDashboard::class, 'changeSideBarStatus']);


Route::get('/seller/dashboard/orders', [SellerDashboardOrders::class, 'index'])->name('orders.list');

Route::get('/seller/dashboard/newsletters', [SellerDashboardNewsletters::class, 'index'])->name('newsletter.requests');

Route::get('/seller/dashboard/discounts', [SellerDashboardDiscounts::class, 'index'])->name('discounts.list');


Route::get('/seller/login', function () {
    return view('seller.dashboard_login');
});


Route::post('/seller/login',  [SellerDashboardLogin::class, 'login'])->name('seller.login');


Route::get('/seller/logout', function () {
    Session::flush();
    return redirect('/seller/login');
});
