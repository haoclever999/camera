<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    private $dmuc, $sp;
    public function __construct(DanhMuc $dmuc, SanPham $sp)
    {
        $this->dmuc = $dmuc;
        $this->sp = $sp;
    }

    public function home(Request $request)
    {
        $url_canonical = $request->url();
        $dm =  $this->dmuc->orderby('ten_dm', 'asc')->get();
        $sp_moi = $this->sp::orderBy('created_at', 'desc')->take(8)->get();
        $sp_noi_bat = $this->sp::orderBy('luot_xem', 'desc')->take(8)->get();
        return view('frontend.user_home', compact('dm', 'sp_moi', 'sp_noi_bat', 'url_canonical'));
    }

    public function guiMail()
    {
        return 'ok';
    }
}
