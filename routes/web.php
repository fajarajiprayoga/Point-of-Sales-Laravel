<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;

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

Route::get('/', fn () => redirect()->route('login'));

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('welcome');
    })->name('dashboard');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/category/data', [CategoryController::class, 'data'])->name(('category.data'));
    Route::resource('/category', CategoryController::class);

    Route::get('/product/data', [ProductController::class, 'data'])->name(('product.data'));
    Route::post('/product/delete-selected', [ProductController::class, 'deleteselected'])->name('product.deleteselected');
    Route::post('/product/cetak-barcode', [ProductController::class, 'cetakbarcode'])->name('product.cetakbarcode');
    Route::resource('/product', ProductController::class);

    Route::get('/member/data', [MemberController::class, 'data'])->name('member.data');
    Route::resource('/member', MemberController::class);
    Route::post('/member/delete-selected', [MemberController::class, 'deleteselected'])->name('member.deleteselected');
    Route::post('/member/cetak-member', [MemberController::class, 'cetakmember'])->name('member.cetakmember');

    Route::get('/supplier/data', [SupplierController::class, 'data'])->name('supplier.data');
    Route::resource('/supplier', SupplierController::class);
});

Route::get('/countproduct', [DebugController::class, 'countproduct'])->name('countproduct');
