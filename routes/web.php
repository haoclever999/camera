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
use App\Http\Controllers\PayPalPaymentController;
use App\Http\Controllers\VNPAYPaymentController;
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
        Route::post('them-thuong-hieu', [ThuongHieuController::class, 'postThem'])->name('thuonghieu.postthem');
        Route::get('cap-nhat-thuong-hieu/{id}', [ThuongHieuController::class, 'getSua'])->name('thuonghieu.getSua');
        Route::post('cap-nhat-thuong-hieu/{id}', [ThuongHieuController::class, 'postSua'])->name('thuonghieu.postSua');
        Route::get('xoa-thuong-hieu/{id}', [ThuongHieuController::class, 'xoa'])->name('thuonghieu.xoa');
        Route::get('tim-kiem', [ThuongHieuController::class, 'timkiem'])->name('thuonghieu.timkiem');
    });

    // Quản lý danh mục
    Route::prefix('danh-muc')->group(function () {
        Route::get('/', [DanhMucController::class, 'index'])->name('danhmuc.index');
        Route::post('them-danh-muc', [DanhMucController::class, 'postThem'])->name('danhmuc.postThem');
        Route::get('cap-nhat-danh-muc/{id}', [DanhMucController::class, 'getSua'])->name('danhmuc.getSua');
        Route::post('cap-nhat-danh-muc/{id}', [DanhMucController::class, 'postSua'])->name('danhmuc.postSua');
        Route::get('xoa-danh-muc/{id}', [DanhMucController::class, 'xoa'])->name('danhmuc.xoa');
        Route::get('tim-kiem', [DanhMucController::class, 'timkiem'])->name('danhmuc.timkiem');
    });

    // Quản lý sản phẩm
    Route::prefix('san-pham')->group(function () {
        Route::get('/', [SanPhamController::class, 'index'])->name('sanpham.index');
        Route::get('san-pham-chi-tiet/{id}', [SanPhamController::class, 'chitiet'])->name('sanpham.chitiet');
        Route::get('them-san-pham', [SanPhamController::class, 'getThem'])->name('sanpham.getThem');
        Route::post('them-san-pham', [SanPhamController::class, 'postThem'])->name('sanpham.postThem');
        Route::get('cap-nhat-san-pham/{id}', [SanPhamController::class, 'getSua'])->name('sanpham.getSua');
        Route::post('cap-nhat-san-pham/{id}', [SanPhamController::class, 'postSua'])->name('sanpham.postSua');
        Route::get('xoa-san-pham/{id}', [SanPhamController::class, 'xoa'])->name('sanpham.xoa');
        Route::get('tim-kiem', [SanPhamController::class, 'timkiem'])->name('sanpham.timkiem');
        Route::post('nhap-san-pham', [SanPhamController::class, 'nhap_excel'])->name('sanpham.nhapsp');
        Route::post('nhap-hinh-anh', [SanPhamController::class, 'nhap_hinhanh'])->name('sanpham.nhap_hinhanh');
    });

    // Quản lý người dùng
    Route::prefix('nguoi-dung')->group(function () {
        Route::get('/', [NguoiDungController::class, 'index'])->name('nguoidung.index');
        Route::get('them-nguoi-dung', [NguoiDungController::class, 'getThem'])->name('nguoidung.getThem');
        Route::post('them-nguoi-dung', [NguoiDungController::class, 'postThem'])->name('nguoidung.postThem');
        Route::get('ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'gethoso'])->name('nguoidung.gethoso');
        Route::post('ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'posthoso'])->name('nguoidung.posthoso');
        Route::get('doi-mat-khau/{id}', [NguoiDungController::class, 'getdoimatkhau'])->name('nguoidung.getdoimatkhau');
        Route::post('doi-mat-khau/{id}', [NguoiDungController::class, 'postdoimatkhau'])->name('nguoidung.postdoimatkhau');
        Route::post('cap-nhat-quyen/{id}', [NguoiDungController::class, 'postcapnhatquyen'])->name('nguoidung.postcapnhatquyen');
        Route::post('cap-nhat-trang-thai/{id}', [NguoiDungController::class, 'trangthai'])->name('nguoidung.trangthai');
        Route::get('tim-kiem', [NguoiDungController::class, 'timkiem'])->name('nguoidung.timkiem');
    });

    // Quản lý đơn hàng
    Route::prefix('don-hang')->group(function () {
        Route::get('/', [DonHangController::class, 'index'])->name('donhang.index');
        Route::get('xem-don-hang/{id}', [DonHangController::class, 'chitiet'])->name('donhang.chitiet');
        Route::get('xac-nhan-don-hang/{id}', [DonHangController::class, 'xacnhan'])->name('donhang.xacnhan');
        Route::get('huy-don-hang/{id}', [DonHangController::class, 'huy'])->name('donhang.huy');
        Route::get('dang-van-chuyen-don-hang/{id}', [DonHangController::class, 'dangvanchuyen'])->name('donhang.DangVanChuyen');
        Route::get('da-giao-don-hang/{id}', [DonHangController::class, 'dagiao'])->name('donhang.DaGiao');
        Route::get('xoa-don-hang/{id}', [DonHangController::class, 'xoa'])->name('donhang.xoa');
        Route::get('tim-kiem', [DonHangController::class, 'timkiem'])->name('donhang.timkiem');
        Route::get('in-don-hang/{id}', [DonHangController::class, 'inDonHang'])->name('donhang.inDonHang');
        Route::get('xuat-don-hang', [DonHangController::class, 'xuat_excel'])->name('donhang.xuatdonhnag');
    });

    // Quản lý cấu hình
    Route::prefix('cau-hinh')->group(function () {
        Route::get('/', [CauHinhController::class, 'index'])->name('cauhinh.index');
        Route::post('them-cau-hinh', [CauHinhController::class, 'postThem'])->name('cauhinh.postThem');
        Route::get('cap-nhat-cau-hinh/{id}', [CauHinhController::class, 'getSua'])->name('cauhinh.getSua');
        Route::post('cap-nhat-cau-hinh/{id}', [CauHinhController::class, 'postSua'])->name('cauhinh.postSua');
        Route::get('xoa-cau-hinh/{id}', [CauHinhController::class, 'xoa'])->name('cauhinh.xoa');
        Route::get('tim-kiem', [CauHinhController::class, 'timkiem'])->name('cauhinh.timkiem');
    });
});

