<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\KhuyenMaiController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\ThuongHieuController;
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

Route::get('admin/getdanghhap', [AuthController::class, 'getDangNhap'])->name('getDangNhap');
Route::post('admin/dangnhap', [AuthController::class, 'postDangNhap'])->name('postDangNhap');

Route::prefix('admin')->group(function () { //check logout
    // Route::prefix('laravel-filemanager')->group(function () {
    //     \UniSharp\LaravelFilemanager\Lfm::routes();
    // });
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Quản lý thương hiệu
    Route::prefix('thuonghieu')->group(function () {
        Route::get('/', [ThuongHieuController::class, 'index'])->name('thuonghieu.index');
        Route::post('/store', [ThuongHieuController::class, 'store'])->name('thuonghieu.store');
        Route::get('/edit/{id}', [ThuongHieuController::class, 'edit'])->name('thuonghieu.edit');
        Route::post('/update/{id}', [ThuongHieuController::class, 'update'])->name('thuonghieu.update');
        Route::get('/destroy/{id}', [ThuongHieuController::class, 'destroy'])->name('thuonghieu.destroy');
    });
    // Quản lý danh mục
    Route::prefix('danhmuc')->group(function () {
        Route::get('/', [DanhMucController::class, 'index'])->name('danhmuc.index');
        Route::post('/store', [DanhMucController::class, 'store'])->name('danhmuc.store');
        Route::get('/edit/{id}', [DanhMucController::class, 'edit'])->name('danhmuc.edit');
        Route::post('/update/{id}', [DanhMucController::class, 'update'])->name('danhmuc.update');
        Route::get('/destroy/{id}', [DanhMucController::class, 'destroy'])->name('danhmuc.destroy');
    });
    // Quản lý sản phẩm
    Route::prefix('sanpham')->group(function () {
        // \UniSharp\LaravelFilemanager\Lfm::routes();
        Route::get('/', [SanPhamController::class, 'index'])->name('sanpham.index');
        Route::get('/create', [SanPhamController::class, 'create'])->name('sanpham.create');
        Route::post('/store', [SanPhamController::class, 'store'])->name('sanpham.store');
        Route::get('/edit/{id}', [SanPhamController::class, 'edit'])->name('sanpham.edit');
        Route::post('/update/{id}', [SanPhamController::class, 'update'])->name('sanpham.update');
        Route::get('/destroy/{id}', [SanPhamController::class, 'destroy'])->name('sanpham.destroy');
    });
    // Quản lý khuyến mãi
    Route::prefix('khuyenmai')->group(function () {
        Route::get('/', [KhuyenMaiController::class, 'index'])->name('khuyenmai.index');
        Route::post('/store', [KhuyenMaiController::class, 'store'])->name('khuyenmai.store');
        Route::get('/edit/{id}', [KhuyenMaiController::class, 'edit'])->name('khuyenmai.edit');
        Route::post('/update/{id}', [KhuyenMaiController::class, 'update'])->name('khuyenmai.update');
        Route::get('/destroy/{id}', [KhuyenMaiController::class, 'destroy'])->name('khuyenmai.destroy');
    });

    // Quản lý đơn hàng
    Route::prefix('donhang')->group(function () {
        Route::get('/', [DonHangController::class, 'index'])->name('donhang.index');
        Route::get('/create', [DonHangController::class, 'create'])->name('donhang.create');
        Route::get('/show', [DonHangController::class, 'show'])->name('donhang.show');
        Route::post('/store', [DonHangController::class, 'store'])->name('donhang.store');
        Route::get('/edit/{id}', [DonHangController::class, 'edit'])->name('donhang.edit');
        Route::post('/update/{id}', [DonHangController::class, 'update'])->name('donhang.update');
        Route::get('/destroy/{id}', [DonHangController::class, 'destroy'])->name('donhang.destroy');
    });

    // Quản lý người dùng
    Route::prefix('nguoidung')->group(function () {
        Route::get('/', [NguoiDungController::class, 'index'])->name('nguoidung.index');
        Route::get('/create', [NguoiDungController::class, 'create'])->name('nguoidung.create');
        Route::post('/store', [NguoiDungController::class, 'store'])->name('nguoidung.store');
        Route::get('/edit/{id}', [NguoiDungController::class, 'edit'])->name('nguoidung.edit');
        Route::post('/update/{id}', [NguoiDungController::class, 'update'])->name('nguoidung.update');
        Route::post('/update/{id}', [NguoiDungController::class, 'capnhatquyen'])->name('nguoidung.capnhatquyen');
        Route::post('/update/{id}', [NguoiDungController::class, 'trangthai'])->name('nguoidung.trangthai');
        Route::get('/destroy/{id}', [NguoiDungController::class, 'destroy'])->name('nguoidung.destroy');
    });
});
Route::prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home.index');
});
