<?php

namespace App\Http\Controllers;

use App\Components\LaySP;
use App\Models\CauHinh;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use App\Mail\LienHe;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    private $dmuc, $cauhinh;
    public function __construct(DanhMuc $dmuc, CauHinh $cauhinh)
    {
        $this->dmuc = $dmuc;
        $this->cauhinh = $cauhinh;
    }

    public function home(Request $request)
    {
        $dt = $this->cauhinh->where('cau_hinh_key', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('cau_hinh_key', 'Facebook')->first();
        $email = $this->cauhinh->where('cau_hinh_key', 'Email')->first();

        //SEO
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';
        $url_canonical = $request->url();

        $dm =  $this->dmuc->orderby('ten_dm', 'asc')->get();
        $sp_moi = (new LaySP)->getSanPham()->orderBy('created_at', 'desc')->take(8)->get();
        $sp_noi_bat = (new LaySP)->getSanPham()->orderBy('luot_xem', 'desc')->take(8)->get();
        return view('frontend.user_home', compact('dm', 'sp_moi', 'sp_noi_bat', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dt', 'fb', 'email'));
    }

    public function getLienHe(Request $request)
    {
        $dt = $this->cauhinh->where('cau_hinh_key', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('cau_hinh_key', 'Facebook')->first();
        $email = $this->cauhinh->where('cau_hinh_key', 'Email')->first();

        //SEO
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';
        $url_canonical = $request->url();

        $dm =  $this->dmuc->orderby('ten_dm', 'asc')->get();
        return view('frontend.lienhe', compact('dm', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dt', 'fb', 'email'));
    }

    public function postLienHe(Request $request)
    {
        $request->validate(
            [
                'ho_ten' => 'required',
                'email' => 'required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'dia_chi' => 'required',
                'noi_dung' => 'required',
            ],
            [
                'ho_ten.required' => 'Hãy nhập họ tên',
                'email.required' => 'Hãy nhập email',
                'email.required' => 'Email không đúng dạng',
                'dia_chi.required' => 'Hãy nhập địa chỉ',
                'noi_dung.required' => 'Hãy nhập nội dung',
            ]
        );

        $input = $request->all();
        Mail::to('npmhao195138@gmail.com')->send(new LienHe($input));
        session()->flash('thongbao', "Đã gửi mail");
        return redirect()->route('getLienHe');
    }
}