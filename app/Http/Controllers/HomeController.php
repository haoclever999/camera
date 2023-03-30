<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $dmuc, $sp;
    public function __construct(DanhMuc $dmuc, SanPham $sp)
    {
        $this->dmuc = $dmuc;
        $this->sp = $sp;
    }

    public function home()
    {
        $dm =  $this->dmuc->where('parent_id', 0)->orderby('ten_dm', 'asc')->get();
        $sp_moi = $this->sp::orderBy('created_at', 'desc')->take(8)->get();
        $sp_noi_bat = $this->sp::orderBy('luot_xem', 'desc')->take(8)->get();
        return view('frontend.user_home', compact('dm', 'sp_moi', 'sp_noi_bat'));
    }
}
