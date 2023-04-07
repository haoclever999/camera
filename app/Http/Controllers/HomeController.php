<?php

namespace App\Http\Controllers;

use App\Components\LaySP;
use App\Models\DanhMuc;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    private $dmuc, $sp, $thuonghieu;
    public function __construct(DanhMuc $dmuc, SanPham $sp, ThuongHieu $thuonghieu)
    {
        $this->dmuc = $dmuc;
        $this->sp = $sp;
        $this->thuonghieu = $thuonghieu;
    }

    public function home(Request $request)
    {
        $url_canonical = $request->url();
        $dm =  $this->dmuc->orderby('ten_dm', 'asc')->get();
        $sp_moi = (new LaySP)->getSanPham()->orderBy('created_at', 'desc')->take(8)->get();
        $sp_noi_bat = (new LaySP)->getSanPham()->orderBy('luot_xem', 'desc')->take(8)->get();
        return view('frontend.user_home', compact('dm', 'sp_moi', 'sp_noi_bat', 'url_canonical'));
    }

    public function guiMail()
    {
        return 'ok';
    }
}
