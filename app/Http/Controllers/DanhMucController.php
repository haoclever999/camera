<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use App\Components\LaySP;

class DanhMucController extends Controller
{
    use DeleteModelTrait;
    private $dmuc;
    private $sanpham;
    private $thuonghieu;
    public function __construct(DanhMuc $dmuc, SanPham $sanpham, ThuongHieu $thuonghieu)
    {
        $this->dmuc = $dmuc;
        $this->sanpham = $sanpham;
        $this->thuonghieu = $thuonghieu;
    }

    // Bắt đầu trang admin

    public function index()
    {
        $page = 5;
        $dm = $this->dmuc::orderBy('ten_dm')->paginate($page);
        return view('backend.danhmuc.home', compact('dm'))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function postThem(Request $request)
    {
        $request->validate([
            'ten_dm' => 'required|max:191|unique:danh_mucs',
        ], [
            'ten_dm.required' => 'Hãy nhập danh mục',
            'ten_dm.max' => 'Danh mục quá dài',
            'ten_dm.unique' => 'Danh mục đã tồn tại',
        ]);
        try {

            DB::beginTransaction();
            $this->dmuc->firstOrCreate([
                'ten_dm' => trim($request->ten_dm),
                'slug' => Str::slug($request->ten_dm, '-'),
            ]);
            DB::commit();
            Alert::success('Thành công', 'Thêm danh mục thành công');
            return redirect()->route('danhmuc.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Thêm danh mục thất bại');
            return redirect()->route('danhmuc.index');
        }
    }

    public function getSua($id)
    {
        $dm = $this->dmuc->find($id);
        return view('backend.danhmuc.sua', compact('dm'));
    }

    public function postSua(Request $request, $id)
    {
        if ($request->has('ten_dm')) {
            $request->validate([
                'ten_dm' => 'required|max:191|unique:danh_mucs',
            ], [
                'ten_dm.required' => 'Hãy nhập danh mục',
                'ten_dm.max' => 'Danh mục quá dài',
                'ten_dm.unique' => 'Danh mục đã tồn tại',
            ]);
        }
        try {
            DB::beginTransaction();
            $dm = $this->dmuc->find($id);
            if ($request->has('ten_dm2')) $ten_dm = trim($request->ten_dm2);
            else $ten_dm = $request->ten_dm;
            $dm->id = $request->id;
            $dm->ten_dm = $ten_dm;
            $dm->slug = Str::slug($request->ten_dm, '-');
            $dm->save();
            DB::commit();
            Alert::success('Thành công', 'Cập nhật danh mục thành công');
            return redirect()->route('danhmuc.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Cập nhật danh mục thất bại');
            return redirect()->route('danhmuc.getSua', ['id' => $id]);
        }
    }

    public function xoa($id)
    {
        return $this->deleteModelTrait($id, $this->dmuc);
    }

    public function timkiem(Request $request)
    {
        $page = 5;
        $timkiem =  $this->dmuc->where('ten_dm', 'LIKE', '%' . $request->timkiem_th . '%')->orderby('ten_dm')->paginate($page);
        return view('backend.danhmuc.timkiem', compact('timkiem'))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    // Kết thúc trang admin

    // Bắt đầu trang người dùng


    public function getDanhMucSanPham(Request $request, $slug, $id_dm)
    {
        $url_canonical = $request->url();

        $sp = (new LaySP)->getSanPham()->where('dm_id', $id_dm)->paginate(6);

        $dm =  $this->dmuc->orderby('ten_dm')->get();
        $ten_dm = $this->dmuc->where('id', $id_dm)->limit(1)->get();
        if (count($sp) > 0) {
            foreach ($sp as $value)
                $id_th[] = $value->thuong_hieu_id;
            $th_sp = $this->thuonghieu->whereIn('id', $id_th)->distinct()->get();
        } else {
            $th_sp = [];
        }

        return view('frontend.danhmuc_sanpham', compact('dm', 'sp', 'ten_dm', 'th_sp', 'url_canonical'));
    }
    // Kết thúc trang người dùng
}
