<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\CauHinhController;
use App\Http\Controllers\GioHangController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\ThuongHieuController;
use App\Http\Controllers\HomeController;
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


//admin
Route::prefix('admin')->middleware('CheckLogout')->group(function () {
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
        Route::get('/san-pham-chi-tiet/{id}', [SanPhamController::class, 'show'])->name('sanpham.show');
        Route::get('/them-san-pham', [SanPhamController::class, 'create'])->name('sanpham.create');
        Route::post('/them-san-pham', [SanPhamController::class, 'store'])->name('sanpham.store');
        Route::get('/cap-nhat-san-pham/{id}', [SanPhamController::class, 'edit'])->name('sanpham.edit');
        Route::post('/cap-nhat-san-pham/{id}', [SanPhamController::class, 'update'])->name('sanpham.update');
        Route::get('/xoa-san-pham/{id}', [SanPhamController::class, 'destroy'])->name('sanpham.destroy');
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

    // Quản lý đơn hàng
    Route::prefix('don-hang')->group(function () {
        Route::get('/', [DonHangController::class, 'index'])->name('donhang.index');
        Route::get('/xem-don-hang/{id}', [DonHangController::class, 'show'])->name('donhang.show');
        Route::get('/xac-nhan-don-hang/{id}', [DonHangController::class, 'xacnhan'])->name('donhang.xacnhan');
        Route::get('/huy-don-hang/{id}', [DonHangController::class, 'huy'])->name('donhang.huy');
        Route::get('/xoa-don-hang/{id}', [DonHangController::class, 'destroy'])->name('donhang.destroy');
    });

    // Quản lý cấu hình
    Route::prefix('cau-hinh')->group(function () {
        Route::get('/', [CauHinhController::class, 'index'])->name('cauhinh.index');
        Route::post('/them-cau-hinh', [CauHinhController::class, 'store'])->name('cauhinh.store');
        Route::get('/cap-nhat-cau-hinh/{id}', [CauHinhController::class, 'edit'])->name('cauhinh.edit');
        Route::post('/cap-nhat-cau-hinh/{id}', [CauHinhController::class, 'update'])->name('cauhinh.update');
        Route::get('/xoa-cau-hinh/{id}', [CauHinhController::class, 'destroy'])->name('cauhinh.destroy');
    });
});

//user
Route::get('/', [HomeController::class, 'home'])->name('home.index');

Route::get('dang-nhap', [AuthController::class, 'getDangNhapUser'])->name('getDangNhapUser')->middleware('CheckLogin');
Route::post('dang-nhap', [AuthController::class, 'postDangNhapUser'])->name('postDangNhapUser');
Route::get('dang-xuat', [AuthController::class, 'DangXuatUser'])->name('DangXuatUser');
Route::get('dang-nhap/quen-mat-khau', [AuthController::class, 'getQuenMatKhauUser'])->name('getQuenMatKhauUser');
Route::post('dang-nhap/quen-mat-khau', [AuthController::class, 'postQuenMatKhauUser'])->name('postQuenMatKhauUser');
Route::get('dang-ky', [AuthController::class, 'getDangKy'])->name('getDangKy');
Route::post('dang-ky', [AuthController::class, 'postDangKy'])->name('postDangKy');

//tài khoản người dùng
Route::get('/ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'gethosoUser'])->name('nguoidung.gethosoUser');
Route::post('/ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'posthosoUser'])->name('nguoidung.posthosoUser');
Route::get('/doi-mat-khau/{id}', [NguoiDungController::class, 'getdoimatkhauUser'])->name('nguoidung.getdoimatkhauUser');
Route::post('/doi-mat-khau/{id}', [NguoiDungController::class, 'postdoimatkhauUser'])->name('nguoidung.postdoimatkhauUser');
//sản phẩm
Route::get('/danh-muc/{slug}/{id}', [DanhMucController::class, 'getDanhMucSanPham'])->name('danhmuc.sanpham');
Route::get('/danh-muc/{id_dm}/thuong-hieu/{slug}/{id}', [ThuongHieuController::class, 'getThuongHieuDanhMuc'])->name('thuonghieu.sanpham');
Route::get('/thuong-hieu/{slug}/{id}', [ThuongHieuController::class, 'getThuongHieuSanPham'])->name('thuonghieu.sanpham_all');
Route::get('/chi-tiet-san-pham/{id}', [SanPhamController::class, 'getChiTietSanPham'])->name('sanpham.chitiet');
Route::get('/san-pham', [SanPhamController::class, 'getAllSanPham'])->name('sanpham.all');

//giỏ hàng
Route::post('/them-gio-hang', [GioHangController::class, 'create'])->name('giohang.them_giohang');
Route::get('/gio-hang', [GioHangController::class, 'show'])->name('giohang.show_giohang');
Route::post('/gio-hang/cap-nhat-so-luong', [GioHangController::class, 'update'])->name('giohang.capnhat_soluong');
Route::get('/gio-hang/xoa-san-pham/{rowId}', [GioHangController::class, 'remove'])->name('giohang.xoa_sp');
Route::get('/gio-hang/xoa-san-pham', [GioHangController::class, 'destroy'])->name('giohang.destroy');

//thanh toán
Route::get('/thanh-toan', [GioHangController::class, 'getThanhToan'])->name('thanhtoan.getThanhToan')->middleware('CheckLogoutUser');
Route::post('/thanh-toan', [GioHangController::class, 'postThanhToan'])->name('thanhtoan.postThanhToan')->middleware('CheckLogoutUser');
Route::post('/dia-chi', [GioHangController::class, 'diachi'])->name('diachi');

//tìm kiếm
Route::get('/tim-kiem-san-pham', [SanPhamController::class, 'timKiemSanPham'])->name('sanpham.timkiem');

//gửi mail
Route::get('/gui-mail', [HomeController::class, 'guiMail'])->name('home.guimail');
