<?php

namespace App\Http\Controllers;

use App\Models\CauHinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;
use App\Models\DonHang;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class CauHinhController extends Controller
{
    use DeleteModelTrait;
    private $cauhinh, $dhang;
    public function __construct(CauHinh $cauhinh, DonHang $dhang)
    {
        $this->cauhinh = $cauhinh;
        $this->dhang = $dhang;
    }

    public function index(Request $request)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $page = 5;
        $cauhinh = $this->cauhinh::where('trang_thai', 1)->orderBy('ten')->paginate($page)->appends($request->query());
        $dh_moi =  $this->dhang->where('trang_thai', "Đang chờ xử lý")->count();
        return view('backend.cauhinh.home', compact("cauhinh", 'dh_moi'))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function postThem(Request $request)
    {
        $request->validate([
            'ten' => 'required|max:191|unique:cau_hinhs',
            'gia_tri' => 'required|max:191',
        ], [
            'ten.required' => 'Hãy nhập tên cấu hình',
            'ten.max' => 'Tên cấu hình quá dài',
            'ten.unique' => 'Tên cấu hình đã tồn tại',
            'gia_tri.required' => 'Hãy nhập giá trị của cấu hình',
            'gia_tri.max' => 'Giá trị của cấu hình quá dài',

        ]);
        try {
            DB::beginTransaction();
            $this->cauhinh->firstOrCreate([
                'ten' => trim($request->ten),
                'gia_tri' => trim($request->gia_tri),
            ]);
            DB::commit();
            Alert::success('Thành công', 'Thêm cấu hình thành công');
            return redirect()->route('cauhinh.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Thêm cấu hình thất bại');
            return redirect()->route('cauhinh.index');
        }
    }

    public function getSua($id)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $cauhinh = $this->cauhinh->find($id);
        $dh_moi =  $this->dhang->where('trang_thai', "Đang chờ xử lý")->count();
        return view('backend.cauhinh.sua', compact('cauhinh', 'dh_moi'));
    }

    public function postSua(Request $request, $id)
    {
        if ($request->has('ten')) {
            $request->validate([
                'ten' => 'required||unique:cau_hinhs',
                'gia_tri' => 'required|max:191',
            ], [
                'ten.required' => 'Hãy nhập tên cấu hình',
                'ten.max' => 'Tên cấu hình quá dài',
                'ten.unique' => 'Tên cấu hình đã tồn tại',
                'gia_tri.required' => 'Hãy nhập giá trị của cấu hình',
                'gia_tri.max' => 'Giá trị của cấu hình quá dài',

            ]);
        } else {
            $request->validate([
                'ten' => 'required|max:191',
                'gia_tri' => 'required|max:191',
            ], [
                'ten.required' => 'Hãy nhập tên cấu hình',
                'ten.max' => 'Tên cấu hình quá dài',
                'gia_tri.required' => 'Hãy nhập giá trị của cấu hình',
                'gia_tri.max' => 'Giá trị của cấu hình quá dài',

            ]);
        }
        try {
            DB::beginTransaction();
            if ($request->has('ten2')) $cau_hitennh_key = $request->ten2;
            else $ten = $request->ten;

            $ch = $this->cauhinh->find($id);
            $ch->id = $request->id;
            $ch->ten = trim($ten);
            $ch->gia_tri = trim($request->gia_tri);
            $ch->save();
            DB::commit();
            Alert::success('Thành công', 'Cập nhật cấu hình thành công');
            return redirect()->route('cauhinh.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Cập nhật cấu hình thất bại');
            return redirect()->route('cauhinh.getSua', ['id' => $id]);
        }
    }

    public function xoa($id)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        return $this->deleteModelTrait($id, $this->cauhinh);
    }

    public function timkiem(Request $request)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        if ($request->ajax()) {
            $page = 5;
            $timkiem = $this->cauhinh->where('trang_thai', 1)->where('ten', 'LIKE', '%' . $request->timkiem_cauhinh . '%')->orwhere('gia_tri', 'LIKE', '%' . $request->timkiem_cauhinh . '%')->orderby('ten')->paginate($page)->appends($request->query());
            if ($timkiem->count() > 0) {
                $kq = '';
                $i = (request()->input('page', 1) - 1) * $page;
                foreach ($timkiem as $ch) {
                    $kq .= '<tr>
                        <td>' . ++$i . '</td>
                        <td style="text-align: left">' . $ch->ten . '</td>
                        <td style="text-align: left">' . $ch->gia_tri . '</td>
                        <td>' . Carbon::createFromFormat("Y-m-d H:i:s", $ch->updated_at)->format("H:i:s d/m/Y") . '</td>
                        <td>
                            <a
                                style="
                                    width: 88px;
                                    padding: 3px 10px;
                                    margin: 3px;
                                "
                                class="btn btn-warning"
                                href="' . route("cauhinh.getSua", ["id" => $ch->id]) . '"
                            >
                                Cập nhật
                            </a>';
                    if (auth()->check() && auth()->user()->quyen == "Quản trị") {
                        $kq .= '<a
                                style="
                                    width: 88px;
                                    padding: 3px 10px;
                                    margin: 3px;
                                "
                                class="btn btn-danger action_del"
                                href=""
                                data-url="' . route("cauhinh.xoa", ["id" => $ch->id]) . '"
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
}
