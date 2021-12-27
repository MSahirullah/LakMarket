<?php

use App\Http\Controllers\AccountController;
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
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeDealsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ReviewController;
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
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SubCategoryController;
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
Route::get('/flash-deals', [HomeDealsController::class, 'flashDeals'])->name('flash.deals');
Route::post('/flash-deals/filter/', [HomeDealsController::class, 'flashDealsFiler']);

Route::get('/top-rated-products', [HomeDealsController::class, 'topRatedProductsF'])->name('topRated.products');
Route::post('/top-rated-products/filter/', [HomeDealsController::class, 'topRatedProductsFfileter']);

Route::get('/top-rated-shops', [HomeDealsController::class, 'topRatedShop'])->name('topRated.shops');
Route::post('/top-rated-shops/filter/', [HomeDealsController::class, 'topRatedShopFileter']);

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

Route::get('/store/register', [SellerRegister::class, 'index'])->name('store.register');
Route::post('/store/registration', [RegisterController::class, 'sellerRegister'])->name('store.registerProcess');
Route::post('/store/verification', [RegisterController::class, 'sellerVerify'])->name('store.verify');
Route::post('/store/details-submit', [RegisterController::class, 'sellerSubmit'])->name('store.submitDetails');

Route::get('/store/{name}/', [StoreController::class, 'index'])->name('store.index');
Route::post('/store/product/filter/', [StoreController::class, 'storeProductFilter']);
Route::get('/store/{store}/category/{category}/', [StoreController::class, 'storeCategoryProducts'])->name('store.category');
Route::get('/store/{store}/search/', [StoreController::class, 'storeSearchProducts'])->name('store.search');

Route::get('/category/{category}', [CategoryController::class, 'index']);
Route::post('/category/filter/', [CategoryController::class, 'shopCategoryFilter']);
Route::get('/category/{category}/{subCategory}', [SubCategoryController::class, 'index']);

Route::post('/customer-location-change', [CommonController::class, 'changeCustomerLocation']);
Route::get('/customer-search-products', [SearchContrller::class, 'searchAutocomplete']);

Route::get('/search', [SearchContrller::class, 'search'])->name('search');
Route::post('/search/filter/sort-by', [SearchContrller::class, 'searchFilterSort']);
Route::post('/search/filter/', [SearchContrller::class, 'searchFilter']);

Route::get('/product/{pURL}', [ProductController::class, 'index']);
Route::post('/product/color/stock', [ProductController::class, 'changeStock']);

Route::get('/customer-care', [EnquiryController::class, 'index'])->name('customer-care');
Route::post('/customer-care', [EnquiryController::class, 'sendEnquiry'])->name('send-enquiry');

Route::post('/newsletter-add', [NewsletterController::class, 'addNewsletter'])->name('add.newsletter');

Auth::routes();

Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::post('/customer-location-reset', [CommonController::class, 'locationReset']);
    Route::post('/customer/account/shipping-address/add', [AccountController::class, 'addAddress']);
    Route::post('/customer/account/shipping-address/edit', [AccountController::class, 'editAddress']);
    Route::post('/customer/account/shipping-address/remove', [AccountController::class, 'removeAddress']);

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/customer/myaccount/{valueCustomer}', [OrderController::class, 'index'])->name('myaccount.index');

    Route::get('/shoppingCart', [CartController::class, 'index'])->name('cart');
    Route::post('/shoppingCart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/shoppingCart/status', [CartController::class, 'cartStatus'])->name('cart.status');
    Route::post('/shoppingCart/update', [CartController::class, 'cartUpdate'])->name('cart.update');
    Route::post('/shoppingCart/total', [CartController::class, 'cartPriceUpdate'])->name('cart.update');
    Route::post('/shoppingCart/remove/product', [CartController::class, 'cartRemoveProduct'])->name('cart.removeProduct');
    Route::post('/shoppingCart/remove/all', [CartController::class, 'cartRemoveAllProduct'])->name('cart.removeAllProduct');
    Route::post('/shoppingCart/move/wishlist', [CartController::class, 'cartMoveToWishlist'])->name('cart.moveToWishlist');
    Route::post('/shoppingCart/customer', [CartController::class, 'cartCustomer'])->name('cart.customer');

    Route::get('/checkout/notify', [CheckoutController::class, 'checkoutNotify'])->name('checkout.notify');
    Route::get('/checkout/success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');
    Route::get('/checkout/cancelled', [CheckoutController::class, 'checkoutCancelled'])->name('checkout.cancelled');

    Route::post('/order/add', [OrderController::class, 'addToOrder'])->name('order.add');

    Route::post('/report/review', [ReviewController::class, 'reportReview'])->name('report.review');
    Route::get('/report', function () {
        return view('auth.login');
    });
    Route::post('/review/helpful', [ReviewController::class, 'reviewHelpful']);

    Route::post('/follow/store', [StoreController::class, 'followStore'])->name('follow.store');
    Route::get('/follow', function () {
        return view('auth.login');
    });
});

