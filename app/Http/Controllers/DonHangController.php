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
use Illuminate\Support\Facades\Gate;
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
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $page = 5;
        $dhang = $this->donhang::orderBy('created_at', 'desc')->paginate($page);
        return view('backend.donhang.home', compact("dhang"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function chitiet($id)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $dhang = $this->donhang->find($id);
        return view('backend.donhang.show', compact('dhang'));
    }

    public function xacnhan($id)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
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
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
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
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
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
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        if ($request->ajax()) {
            $page = 5;
            $timkiem =  $this->donhang->where('ten_kh', 'LIKE', '%' . $request->timkiem_dh . '%')->orwhere('sdt_kh', 'LIKE', '%' . $request->timkiem_dh . '%')->orwhere('dia_chi_kh', 'LIKE', '%' . $request->timkiem_dh . '%')->orderby('ten_kh')->paginate($page);
            if ($timkiem->count() > 0) {
                $kq = '';
                $i = (request()->input('page', 1) - 1) * $page;
                foreach ($timkiem as $dh) {
                    $kq .= '<tr>
                        <td>' . ++$i . '</td>
                        <td >' . $dh->ten_kh . '</td>
                        <td >' . $dh->sdt_kh . '</td>
                        <td style="text-align: left">' . $dh->dia_chi_kh . '</td>
                        <td >' . $dh->tong_so_luong . '</td>
                        <td >' . number_format($dh->tong_tien, 0, ",", ".") . '</td>
                        <td >' . $dh->hinh_thuc . '</td>
                        <td >' . $dh->trang_thai . '</td>
                        <td>' . Carbon::createFromFormat("Y-m-d H:i:s", $dh->created_at)->format("H:i:s d/m/Y") . '</td>
                        <td>
                            <a
                                style="
                                    min-width: 110px;
                                    padding: 3px 12px;
                                    margin: 3px;
                                "
                                class="btn btn-success"
                                href="' . route("donhang.chitiet", ["id" => $dh->id]) . '"
                                >
                                Chi tiết
                            </a> <br />';
                    if (
                        auth()->check() && auth()->user()->quyen == "Quản trị" &&
                        $dh->trang_thai != "Đã xoá"
                    ) {
                        $kq .= '<a
                                style="
                                    min-width: 110px;
                                    padding: 3px 12px;
                                    margin: 3px;
                                "
                                class="btn btn-danger action_del"
                                href=""
                                data-url="' . route("donhang.xoa", ["id" => $dh->id]) . '"
                                    >
                                        Xóa
                                    </a>';
                    }
                    $kq .= '
                        </td>
                    </tr>';
                }
                return Response($kq);
            } else
                return response()->json(['status' => 'Không tìm thấy',]);
        }
    }

    // in đơn hàng
    public function inDonHang($id)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $dhang = $this->donhang->where('id', $id)->first();
        $pdf = PDF::loadView('backend.donhang.indonhang',  ['dhang' => $dhang]);
        return $pdf->stream('donhang-' . Carbon::now()->format("d-m-Y") . '.pdf');
    }

    public function xuat_excel()
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $dhang = DonHangChiTiet::all()->makeHidden(['id', 'updated_at']);
        return Excel::download(new XuatDonHang($dhang), 'danhsachdonhang-' . Carbon::now()->format("His-dmY") . '.xlsx');
    }
}