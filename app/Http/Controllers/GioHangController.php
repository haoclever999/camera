<?php

namespace App\Http\Controllers;

use App\Mail\ThanhToan;
use App\Models\CauHinh;
use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\QuanHuyen;
use App\Models\SanPham;
use App\Models\TinhThanhPho;
use App\Models\User;
use App\Models\XaPhuong;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class GioHangController extends Controller
{
    private $spham, $dmuc, $donhang, $cauhinh, $u;
    public function __construct(DonHang $donhang, SanPham $spham, DanhMuc $dmuc, CauHinh $cauhinh, User $u)
    {
        $this->spham = $spham;
        $this->dmuc = $dmuc;
        $this->donhang = $donhang;
        $this->cauhinh = $cauhinh;
        $this->u = $u;
    }

    public function them_giohang(Request $request)
    {
        if ($request->ajax()) {
            $giohang = $this->spham->where('id', $request->id_sp)->first();
            $gia = $giohang->gia_ban - ($giohang->gia_ban * $giohang->giam_gia / 100);

            $data['id'] = $giohang->id;
            $data['name'] = $giohang->ten_sp;
            $data['price'] = $gia;
            $data['qty'] = $request->num_so_luong;
            $data['options']['hinh_anh'] = $giohang->hinh_anh_chinh;
            Cart::add($data);
            return response()->json(['status' => 'Thêm thành công',]);
        }
    }

    public function chitiet(Request $request)
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
        return view('frontend.giohang.giohang_show', compact('dm', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dc', 'dt', 'fb', 'email'));
    }

    public function capnhat_soluong(Request $request)
    {
        Cart::update($request->rowId, $request->num_so_luong);
        session()->flash('success_sl', 'Cập nhật số lượng thành công');
        return redirect()->route('giohang.chitiet_giohang');
    }

    public function xoa_sp($rowId)
    {
        Cart::remove($rowId);
        return redirect()->back();
    }

    public function xoatatca()
    {
        Cart::destroy();
        return redirect()->route('giohang.chitiet_giohang');
    }

    public function getThanhToan(Request $request)
    {
        $dt = $this->cauhinh->where('ten', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('ten', 'Facebook')->first();
        $email = $this->cauhinh->where('ten', 'Email')->first();
        $dc = $this->cauhinh->where('ten', 'Địa chỉ')->first();


        //địa chỉ
        $tinh_tp = TinhThanhPho::orderby('ten_tp')->get();
        $huyen = QuanHuyen::orderby('ten_qh')->get();
        $xa = XaPhuong::orderby('ten_xa')->get();
        if (Auth::check()) {
            $u = User::where('id', Auth()->user()->id)->get();
            foreach ($u as $value)
                $d_c = $value->dia_chi;
            $dchi = explode(', ', $d_c);
        }
        $dchi = '';
        //SEO
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';
        $url_canonical = $request->url();

        $dm =  $this->dmuc->orderby('ten_dm', 'asc')->get();
        $tt_giohang = Cart::content();
        if (count($tt_giohang) > 0) {
            return view('frontend.giohang.thanhtoan', compact('dm', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'tinh_tp', 'huyen', 'xa', 'dchi', 'dc', 'dt', 'fb', 'email'));
        }
        return redirect()->route('giohang.chitiet_giohang');
    }

    public function postThanhToan(Request $request)
    {
        $request->validate(
            [
                'ho_ten' => 'required',
                'sdt' => 'required',
                'dia_chi' => 'required',
            ],
            [
                'ho_ten.required' => 'Hãy nhập họ tên',
                'sdt.required' => 'Hãy nhập số điện thoại',
                'dia_chi.required' => 'Hãy nhập địa chỉ giao hàng',
            ]
        );
        try {
            DB::beginTransaction();

            session()->put('tt_donhang', $request->all());
            if ($request->thanh_toan == 1) {
                return redirect()->route('processTransaction_Paypal');
            } elseif ($request->thanh_toan == 2) {
                return redirect()->route('processTransaction_VNPAY');
            } else {
                if (!empty($request->ghi_chu)) $ghi_chu = $request->ghi_chu;
                else $ghi_chu = '';
                $xa = XaPhuong::where('id', $request->opt_Xa)->first();
                $huyen = QuanHuyen::where('id', $request->opt_Huyen)->first();
                $tinh = TinhThanhPho::where('id', $request->opt_Tinh)->first();

                $diachi = $request->dia_chi . ', ' . $xa->ten_xa . ', ' . $huyen->ten_qh . ', ' . $tinh->ten_tp;
                if (Auth::check()) {
                    $tk = $this->u->where('email', Auth::user()->email)->first();
                    $user = $this->u->find($tk->id);
                    if ($tk->dia_chi == '')
                        $user->update(['dia_chi' =>  $diachi]);
                    if ($tk->sdt == '')
                        $user->update(['sdt' =>  $request->sdt]);
                    $user_id = auth()->id();
                } else {
                    $user_id = 1;
                }

                $dhang = $this->donhang->create([
                    'user_id' => $user_id,
                    'ten_kh' => $request->ho_ten,
                    'sdt_kh' => $request->sdt,
                    'dia_chi_kh' => $diachi,
                    'tong_so_luong' => Cart::count(),
                    'thue' => Cart::tax(0, '', ''),
                    'tong_tien' => Cart::total(0, '', ''),
                    'hinh_thuc' => "Thanh toán khi nhận hàng",
                    'ghi_chu' => $ghi_chu,
                    'trang_thai' => 'Đang chờ xử lý',
                ]);

                //thêm đơn hàng chi tiết
                $tt_giohang = Cart::content();
                if (count($tt_giohang) > 0) {
                    foreach ($tt_giohang as $item) {
                        $dhang->DonHangChiTiet()->create([
                            'sp_id' => $item->id,
                            'so_luong_ban' => $item->qty,
                            'gia' => $item->price,
                            'thanh_tien' => $item->price * $item->qty,
                        ]);
                        $sanpham = $this->spham->find($item->id);
                        $lmua = $sanpham->luot_mua;

                        $sanpham->update([
                            'luot_mua' => $lmua + $item->qty,
                        ]);
                    }
                }
                $dt = $this->cauhinh->where('ten', 'Điện thoại')->first();

                DB::commit();
                if (Auth::check())
                    Mail::to(Auth::user()->email)->send(new ThanhToan($dhang, $dt->gia_tri));

                Cart::destroy();
                session()->flash('success', 'Cảm ơn bạn đã đặt hàng. Đơn hàng đang chờ xử lý. Vui lòng chờ!');
                return redirect()->route('giohang.chitiet_giohang');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            session()->flash('error', 'Đặt hàng không thành công.');
            return redirect()->route('thanhtoan.getThanhToan');
        }
    }

    public function diachi(Request $request)
    {
        $action = $request->action;
        $id_diachi = $request->id_diachi;

        if ($action) {
            $kq = '';
            if ($action == 'opt_Tinh') {
                $select_Huyen = QuanHuyen::where('id_tp', $id_diachi)->orderby('ten_qh')->get();
                $kq = '<option value="">--Quận/Huyện--</option>';
                foreach ($select_Huyen as $qh)
                    $kq .= '<option value="' . $qh->id . '">' . $qh->ten_qh . '</option>';
            } else {
                $kq = '<option value="">--Xã phường/Thị trấn--</option>';
                $select_Xa = XaPhuong::where('id_qh', $id_diachi)->orderby('ten_xa')->get();
                foreach ($select_Xa as $xa)
                    $kq .= '<option value="' . $xa->id . '">' . $xa->ten_xa . '</option>';
            }
        }
        echo $kq;
    }

    public function getLichSuMuaHang(Request $request)
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

        $dm =  $this->dmuc->orderby('ten_dm')->get();
        $lichsu = $this->donhang->where('user_id', auth()->user()->id)->orderby('created_at', 'desc')->get();
        return view('frontend.giohang.lichsu_muahang', compact('lichsu', 'dm', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dc', 'dt', 'fb', 'email'));
    }

    public function getLichSuMuaHangChiTiet($id, Request $request)
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

        $dm =  $this->dmuc->orderby('ten_dm')->get();
        $lichsu = $this->donhang->find($id);
        return view('frontend.giohang.lichsu_muahang_chitiet', compact('lichsu', 'dm', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dc', 'dt', 'fb', 'email'));
    }
}
