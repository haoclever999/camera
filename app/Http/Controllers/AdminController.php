<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use App\Models\SanPham;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{

    public function index()
    {
        if (Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $tong_sp = SanPham::where('trang_thai', 1)->count();
        $dh_moi = DonHang::where('trang_thai', "Đang chờ xử lý")->count();
        $tong_dh = DonHang::where('trang_thai', '!=', "Đã xoá")->count();
        return view('backend.home', compact('tong_sp', 'dh_moi', 'tong_dh'));
    }
}
