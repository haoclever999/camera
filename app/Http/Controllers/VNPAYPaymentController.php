<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\ThanhToan;
use App\Models\CauHinh;
use App\Models\DonHang;
use App\Models\GiaoDich;
use App\Models\QuanHuyen;
use App\Models\SanPham;
use App\Models\TinhThanhPho;
use App\Models\User;
use App\Models\XaPhuong;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class VNPAYPaymentController extends Controller
{
    public function processTransaction_VNPAY(Request $request)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('successTransaction_VNPAY');
        $vnp_TmnCode = "ENKBHMP4"; //Mã website tại VNPAY 
        $vnp_HashSecret = "TCKBYJIRVWSKCKBKCOGSPSNVTALIFFZV"; //Chuỗi bí mật

        $vnp_TxnRef = Str::random(5) . Carbon::now()->format('dmYHis'); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_Amount = Cart::total(0, '', '') * 100;
        $vnp_OrderInfo = "Thanh toán đơn hàng. Số tiền " . Cart::total(0, '', '') . 'đ';
        $vnp_OrderType = 'billpayment';
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = request()->ip();


        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef

        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        return redirect($vnp_Url);
    }

    public function successTransaction_VNPAY(Request $request)
    {
        //Thanh toán bằng VNPAY
        if (Session::has('tt_donhang') && $request->vnp_ResponseCode == "00") {
            DB::beginTransaction();
            try {
                $vnpay = $request->all();
                $tt_donhang = Session::get('tt_donhang');

                if (!empty($tt_donhang['ghi_chu'])) $ghi_chu = $tt_donhang['ghi_chu'];
                else $ghi_chu = '';
                $xa = XaPhuong::where('id', $tt_donhang['opt_Xa'])->first();
                $huyen = QuanHuyen::where('id', $tt_donhang['opt_Huyen'])->first();
                $tinh = TinhThanhPho::where('id', $tt_donhang['opt_Tinh'])->first();

                $diachi = $tt_donhang['dia_chi'] . ', ' . $xa->ten_xa . ', ' . $huyen->ten_qh . ', ' . $tinh->ten_tp;
                $tk = User::where('email', Auth::user()->email)->first();
                $user = User::find($tk->id);
                if ($tk->dia_chi == '')
                    $user->update(['dia_chi' =>  $diachi]);
                if ($tk->sdt == '')
                    $user->update(['sdt' =>  $tt_donhang['sdt']]);

                $dhang = DonHang::create([
                    'user_id' => auth()->id(),
                    'ten_kh' => $tt_donhang['ho_ten'],
                    'sdt_kh' => $tt_donhang['sdt'],
                    'dia_chi_kh' => $diachi,
                    'tong_so_luong' => Cart::count(),
                    'thue' => Cart::tax(0, '', ''),
                    'tong_tien' => Cart::total(0, '', ''),
                    'hinh_thuc' => "Thanh toán bằng VNPAY",
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
                        $sanpham = SanPham::find($item->id);
                        $lmua = $sanpham->luot_mua;

                        $sanpham->update([
                            'luot_mua' => $lmua + $item->qty,
                        ]);
                    }
                }
                // Lưu thông tin giao dịch 
                GiaoDich::create([
                    'user_id' => auth()->id(),
                    'so_tien' => Cart::total(0, '', ''),
                    'noi_dung_thanh_toan' => $vnpay['vnp_OrderInfo'],
                    'ma_phan_hoi' => $vnpay['vnp_ResponseCode'],
                    'ma_giao_dich' => $vnpay['vnp_TxnRef'],
                    'ma_ngan_hang' => $vnpay['vnp_BankCode'],
                ]);
                $dt = CauHinh::where('cau_hinh_key', 'Điện thoại')->first();

                DB::commit();
                Mail::to(Auth::user()->email)->send(new ThanhToan($dhang, $dt->cau_hinh_value));

                Cart::destroy();
                session()->flash('success', 'Cảm ơn bạn đã đặt hàng. Đơn hàng đang chờ xử lý. Vui lòng chờ!');
                return redirect()->route('giohang.chitiet_giohang');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Message: ' . $e->getMessage() . ' --- Line : ' . $e->getLine());
                session()->flash('errorVNPAY', 'Lỗi thanh toán. Đặt hàng không thành công.');
                return redirect()->route('thanhtoan.getThanhToan');
            }
        } else {
            session()->flash('errorVNPAY', 'Bạn đã huỷ thanh toán VNPAY.');
            return redirect()->route('thanhtoan.getThanhToan');
        }
    }
}
