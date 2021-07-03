<?php

use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\AdminDashboardAdmins;
use App\Http\Controllers\AdminDashboardCustomers;
use App\Http\Controllers\AdminDashboardLogin;
use App\Http\Controllers\AdminDashboardProducts;
use App\Http\Controllers\AdminDashboardProfile;
use App\Http\Controllers\AdminDashboardSellers;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ResetPasswordController;
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
use App\Http\Controllers\SellerRegister;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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


//  =========================== Customer ===========================

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::post('/register-cities', [CommonController::class, 'getCities']);
Route::post('/register-district', [CommonController::class, 'getDistricts']);
Route::post('/register-provinces', [CommonController::class, 'getProvinces']);
Route::post('/register-district-bid', [CommonController::class, 'getDistrictsbyID']);

Route::post('/register', [RegisterController::class, 'register']);
Route::get('/verify', [RegisterController::class, 'verifyCustomer']);
Route::post('/register/verification-resend', [RegisterController::class, 'resendVerification'])->name('verification.resend');

Route::post('/forget-password', [ForgotPasswordController::class, 'postEmail'])->name('reset.password');
Route::get('/password-reset', [ResetPasswordController::class, 'getPassword']);
Route::post('/password-reset', [ResetPasswordController::class, 'updatePassword'])->name('update.password');

Route::get('/seller/register', [SellerRegister::class, 'index'])->name('seller.register');
Route::post('/seller/registration', [RegisterController::class, 'sellerRegister'])->name('register.seller');
Route::post('/seller/verification', [RegisterController::class, 'sellerVerify'])->name('verify.seller');
Route::post('/seller/details-submit', [RegisterController::class, 'sellerSubmit'])->name('submit.seller');


Route::get('/category/{category}', [CategoryController::class, 'index']);
Route::post('/customer-location-change', [CommonController::class, 'changeCustomerLocation']);
Route::get('/customer-search-products', [SearchContrller::class, 'searchAutocomplete']);

// Route::post('/customer-product-categories', [CommonController::class, 'getCategories']);

// Route::get('autocomplete', [CommonController::class, 'searchAutocomplete'])->name('customer.search');



Auth::routes();







Route::get('/customer-care', [EnquiryController::class, 'index'])->name('customer-care');
Route::post('/customer-care', [EnquiryController::class, 'sendEnquiry'])->name('send-enquiry');

Route::post('/newsletter-add', [NewsletterController::class, 'addNewsletter'])->name('add.newsletter');

Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
});





Route::get('/search', function () {
    return view('search');
})->name('search');

Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/sc', function () {
    return view('sub-categories');
});

Route::get('/store', function () {
    return view('store-home');
});

Route::get('/p', function () {
    return view('products');
});

Route::get('/a', function () {
    return view('auth.login_register');
});

Route::get('/about', function () {
    return view('about');
})->name('about');



//  =========================== SELLER ===========================



Route::get('/seller/dashboard', [SellerDashboard::class, 'index'])->name('seller.dashboard');

Route::get('/seller/dashboard/profile', [SellerDashboardProfile::class, 'sellerProfile'])->name('seller.profile');
// Route::post('/seller/dashboard/profile/change-profile-image', [SellerDashboardProfile::class, 'sellerProfileChange']);
Route::post('/seller/dashboard/profile/change-store-image', [SellerDashboardProfile::class, 'sellerStoreChange']);
Route::post('/seller/dashboard/profile/change-hotline', [SellerDashboardProfile::class, 'sellerHotlineChange']);
Route::post('/seller/dashboard/profile/change-bday', [SellerDashboardProfile::class, 'sellerBdayChange'])->name('seller.bdayChange');
Route::post('/seller/dashboard/profile/change-delivery-districts', [SellerDashboardProfile::class, 'sellerDDChange'])->name('seller.editDistrict');
Route::post('/seller/dashboard/profile/change-password', [SellerDashboardProfile::class, 'sellerPasswordChange'])->name('seller.changePassword');

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
Route::post('/seller/dashboard/stock-data', [SellerDashboardStock::class, 'stockData'])->name('stock.data');
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





//  =========================== ADMIN ===========================


Route::get('/admin/login', function () {
    return view('admin.dashboard_login');
});

Route::post('/admin/login',  [AdminDashboardLogin::class, 'login'])->name('admin.login');
Route::post('/admin/verification-resend', [AdminDashboardAdmins::class, 'resendVerification'])->name('admin.verification_resend');

Route::get('/admin/logout', function () {
    Session::flush();
    return redirect('/admin/login');
});

Route::get('/admin/dashboard', [AdminDashboard::class, 'index'])->name('admin.dashboard');

Route::get('/admin/dashboard/profile', [AdminDashboardProfile::class, 'adminProfile'])->name('admin.profile');
Route::post('/admin/dashboard/profile/change-profile-image', [AdminDashboardProfile::class, 'adminProfileChange']);

Route::get('/admin/dashboard/admins',  [AdminDashboardAdmins::class, 'index'])->name('admin.list');

Route::post('/admin/dashboard/change-sidebar-status', [AdminDashboard::class, 'changeSideBarStatus']);

Route::post('/admin/dashboard/clear-session', [AdminDashboard::class, 'clearSession']);

/* Route::get('/admin/dashboard/admins', [AdminDashboardAdmins::class, 'adminAdmins'])->name('admin.admins'); */
Route::get('/admin/dashboard/sellers', [AdminDashboardSellers::class, 'adminSellers'])->name('admin.sellers');
Route::get('/admin/dashboard/products', [AdminDashboardProducts::class, 'adminProducts'])->name('admin.products');
Route::get('/admin/dashboard/customers', [AdminDashboardCustomers::class, 'adminCustomers'])->name('admin.customers');
