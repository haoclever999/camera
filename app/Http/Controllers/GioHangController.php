<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\QuanHuyen;
use App\Models\SanPham;
use App\Models\TinhThanhPho;
use App\Models\User;
use App\Models\XaPhuong;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GioHangController extends Controller
{
    private $spham;
    private $dmuc;
    private $donhang;
    public function __construct(DonHang $donhang, SanPham $spham, DanhMuc $dmuc)
    {
        $this->spham = $spham;
        $this->dmuc = $dmuc;
        $this->donhang = $donhang;
    }

    public function them_giohang(Request $request)
    {
        $giohang = $this->spham->where('id', $request->id_sp)->first();
        $gia = $giohang->gia_ban - ($giohang->gia_ban * $giohang->giam_gia / 100);

        $data['id'] = $giohang->id;
        $data['name'] = $giohang->ten_sp;
        $data['price'] = $gia;
        $data['qty'] = $request->num_so_luong;
        $data['options']['hinh_anh'] = $giohang->hinh_anh_chinh;
        Cart::add($data);

        return redirect()->route('giohang.chitiet_giohang');
    }

    public function chitiet(Request $request)
    {
        $url_canonical = $request->url();
        $dm =  $this->dmuc->orderby('ten_dm', 'asc')->get();
        return view('frontend.giohang.giohang_show', compact('dm', 'url_canonical'));
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
        return redirect()->route('giohang.chitiet_giohang');
    }

    public function xoatatca()
    {
        Cart::destroy();
        return redirect()->route('giohang.chitiet_giohang');
    }

    public function getThanhToan(Request $request)
    {
        //địa chỉ
        $tinh_tp = TinhThanhPho::orderby('ten_tp')->get();
        $huyen = QuanHuyen::orderby('ten_qh')->get();
        $xa = XaPhuong::orderby('ten_xa')->get();
        $u = User::where('id', Auth()->user()->id)->get();
        foreach ($u as $value)
            $d_c = $value->dia_chi;
        $dc = explode(', ', $d_c);

        $url_canonical = $request->url();
        $dm =  $this->dmuc->orderby('ten_dm', 'asc')->get();
        $tt_giohang = Cart::content();
        if (count($tt_giohang) > 0) {
            return view('frontend.giohang.thanhtoan', compact('dm', 'url_canonical', 'tinh_tp', 'huyen', 'xa', 'dc'));
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

            if (!empty($request->ghi_chu)) $ghi_chu = $request->ghi_chu;
            else $ghi_chu = '';
            $xa = XaPhuong::where('id', $request->opt_Xa)->first();
            $huyen = QuanHuyen::where('id', $request->opt_Huyen)->first();
            $tinh = TinhThanhPho::where('id', $request->opt_Tinh)->first();

            $diachi = $request->dia_chi . ', ' . $xa->ten_xa . ', ' . $huyen->ten_qh . ', ' . $tinh->ten_tp;
            $dhang = $this->donhang->create([
                'user_id' => auth()->id(),
                'ten_kh' => $request->ho_ten,
                'sdt_kh' => $request->sdt,
                'dia_chi_kh' => $diachi,
                'tong_so_luong' => Cart::count(),
                'tong_tien' => Cart::total(0, '', ''),
                'hinh_thuc' => $request->thanh_toan,
                'ghi_chu' => $ghi_chu,
                'trang_thai' => 'Đang chờ xử lý',
            ]);


            //thêm đơn hàng chi tiết
            $tt_giohang = Cart::content();
            if (count($tt_giohang) > 0) {
                foreach ($tt_giohang as $key => $item) {
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
            DB::commit();
            Cart::destroy();
            session()->flash('success', 'Cảm ơn bạn đã đặt hàng. Đơn hàng đang chờ xử lý. Vui lòng chờ!');
            return redirect()->route('giohang.chitiet_giohang');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return redirect()->route('giohang.chitiet_giohang');
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
}
