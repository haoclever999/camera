<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function index()
    {
        if (Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $tong_sp = SanPham::where('trang_thai', 1)->count();
        $tong_dm = DanhMuc::where('trang_thai', 1)->count();
        $tong_th = ThuongHieu::where('trang_thai', 1)->count();
        $dh_moi = DonHang::where('trang_thai', "Đang chờ xử lý")->count();
        $tong_dh = DonHang::whereNotIn('trang_thai', ["Đã xoá", 'Đã huỷ đơn'])->count();
        return view('backend.home', compact('tong_sp', 'dh_moi', 'tong_dh', 'tong_dm', 'tong_th'));
    }
}
