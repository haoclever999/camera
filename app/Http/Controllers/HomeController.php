<?php

namespace App\Http\Controllers;

use App\Models\CauHinh;
use App\Models\DanhMuc;
use Illuminate\Http\Request;
use App\Mail\LienHe;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    private $dmuc, $cauhinh, $sanpham, $thuonghieu;
    public function __construct(SanPham $sanpham, DanhMuc $dmuc, CauHinh $cauhinh, ThuongHieu $thuonghieu)
    {
        $this->dmuc = $dmuc;
        $this->cauhinh = $cauhinh;
        $this->sanpham = $sanpham;
        $this->thuonghieu = $thuonghieu;
    }

    public function home(Request $request)
    {
        $dt = $this->cauhinh->where('ten', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('ten', 'Facebook')->first();
        $email = $this->cauhinh->where('ten', 'Email')->first();
        $dc = $this->cauhinh->where('ten', 'Địa chỉ')->first();

        //SEO
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';
        $url_canonical = $request->url();

        $dm =  $this->dmuc->where('trang_thai', 1)->orderby('ten_dm', 'asc')->get();
        $th = $this->thuonghieu->where('trang_thai', 1)->orderby('ten_thuong_hieu')->take(10)->get();
        $sp_moi = $this->sanpham->where('trang_thai', 1)->whereIn('thuong_hieu_id', $th->pluck('id'))->whereIn('dm_id', $dm->pluck('id'))->orderBy('created_at', 'desc')->take(4)->get();
        $sp_noi_bat = $this->sanpham->where('trang_thai', 1)->whereIn('thuong_hieu_id', $th->pluck('id'))->whereIn('dm_id', $dm->pluck('id'))->orderBy('luot_xem', 'desc')->take(4)->get();

        return view('frontend.user_home', compact('dm', 'sp_moi', 'sp_noi_bat', 'th', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dc', 'dt', 'fb', 'email'));
    }

    public function getLienHe(Request $request)
    {
        $dt = $this->cauhinh->where('ten', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('ten', 'Facebook')->first();
        $email = $this->cauhinh->where('ten', 'Email')->first();
        $dc = $this->cauhinh->where('ten', 'Địa chỉ')->first();

        //SEO
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';
        $url_canonical = $request->url();

        $dm =  $this->dmuc->orderby('ten_dm', 'asc')->get();
        return view('frontend.lienhe', compact('dm', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dc', 'dt', 'fb', 'email'));
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