//user
Route::get('/', [HomeController::class, 'home'])->name('home.index');

Route::get('dang-nhap', [AuthController::class, 'getDangNhapUser'])->name('getDangNhapUser')->middleware('CheckLoginUser');
Route::post('dang-nhap', [AuthController::class, 'postDangNhapUser'])->name('postDangNhapUser');
Route::get('dang-xuat', [AuthController::class, 'DangXuatUser'])->name('DangXuatUser');

Route::get('dang-nhap/quen-mat-khau', [AuthController::class, 'getQuenMatKhauUser'])->name('getQuenMatKhauUser');
Route::post('dang-nhap/quen-mat-khau', [AuthController::class, 'postQuenMatKhauUser'])->name('postQuenMatKhauUser');
Route::get('dang-nhap/dat-lai-mat-khau/{id}/{token}', [AuthController::class, 'getDatLaiMatKhauUser'])->name('getDatLaiMatKhauUser');
Route::post('dang-nhap/dat-lai-mat-khau/{id}', [AuthController::class, 'postDatLaiMatKhauUser'])->name('postDatLaiMatKhauUser');

Route::get('dang-ky', [AuthController::class, 'getDangKy'])->name('getDangKy');
Route::post('dang-ky', [AuthController::class, 'postDangKy'])->name('postDangKy');

Route::get('dang-nhap-facebook', [AuthController::class, 'getDangNhapFacebook'])->name('getDangNhapFacebook');
Route::get('dang-nhap-facebook/xu-ly', [AuthController::class, 'postDangNhapFacebook'])->name('postDangNhapFacebook');

Route::get('dang-nhap-google', [AuthController::class, 'getDangNhapGoogle'])->name('getDangNhapGoogle');
Route::get('dang-nhap-google/xu-ly', [AuthController::class, 'postDangNhapGoogle'])->name('postDangNhapGoogle');

