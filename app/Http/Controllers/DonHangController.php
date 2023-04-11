<?php

namespace App\Http\Controllers;

use App\Models\DonHang;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use App\Components\Traits\DeleteModelTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Exports\XuatDonHang;
use App\Models\DonHangChiTiet;
use Maatwebsite\Excel\Facades\Excel;

class DonHangController extends Controller
{
    use DeleteModelTrait;
    private $donhang;

    public function __construct(DonHang $donhang)
    {
        $this->donhang = $donhang;
    }

    public function index()
    {
        $page = 5;
        $dhang = $this->donhang::orderBy('created_at', 'desc')->paginate($page);
        return view('backend.donhang.home', compact("dhang"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function chitiet($id)
    {
        $dhang = $this->donhang->find($id);
        return view('backend.donhang.show', compact('dhang'));
    }

    public function xacnhan($id)
    {
        try {
            DB::beginTransaction();
            $dhang = $this->donhang->find($id);
            $dhang->id = $id;
            $dhang->trang_thai = 'Đã xác nhận đơn';
            $dhang->save();
            DB::commit();
            Alert::success('Thành công', 'Xác nhận đơn hàng thành công');
            return redirect()->route('donhang.chitiet', ['id' => $id]);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Xác nhận đơn hàng thất bại');
            return redirect()->route('donhang.chitiet', ['id' => $id]);
        }
    }

    public function huy($id)
    {
        try {
            DB::beginTransaction();
            $dhang = $this->donhang->find($id);
            $dhang->id = $id;
            $dhang->trang_thai = 'Đã huỷ đơn';
            $dhang->save();
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }

    public function xoa($id)
    {
        try {
            DB::beginTransaction();
            $dhang = $this->donhang->find($id);
            $dhang->id = $id;
            $dhang->trang_thai = 'Đã xoá';
            $dhang->save();
            DB::commit();
            return response()->json([
                'code' => 200,
                'message' => 'success'
            ], 200);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => 'fail'
            ], 500);
        }
    }

    public function timkiem(Request $request)
    {
        $page = 5;
        if ($request->don_hang == 'ten_kh')
            $timkiem =  $this->donhang->where('ten_kh', 'LIKE', '%' . $request->timkiem_dh . '%')->orderby('ten_kh')->paginate($page);
        elseif ($request->don_hang == 'sdt')
            $timkiem =  $this->donhang->where('sdt_kh', 'LIKE', '%' . $request->timkiem_dh . '%')->orderby('sdt_kh')->paginate($page);
        else
            $timkiem =  $this->donhang->where('dia_chi_kh', 'LIKE', '%' . $request->timkiem_dh . '%')->orderby('dia_chi_kh')->paginate($page);
        return view('backend.donhang.timkiem', compact('timkiem'))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    // in đơn hàng
    public function inDonHang($id)
    {
        $dhang = $this->donhang->where('id', $id)->first();
        $pdf = PDF::loadView('backend.donhang.indonhang',  ['dhang' => $dhang]);
        return $pdf->stream('donhang-' . Carbon::now()->format("d-m-Y") . '.pdf');
    }

    public function xuat_excel()
    {
        $dhang = DonHangChiTiet::all()->makeHidden(['id', 'updated_at']);
        return Excel::download(new XuatDonHang($dhang), 'danhsachdonhang-' . Carbon::now()->format("His-dmY") . '.xlsx');
    }
}
