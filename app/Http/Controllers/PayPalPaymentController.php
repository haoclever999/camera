<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalPaymentController extends Controller
{
    public function createTransaction()
    {
        return view('transaction');
    }
    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request)
    {
        $tien_usd = Session::get('tien_usd');
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
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
    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()
                ->route('thanhtoan.getThanhToan')
                ->with('successPaypal', 'Thanh toán Paypal thành công.');
        } else {
            return redirect()
                ->route('thanhtoan.getThanhToan')
                ->with('errorPaypal', $response['message'] ?? 'Lỗi thanh toán.');
        }
    }
    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request)
    {
        return redirect()
            ->route('thanhtoan.getThanhToan')
            ->with('errorPaypal', $response['message'] ?? 'Bạn đã huỷ giao dịch Paypal.');
    }
}
