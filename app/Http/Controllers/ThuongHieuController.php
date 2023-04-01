<?php

namespace App\Http\Controllers;

use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;
use App\Components\Traits\StorageImageTrait;
use App\Models\CauHinh;
use App\Models\DanhMuc;
use App\Models\SanPham;
use RealRashid\SweetAlert\Facades\Alert;

class ThuongHieuController extends Controller
{
    use DeleteModelTrait, StorageImageTrait;
    private $thuonghieu;
    private $dmuc;
    private $sanpham;
    private $cauhinh;
    public function __construct(DanhMuc $dmuc, SanPham $sanpham,  ThuongHieu $thuonghieu, CauHinh $cauhinh)
    {
        $this->thuonghieu = $thuonghieu;
        $this->dmuc = $dmuc;
        $this->sanpham = $sanpham;
        $this->cauhinh = $cauhinh;
    }

    // Bat dau trang admin
    public function index()
    {
        $page = 10;
        $th = $this->thuonghieu::orderBy('id', 'desc')->paginate($page);
        return view('backend.thuonghieu.home', compact("th"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'ten_thuong_hieu' => 'required|max:191|unique:thuong_hieus',
            ],
            [
                'ten_thuong_hieu.required' => 'Hãy nhập thương hiệu',
                'ten_thuong_hieu.max' => 'Tên thương hiệu quá dài',
                'ten_thuong_hieu.unique' => 'Thương hiệu đã tồn tại',
            ]
        );
        try {
            DB::beginTransaction();
            if ($request->hasFile('logo_thuong_hieu')) $logo = $this->StorageTraitUpload($request, 'logo_thuong_hieu', 'thuonghieu');
            $this->thuonghieu->firstOrCreate([
                'ten_thuong_hieu' => trim($request->ten_thuong_hieu),
                'slug' => Str::slug($request->ten_thuong_hieu, "-"),
                'logo' => $logo,
            ]);
            DB::commit();
            Alert::success('Thành công', 'Thêm thương hiệu thành công');
            return redirect()->route('thuonghieu.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Thêm thương hiệu thất bại');
            return redirect()->route('thuonghieu.index');
        }
    }

    public function edit($id)
    {
        $th = $this->thuonghieu->find($id);
        return view('backend.thuonghieu.sua', compact('th'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has('ten_thuong_hieu')) {
            $request->validate(
                [
                    'ten_thuong_hieu' => 'required|max:191|unique:thuong_hieus',
                ],
                [
                    'ten_thuong_hieu.required' => 'Hãy nhập thương hiệu',
                    'ten_thuong_hieu.max' => 'Tên thương hiệu quá dài',
                    'ten_thuong_hieu.unique' => 'Thương hiệu đã tồn tại',
                ]
            );
        }
        try {
            DB::beginTransaction();
            $th = $this->thuonghieu->find($id);

            if ($request->hasFile('logo_thuong_hieu')) $logo = $this->StorageTraitUpload($request, 'logo_thuong_hieu', 'thuonghieu');
            else $logo = $th->logo;

            if ($request->has('ten_thuong_hieu2')) $ten_th = $request->ten_thuong_hieu2;
            else $ten_th = $request->ten_thuong_hieu;

            $th->id = $request->id;
            $th->ten_thuong_hieu = $ten_th;
            $th->slug = Str::slug($ten_th, "-");
            $th->logo = $logo;
            $th->save();
            DB::commit();
            Alert::success('Thành công', 'Cập nhật thương hiệu thành công');
            return redirect()->route('thuonghieu.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Cập nhật thương hiệu thất bại');
            return redirect()->route('thuonghieu.edit', ['id' => $id]);
        }
    }

    public function destroy($id)
    {
        return $this->deleteModelTrait($id, $this->thuonghieu);
    }
    // Kết thúc trang admin

    // Bắt đầu trang người dùng
    public function getThuongHieuDanhMuc(Request $request, $id_dm, $slug, $id)
    {
        $url_canonical = $request->url();
        $thongtin = $this->cauhinh->all(); //xem laij
        $sp = $this->sanpham->where('thuong_hieu_id', $id)->where('dm_id', $id_dm)->paginate(6);
        $dm =  $this->dmuc->where('parent_id', 0)->orderby('ten_dm')->get();
        $ten_th = $this->thuonghieu->where('id', $id)->limit(1)->get();
        $ten_dm = $this->dmuc->where('id', $id_dm)->limit(1)->get();

        $spham = $this->sanpham->where('dm_id', $id_dm)->paginate(6);
        foreach ($spham as $value)
            $id_th[] = $value->thuong_hieu_id;
        $th_sp = $this->thuonghieu->whereIn('id', $id_th)->distinct()->get();
        return view('frontend.thuonghieu_danhmuc', compact('dm', 'sp', 'ten_dm', 'ten_th', 'th_sp', 'url_canonical'));
    }

    public function getThuongHieuSanPham(Request $request, $slug, $id)
    {
        $url_canonical = $request->url();
        $sp = $this->sanpham->where('thuong_hieu_id', $id)->paginate(6);
        $dm =  $this->dmuc->where('parent_id', 0)->orderby('ten_dm')->get();
        $ten_th = $this->thuonghieu->where('id', $id)->limit(1)->get();
        $th = $this->thuonghieu->orderby('ten_thuong_hieu')->get();

        return view('frontend.thuonghieu_sanpham', compact('dm', 'sp', 'th', 'ten_th', 'url_canonical'));
    }
}
