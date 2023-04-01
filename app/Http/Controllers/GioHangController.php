<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\DonHang;
use App\Models\SanPham;
use Illuminate\Http\Request;
use Cart;
use Illuminate\Contracts\Session\Session;
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

    public function create(Request $request)
    {
        $giohang = $this->spham->where('id', $request->id_sp)->first();
        $gia = $giohang->gia_ban - ($giohang->gia_ban * $giohang->giam_gia / 100);

        $data['id'] = $giohang->id;
        $data['name'] = $giohang->ten_sp;
        $data['price'] = $gia;
        $data['qty'] = $request->num_so_luong;
        $data['options']['ton'] = $giohang->ton;
        $data['options']['hinh_anh'] = $giohang->hinh_anh_chinh;
        Cart::add($data);

        return redirect()->route('giohang.show_giohang');
    }

    public function show()
    {
        $dm =  $this->dmuc->where('parent_id', 0)->orderby('ten_dm', 'asc')->get();
        return view('frontend.giohang.giohang_show', compact('dm'));
    }


    public function update(Request $request)
    {
        Cart::update($request->rowId, $request->num_so_luong);
        return redirect()->route('giohang.show_giohang');
    }

    public function remove($rowId)
    {
        Cart::remove($rowId);
        return redirect()->route('giohang.show_giohang');
    }

    public function destroy(string $id)
    {
        //xóa tất cả
    }

    public function getThanhToan()
    {
        $dm =  $this->dmuc->where('parent_id', 0)->orderby('ten_dm', 'asc')->get();
        return view('frontend.giohang.thanhtoan', compact('dm'));
    }

    public function postThanhToan(Request $request)
    {
        $request->validate(
            [
                'sdt' => 'required',
                'dia_chi' => 'required',
            ],
            [
                'sdt.required' => 'Hãy nhập số điện thoại',
                'dia_chi.required' => 'Hãy nhập địa chỉ giao hàng',
            ]
        );
        try {
            DB::beginTransaction();

            if (!empty($request->ghi_chu)) $ghi_chu = $request->ghi_chu;
            else $ghi_chu = '';
            $dhang = $this->donhang->create([
                'user_id' => auth()->id(),
                'ten_kh' => $request->ho_ten,
                'sdt_kh' => $request->sdt,
                'dia_chi_kh' => $request->dia_chi,
                'tong_so_luong' => Cart::count(),
                'tong_tien' => Cart::total(0, '', ''),
                'ghi_chu' => $ghi_chu,
                'trang_thai' => 'Chờ xác nhận',
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
                }
            }
            DB::commit();
            Cart::destroy();
            session()->flash('success', 'Vui lòng chờ xác nhận đơn hàng.');
            return redirect()->route('giohang.show_giohang');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());

            return redirect()->route('giohang.show_giohang');
        }
    }
}
