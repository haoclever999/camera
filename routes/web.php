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

Route::get('admin/dang-nhap', [AuthController::class, 'getDangNhap'])->name('getDangNhap')->middleware('CheckLogin');
Route::post('admin/dang-nhap', [AuthController::class, 'postDangNhap'])->name('postDangNhap');
Route::get('admin/dang-xuat', [AuthController::class, 'DangXuat'])->name('DangXuat');

Route::prefix('admin')->middleware('CheckLogout')->group(function () {
    // Route::prefix('laravel-filemanager')->group(function () {
    //     \UniSharp\LaravelFilemanager\Lfm::routes();
    // });
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    // Quản lý thương hiệu
    Route::prefix('thuong-hieu')->group(function () {
        Route::get('/', [ThuongHieuController::class, 'index'])->name('thuonghieu.index');
        Route::post('/them-thuong-hieu', [ThuongHieuController::class, 'store'])->name('thuonghieu.store');
        Route::get('/cap-nhat-thuong-hieu/{id}', [ThuongHieuController::class, 'edit'])->name('thuonghieu.edit');
        Route::post('/cap-nhat-thuong-hieu/{id}', [ThuongHieuController::class, 'update'])->name('thuonghieu.update');
        Route::get('/xoa-thuong-hieu/{id}', [ThuongHieuController::class, 'destroy'])->name('thuonghieu.destroy');
    });
    // Quản lý danh mục
    Route::prefix('danh-muc')->group(function () {
        Route::get('/', [DanhMucController::class, 'index'])->name('danhmuc.index');
        Route::post('/them-danh-muc', [DanhMucController::class, 'store'])->name('danhmuc.store');
        Route::get('/cap-nhat-danh-muc/{id}', [DanhMucController::class, 'edit'])->name('danhmuc.edit');
        Route::post('/cap-nhat-danh-muc/{id}', [DanhMucController::class, 'update'])->name('danhmuc.update');
        Route::get('/xoa-danh-muc/{id}', [DanhMucController::class, 'destroy'])->name('danhmuc.destroy');
    });
    // Quản lý sản phẩm
    Route::prefix('san-pham')->group(function () {
        Route::get('/', [SanPhamController::class, 'index'])->name('sanpham.index');
        Route::get('/them-san-pham', [SanPhamController::class, 'create'])->name('sanpham.create');
        Route::post('/them-san-pham', [SanPhamController::class, 'store'])->name('sanpham.store');
        Route::get('/cap-nhat-san-pham/{id}', [SanPhamController::class, 'edit'])->name('sanpham.edit');
        Route::post('/cap-nhat-san-pham/{id}', [SanPhamController::class, 'update'])->name('sanpham.update');
        Route::get('/xoa-san-pham/{id}', [SanPhamController::class, 'destroy'])->name('sanpham.destroy');
    });
    // Quản lý khuyến mãi
    Route::prefix('khuyen-mai')->group(function () {
        Route::get('/', [KhuyenMaiController::class, 'index'])->name('khuyenmai.index');
        Route::post('/them-khuyen-mai', [KhuyenMaiController::class, 'store'])->name('khuyenmai.store');
        Route::get('/cap-nhat-khuyen-mai/{id}', [KhuyenMaiController::class, 'edit'])->name('khuyenmai.edit');
        Route::post('/cap-nhat-khuyen-mai/{id}', [KhuyenMaiController::class, 'update'])->name('khuyenmai.update');
        Route::get('/xoa-khuyen-mai/{id}', [KhuyenMaiController::class, 'destroy'])->name('khuyenmai.destroy');
    });

    // Quản lý đơn hàng
    Route::prefix('don-hang')->group(function () {
        Route::get('/', [DonHangController::class, 'index'])->name('donhang.index');
        Route::get('/them-don-hang', [DonHangController::class, 'create'])->name('donhang.create');
        Route::get('/xem-don-hang', [DonHangController::class, 'show'])->name('donhang.show');
        Route::post('/them-don-hang', [DonHangController::class, 'store'])->name('donhang.store');
        Route::get('/cap-nhat-don-hang/{id}', [DonHangController::class, 'edit'])->name('donhang.edit');
        Route::post('/cap-nhat-don-hang/{id}', [DonHangController::class, 'update'])->name('donhang.update');
        Route::get('/xoa-don-hang/{id}', [DonHangController::class, 'destroy'])->name('donhang.destroy');
    });

    // Quản lý người dùng
    Route::prefix('nguoi-dung')->group(function () {
        Route::get('/', [NguoiDungController::class, 'index'])->name('nguoidung.index');
        Route::get('/them-nguoi-dung', [NguoiDungController::class, 'create'])->name('nguoidung.create');
        Route::post('/them-nguoi-dung', [NguoiDungController::class, 'store'])->name('nguoidung.store');
        Route::get('/ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'gethoso'])->name('nguoidung.gethoso');
        Route::post('/ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'posthoso'])->name('nguoidung.posthoso');
        Route::get('/doi-mat-khau/{id}', [NguoiDungController::class, 'getdoimatkhau'])->name('nguoidung.getdoimatkhau');
        Route::post('/doi-mat-khau/{id}', [NguoiDungController::class, 'postdoimatkhau'])->name('nguoidung.postdoimatkhau');
        Route::get('/cap-nhat-quyen/{id}', [NguoiDungController::class, 'getcapnhatquyen'])->name('nguoidung.getcapnhatquyen');
        Route::post('/cap-nhat-quyen/{id}', [NguoiDungController::class, 'capnhatquyen'])->name('nguoidung.updatequyen');
        Route::post('/cap-nhat-trang-thai/{id}', [NguoiDungController::class, 'trangthai'])->name('nguoidung.trangthai');
        Route::get('/xoa-nguoi-dung/{id}', [NguoiDungController::class, 'destroy'])->name('nguoidung.destroy');
    });
});
Route::prefix('home')->group(function () {
    Route::get('/', [HomeController::class, 'home'])->name('home.index');
    Route::get('/ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'edit'])->name('nguoidung.edit');
    Route::post('/ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'update'])->name('nguoidung.update');
});
