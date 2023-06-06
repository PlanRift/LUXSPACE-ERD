<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
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

Route::get('/', [FrontEndController::class, 'index'])->name('index');
Route::get('/details/{slug}', [FrontEndController::class, 'details'])->name('details');
Route::get('/cart', [FrontEndController::class, 'cart'])->name('cart');
Route::get('/checkout/success', [FrontEndController::class, 'success'])->name('success');

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified', 'IsAdmin'])->name('dashboard.')->prefix('dashboard')->group(function(){
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('product', ProductController::class);
    Route::resource('product.gallery', ProductGalleryController::class)->shallow()->only(['index', 'create', 'store', 'destroy']);
});