Route::get('/about', function () {
    return view('about');
})->name('about');

//  =========================== SELLER ===========================



Route::get('/seller/dashboard', [SellerDashboard::class, 'index'])->name('seller.dashboard');
Route::get('/seller/dashboard/contact-us', [SellerDashboard::class, 'contactUs'])->name('seller.contact');

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
})->name('seller.loginV');


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
})->name('admin.loginV');

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
/* Route::get('/admin/dashboard/sellers', [AdminDashboardSellers::class, 'adminSellers'])->name('admin.sellers'); */
Route::get('/admin/dashboard/products', [AdminDashboardProducts::class, 'adminProducts'])->name('admin.products');
Route::get('/admin/dashboard/customers', [AdminDashboardCustomers::class, 'adminCustomers'])->name('admin.customers');

Route::post('/admin/dashboard/admins/admin-add-new', [AdminDashboardAdmins::class, 'addNewAdmin'])->name('admin.add');
Route::post('/admin/dashboard/admins-delete', [AdminDashboardAdmins::class, 'deleteAdmin'])->name('admin.destroy');
Route::post('/admin/dashboard/admins-blacklist', [AdminDashboardAdmins::class, 'blacklistAdmin'])->name('admin.blacklist');
Route::post('/admin/dashboard/admins-add-new', [AdminDashboardAdmins::class, 'viewDeletedAdmins'])->name('admin.view_deleted');

Route::post('/admin/dashboard/profile/change-linkedin-link', [AdminDashboardProfile::class, 'adminLLChange'])->name('admin.editLinkedIn');
Route::post('/admin/dashboard/admin-details', [AdminDashboardAdmins::class, 'adminDetails'])->name('admin.details');
Route::post('/admin/dashboard/update/admin-details', [AdminDashboardAdmins::class, 'updateAdminDetails'])->name('admin.update');
Route::post('/admin/dashboard/admins/admin-password-reset', [AdminDashboardAdmins::class, 'changePassword'])->name('admin.passchange');

Route::get('/admin/dashboard/sellers',  [AdminDashboardSellers::class, 'index'])->name('admin.sellers');
Route::post('/admin/dashboard/sellers-details', [AdminDashboardSellers::class, 'sellerDetails'])->name('seller.details');
Route::post('/admin/dashboard/update/sellers-details', [AdminDashboardSellers::class, 'updateSellerDetails'])->name('seller.update');
Route::post('/admin/dashboard/sellers-delete', [AdminDashboardSellers::class, 'deleteSeller'])->name('seller.destroy');
Route::post('/admin/dashboard/sellers-blacklist', [AdminDashboardSellers::class, 'blacklistSeller'])->name('seller.blacklist');

Route::get('/admin/dashboard/products',  [AdminDashboardProducts::class, 'index'])->name('admin.products');
Route::post('/admin/dashboard/products-details', [AdminDashboardProducts::class, 'productDetails'])->name('product.details');
Route::post('/admin/dashboard/update/products-details', [AdminDashboardProducts::class, 'updateProductDetails'])->name('product.update');
Route::post('/admin/dashboard/products-delete', [AdminDashboardProducts::class, 'deleteProduct'])->name('product.destroy');

Route::get('/admin/dashboard/customers',  [AdminDashboardCustomers::class, 'index'])->name('admin.customers');
Route::post('/admin/dashboard/customers-details', [AdminDashboardCustomers::class, 'customerDetails'])->name('customer.details');
Route::post('/admin/dashboard/update/customers-details', [AdminDashboardCustomers::class, 'updateCustomerDetails'])->name('customer.update');
Route::post('/admin/dashboard/customers-delete', [AdminDashboardCustomers::class, 'deleteCustomer'])->name('customer.destroy');
Route::post('/admin/dashboard/customers-blacklist', [AdminDashboardCustomers::class, 'blacklistCustomer'])->name('customer.blacklist');

Route::get('/admin/dashboard/newsletter-requests',  [AdminDashboard::class, 'newsletterRequests'])->name('admin.newsletterRequests');
Route::get('/admin/dashboard/reviews',  [AdminDashboard::class, 'reviews'])->name('admin.reviews');
Route::get('/admin/dashboard/queries',  [AdminDashboard::class, 'queries'])->name('admin.queries');
Route::get('/admin/dashboard/contact-us', [AdminDashboard::class, 'contactUs'])->name('admin.contact');
