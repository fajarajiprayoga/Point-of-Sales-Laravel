<?php

use App\Http\Controllers\BuyyingController;
use App\Http\Controllers\BuyyingDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DebugController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellingController;
use App\Http\Controllers\SellingDetailController;
use App\Http\Controllers\SupplierController;
use App\Models\Selling;

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

    Route::get('/pengeluaran/data', [PengeluaranController::class, 'data'])->name('pengeluaran.data');
    Route::resource('/pengeluaran', PengeluaranController::class);

    Route::get('/buyying/{id}/create', [BuyyingController::class, 'create'])->name('buyying.create');
    Route::get('/buyying/showdata', [BuyyingController::class, 'showdata'])->name('buyying.showdata');
    Route::get('/buyying/{id}/detail', [BuyyingController::class, 'detail'])->name('buyying.detail');
    Route::resource('/buyying', BuyyingController::class)->except('create');

    Route::resource('/buyying_detail', BuyyingDetailController::class)->except('create', 'show', 'edit');
    // Route::resource('/buyying_detail', BuyyingDetailController::class);
    Route::get('/buyying_detail/{id}/data', [BuyyingDetailController::class, 'data'])->name('buyying_detail.data');
    Route::get('/buyying_detail/{id}/gettotal', [BuyyingDetailController::class, 'gettotal'])->name('buyying_detail.gettotal');

    // Route::resource('/selling', SellingController::class)->except('create', 'show', 'edit');
    Route::get('/transaction/new', [SellingController::class, 'create'])->name('transaction.new');
    Route::post('/transaction/new', [SellingController::class, 'store'])->name('transaction.newtransaction');
    Route::get('/transaction/list', [SellingController::class, 'index'])->name('transaction.list');
    Route::get('/transaction/data', [SellingController::class, 'data'])->name(('transactionlist.data'));
    Route::get('/transaction/cetak-nota', [SellingController::class, 'cetakNota'])->name(('transaction.cetakNota'));
    
    Route::get('/transaction/{id}/data', [SellingDetailController::class, 'data'])->name('transaction.data');
    Route::get('/transaction/{id}/gettotal', [SellingDetailController::class, 'gettotal'])->name('transaction.gettotal');
    Route::resource('/transaction', SellingDetailController::class);
});

Route::get('/countproduct', [DebugController::class, 'countproduct'])->name('countproduct');
