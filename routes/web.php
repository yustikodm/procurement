<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public routes
Route::get('/vendor/register', [VendorController::class, 'create'])->name('vendor.register');
Route::post('/vendor/store', [VendorController::class, 'store'])->name('vendor.store');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::get('/admin/register', [AuthController::class, 'showRegistrationForm'])->name('admin.register');
Route::post('/admin/register', [AuthController::class, 'store'])->name('admin.store');
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/vendors/approve', [VendorController::class, 'approveIndex'])->name('vendors.approve');
    Route::post('/vendors/approve/{vendor}', [VendorController::class, 'approve'])->name('vendors.approve.vendor');
    Route::get('/vendors/products', [ProductCatalogController::class, 'index'])->name('admin.products');
    Route::get('/vendors/products/create', [ProductCatalogController::class, 'create'])->name('admin.products.create');
    Route::post('/vendors/products/store', [ProductCatalogController::class, 'store'])->name('admin.products.store');
});

// Vendor routes
Route::middleware(['auth', 'vendor'])->group(function () {
    Route::get('/products', [ProductCatalogController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductCatalogController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductCatalogController::class, 'store'])->name('products.store');
});
