<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\SellerDashboard;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::post('/register', [RegisterController::class, 'register']);

Route::post('/register-district', [CommonController::class, 'getDistricts']);

Route::post('/register-cities', [CommonController::class, 'getCities']);


Route::get('customer-care', function () {
    return view('customer_care');
});


Route::get('/seller-dashboard', [SellerDashboard::class, 'index']);
// Route::get('/seller-dashboard-products', function () {
//     return view('seller.dashboard_products');
// });
