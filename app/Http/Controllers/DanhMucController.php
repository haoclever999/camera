<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;
use RealRashid\SweetAlert\Facades\Alert;
use App\Components\GetOption;
use App\Models\SanPham;
use App\Models\ThuongHieu;

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

    public function getDanhMuc($id)
    {
        $option = new GetOption($this->dmuc::all());
        $DmOpt = $option->OptionDanhMuc($id);
        return $DmOpt;
    }

    public function index()
    {
        $page = 10;
        $dm = $this->dmuc::orderBy('id', 'desc')->paginate($page);
        $DmOpt = $this->getDanhMuc('');
        return view('backend.danhmuc.home', compact('dm', 'DmOpt'))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ten_dm' => 'required|max:191|unique:danh_mucs',
        ], [
            'ten_dm.required' => 'Hãy nhập danh mục',
            'ten_dm.max' => 'Danh mục quá dài',
            'ten_dm.unique' => 'Danh mục đã tồn tại',
        ]);
        try {
            if (!empty($request->opt_dm)) $opt_dm = $request->opt_dm;
            else $opt_dm = '0';
            DB::beginTransaction();
            $this->dmuc->firstOrCreate([
                'ten_dm' => trim($request->ten_dm),
                'slug' => Str::slug($request->ten_dm, '-'),
                'parent_id' => $opt_dm,
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

    public function edit($id)
    {
        $dm = $this->dmuc->find($id);
        $DmOpt = $this->getDanhMuc($dm->parent_id);
        return view('backend.danhmuc.sua', compact('dm', 'DmOpt'));
    }

    public function update(Request $request, $id)
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
            $dm->parent_id = $request->opt_dm;
            $dm->save();
            DB::commit();
            Alert::success('Thành công', 'Cập nhật danh mục thành công');
            return redirect()->route('danhmuc.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Cập nhật danh mục thất bại');
            return redirect()->route('danhmuc.edit', ['id' => $id]);
        }
    }

    public function destroy($id)
    {
        return $this->deleteModelTrait($id, $this->dmuc);
    }

    // Kết thúc trang admin

    // Bắt đầu trang người dùng

    public function getDanhMucSanPham($slug, $id_dm)
    {
        $sp = $this->sanpham->where('dm_id', $id_dm)->paginate(6);
        $dm =  $this->dmuc->where('parent_id', 0)->orderby('ten_dm')->get();
        $ten_dm = $this->dmuc->where('id', $id_dm)->limit(1)->get();

        foreach ($sp as $value)
            $id_th[] = $value->thuong_hieu_id;
        $th_sp = $this->thuonghieu->whereIn('id', $id_th)->distinct()->get();

        return view('frontend.danhmuc_sanpham', compact('dm', 'sp', 'ten_dm', 'th_sp'));
    }
    // Kết thúc trang người dùng
}