//tài khoản người dùng
Route::get('ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'gethosoUser'])->name('nguoidung.gethosoUser');
Route::post('ho-so-nguoi-dung/{id}', [NguoiDungController::class, 'posthosoUser'])->name('nguoidung.posthosoUser');
Route::get('doi-mat-khau/{id}', [NguoiDungController::class, 'getdoimatkhauUser'])->name('nguoidung.getdoimatkhauUser');
Route::post('doi-mat-khau/{id}', [NguoiDungController::class, 'postdoimatkhauUser'])->name('nguoidung.postdoimatkhauUser');

//sản phẩm
Route::get('danh-muc/{slug}/{id}', [DanhMucController::class, 'getDanhMucSanPham'])->name('danhmuc.sanpham');
Route::get('danh-muc/{id_dm}/thuong-hieu/{slug}/{id}', [ThuongHieuController::class, 'getThuongHieuDanhMuc'])->name('thuonghieu.sanpham');
Route::get('thuong-hieu/{slug}/{id}', [ThuongHieuController::class, 'getThuongHieuSanPham'])->name('thuonghieu.sanpham_all');
Route::get('san-pham/chi-tiet-san-pham/{id}', [SanPhamController::class, 'getChiTietSanPham'])->name('sanpham.chitiet_sp');
Route::get('san-pham', [SanPhamController::class, 'getAllSanPham'])->name('sanpham.all');
Route::get('san-pham/tag/{tag}', [SanPhamController::class, 'getTagSanPham'])->name('tagsp');

//giỏ hàng
Route::post('them-gio-hang', [GioHangController::class, 'them_giohang'])->name('giohang.them_giohang');
Route::get('gio-hang', [GioHangController::class, 'chitiet'])->name('giohang.chitiet_giohang');
Route::post('gio-hang/cap-nhat-so-luong', [GioHangController::class, 'capnhat_soluong'])->name('giohang.capnhat_soluong');
Route::get('gio-hang/xoa-san-pham/{rowId}', [GioHangController::class, 'xoa_sp'])->name('giohang.xoa_sp');
Route::get('gio-hang/xoa-san-pham', [GioHangController::class, 'xoatatca'])->name('giohang.xoatatca');
Route::get('lich-su-mua-hang', [GioHangController::class, 'getLichSuMuaHang'])->name('getLichSuMuaHang');
Route::get('lich-su-mua-hang/{id}', [GioHangController::class, 'getLichSuMuaHangChiTiet'])->name('getLichSuMuaHangChiTiet');

//thanh toán
Route::get('thanh-toan', [GioHangController::class, 'getThanhToan'])->name('thanhtoan.getThanhToan')->middleware('CheckLogoutUser');
Route::post('thanh-toan', [GioHangController::class, 'postThanhToan'])->name('thanhtoan.postThanhToan')->middleware('CheckLogoutUser');
Route::post('dia-chi', [GioHangController::class, 'diachi'])->name('diachi');
Route::get('xu-ly-thanh-toan-paypal', [PayPalPaymentController::class, 'processTransaction_Paypal'])->name('processTransaction_Paypal');
Route::get('thanh-toan-paypal-thanh-cong', [PayPalPaymentController::class, 'successTransaction_Paypal'])->name('successTransaction_Paypal');
Route::get('huy-thanh-toan-paypal', [PayPalPaymentController::class, 'cancelTransaction_Paypal'])->name('cancelTransaction_Paypal');

Route::get('xu-ly-thanh-toan-vnpay', [VNPAYPaymentController::class, 'processTransaction_VNPAY'])->name('processTransaction_VNPAY');
Route::get('thanh-toan-vnpay-thanh-cong', [VNPAYPaymentController::class, 'successTransaction_VNPAY'])->name('successTransaction_VNPAY');

//tìm kiếm
Route::get('san-pham-tim-kiem', [SanPhamController::class, 'timKiemSanPham'])->name('sanpham.timkiemsp');
Route::get('tim-kiem-san-pham', [SanPhamController::class, 'timKiem_Header'])->name('timkiem_header');

//liên hệ
Route::get('lien-he', [HomeController::class, 'getLienHe'])->name('getLienHe');
Route::post('lien-he', [HomeController::class, 'postLienHe'])->name('postLienHe');
