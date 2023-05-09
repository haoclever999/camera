<?php

namespace App\Http\Controllers;

use App\Mail\ThanhToan;
use App\Models\CauHinh;
use App\Models\DonHang;
use App\Models\QuanHuyen;
use App\Models\SanPham;
use App\Models\TinhThanhPho;
use App\Models\User;
use App\Models\XaPhuong;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PayPalPaymentController extends Controller
{

    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction_Paypal(Request $request)
    {
        $tien_usd = Session::get('tt_donhang.tien_usd');

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction_Paypal'),
                "cancel_url" => route('cancelTransaction_Paypal'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $tien_usd
                    ]
                ]
            ]
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('thanhtoan.getThanhToan')
                ->with('errorPaypal', 'Lỗi thanh toán.');
        } else {
            return redirect()
                ->route('thanhtoan.getThanhToan')
                ->with('errorPaypal', $response['message'] ?? 'Lỗi thanh toán.');
        }
    }
    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction_Paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::beginTransaction();
            try {
                $tt_donhang = Session::get('tt_donhang');
                if (!empty($tt_donhang['ghi_chu'])) $ghi_chu = $tt_donhang['ghi_chu'];
                else $ghi_chu = '';
                $xa = XaPhuong::where('id', $tt_donhang['opt_Xa'])->first();
                $huyen = QuanHuyen::where('id', $tt_donhang['opt_Huyen'])->first();
                $tinh = TinhThanhPho::where('id', $tt_donhang['opt_Tinh'])->first();

                $diachi = $tt_donhang['dia_chi'] . ', ' . $xa->ten_xa . ', ' . $huyen->ten_qh . ', ' . $tinh->ten_tp;
                if (Auth::check()) {
                    $tk = User::where('email', Auth::user()->email)->first();
                    $user = User::find($tk->id);
                    if ($tk->dia_chi == '')
                        $user->update(['dia_chi' =>  $diachi]);
                    if ($tk->sdt == '')
                        $user->update(['sdt' =>  $tt_donhang['sdt']]);
                    $user_id = auth()->id();
                } else {
                    $user_id = 1;
                }
                $dhang = DonHang::create([
                    'user_id' => $user_id,
                    'ten_kh' => $tt_donhang['ho_ten'],
                    'sdt_kh' => $tt_donhang['sdt'],
                    'dia_chi_kh' => $diachi,
                    'tong_so_luong' => Cart::count(),
                    'thue' => Cart::tax(0, '', ''),
                    'tong_tien' => Cart::total(0, '', ''),
                    'hinh_thuc' => "Thanh toán bằng Paypal",
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
                $dt = CauHinh::where('ten', 'Điện thoại')->first();

                DB::commit();
                if (Auth::check())
                    Mail::to(Auth::user()->email)->send(new ThanhToan($dhang, $dt->gia_tri));

                Cart::destroy();
                session()->flash('success', 'Cảm ơn bạn đã đặt hàng. Đơn hàng đang chờ xử lý. Vui lòng chờ!');
                return redirect()->route('giohang.chitiet_giohang');
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Message: ' . $e->getMessage() . ' --- Line : ' . $e->getLine());
                return redirect()->route('giohang.chitiet_giohang');
            }
        } else {
            return redirect()
                ->route('thanhtoan.getThanhToan')
                ->with('errorPaypal', $response['message'] ?? 'Lỗi thanh toán. Đặt hàng không thành công.');
        }
    }
    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction_Paypal(Request $request)
    {
        return redirect()
            ->route('thanhtoan.getThanhToan')
            ->with('errorPaypal', $response['message'] ?? 'Bạn đã huỷ thanh toán Paypal.');
    }
}
