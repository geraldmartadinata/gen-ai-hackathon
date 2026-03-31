<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

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

// Landing page (root route)
Route::get('/', function () {
    return view('landing');
});

// Guest routes (belum login)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Admin routes
Route::middleware('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/items', [AdminController::class, 'items'])->name('admin.items');
    Route::post('/admin', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/admin/items/{id}/edit', [AdminController::class, 'edit'])->name('admin.items.edit');
    Route::put('/admin/items/{id}', [AdminController::class, 'update'])->name('admin.items.update');
    Route::delete('/admin/items/{id}', [AdminController::class, 'destroy'])->name('admin.items.destroy');
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/admin/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::get('/admin/transactions', [AdminController::class, 'transactions'])->name('admin.transactions');
    Route::get('/admin/print/invoice', [AdminController::class, 'printInvoice'])->name('admin.print.invoice');
});

// User routes
Route::middleware('user')->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.catalog');
    Route::get('/user/history', [UserController::class, 'history'])->name('user.history');
    Route::post('/user/cart/add/{itemId}', [UserController::class, 'addToCart'])->name('user.cart.add');
    Route::get('/user/cart', [UserController::class, 'cart'])->name('user.cart');
    Route::post('/user/cart/update', [UserController::class, 'updateCart'])->name('user.cart.update');
    Route::post('/user/cart/remove/{itemId}', [UserController::class, 'removeFromCart'])->name('user.cart.remove');
    Route::post('/user/cart/clear', [UserController::class, 'clearCart'])->name('user.cart.clear');
    Route::get('/user/invoice/create', [UserController::class, 'createInvoice'])->name('user.invoice.create');
    Route::post('/user/invoice/store', [UserController::class, 'storeInvoice'])->name('user.invoice.store');
    Route::get('/user/invoice', [UserController::class, 'createInvoice'])->name('user.invoice');
});

// Common routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
