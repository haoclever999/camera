<?php

namespace App\Http\Controllers;

use App\Components\GetOption;
use App\Models\DanhMuc;
use App\Models\HinhAnh;
use App\Models\KhuyenMai;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Components\Traits\StorageImageTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Components\Traits\DeleteModelTrait;

class SanPhamController extends Controller
{
    use DeleteModelTrait, StorageImageTrait;
    private $dmuc;
    private $hanh;
    private $tag;
    private $spham;
    private $thuonghieu;
    private $kmai;
    public function __construct(DanhMuc $dmuc, SanPham $spham, HinhAnh $hanh, Tag $tag, ThuongHieu $thuonghieu, KhuyenMai $kmai)
    {
        //$this->middleware('auth');
        $this->dmuc = $dmuc;
        $this->hanh = $hanh;
        $this->tag = $tag;
        $this->spham = $spham;
        $this->thuonghieu = $thuonghieu;
        $this->kmai = $kmai;
    }

    public function getDanhMuc($id)
    {
        $recusive = new GetOption($this->dmuc::all());
        $DmOpt = $recusive->OptionDanhMuc($id);
        return $DmOpt;
    }
    public function getThuongHieu($id)
    {
        $recusive = new GetOption($this->thuonghieu::all());
        $ThOpt = $recusive->OptionThuongHieu($id);
        return $ThOpt;
    }
    public function getKhuyenMai($id)
    {
        $recusive = new GetOption($this->kmai::all());
        $KmOpt = $recusive->OptionKhuyenMai($id);
        return $KmOpt;
    }

    public function index()
    {
        $page = 5;
        $sp = $this->spham::orderBy('id', 'desc')->paginate($page);
        return view('backend.sanpham.home', compact("sp"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $DmOpt = $this->getDanhMuc('0');
        $ThOpt = $this->getThuongHieu('0');
        $KmOpt = $this->getKhuyenMai('0');
        return view('backend.sanpham.them', compact("DmOpt", "ThOpt", "KmOpt"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'ten_sp' => 'required|max:191|unique:san_phams',
                'num_soluong' => 'required|numeric',
                'num_gia' => 'required|numeric',
                'opt_tagsp' => 'required',
                'opt_th' => 'required',
                'opt_dm' => 'required',
            ],
            [
                'ten_sp.required' => 'Hãy nhập sản phẩm',
                'ten_sp.max' => 'Sản phẩm tối đa 191 ký tự',
                'ten_sp.unique' => 'Sản phẩm đã tồn tại',
                'num_soluong.required' => 'Hãy nhập số lượng',
                'num_soluong.numeric' => 'Số lượng phải là số',
                'num_gia.required' => 'Hãy nhập giá',
                'num_gia.numeric' => 'Giá phải là số',
                'opt_tagsp.required' => 'Hãy nhập tag sản phẩm',
                'opt_th.required' => 'Hãy chọn thương hiệu',
                'opt_dm.required' => 'Hãy nhập danh mục',
            ]
        );
        try {
            DB::beginTransaction();
            if (!empty($request->opt_km)) $km = $request->opt_km;
            else $km = '0';
            if ($request->hasFile('fdaidien')) $hanh = $this->StorageTraitUpload($request, 'fdaidien', 'sanpham');
            $sanpham = $this->spham->create([
                'ten_sp' => trim($request->ten_sp),
                'slug' => Str::slug($request->ten_sp, "-"),
                'hinh_anh_chinh' => implode('', $hanh),
                'mo_ta' => $request->txt_mota,
                'so_luong' => $request->num_soluong,
                'ton' => $request->num_soluong,
                'gia' => $request->num_gia,
                'km_id' => $km,
                'dm_id' => $request->opt_dm,
                'thuong_hieu_id' => $request->opt_th,
                'user_id' => auth()->id(),
            ]);
            //insert image vào bảng hinhanh
            if ($request->hasFile('fchitiet')) {
                foreach ($request->fchitiet as $fItem) {
                    $dataHinhChiTiet = $this->StorageTraitUploadMutiple($fItem, 'sanpham');
                    $sanpham->HinhAnh()->create([
                        'hinh_anh' => $dataHinhChiTiet['file_path'],
                    ]);
                }
            }
            //insert tag vào bảng sp_tag
            $tagId = [];
            if (!empty($request->opt_tagsp)) {
                foreach ($request->opt_tagsp as $tagItem) {
                    $tagsp = $this->tag->firstOrCreate([
                        'ten_tag' => $tagItem
                    ]);
                    $tagId[] = $tagsp->id;
                }
            }
            $sanpham->SanPhamTag()->attach($tagId);
            DB::commit();
            Session::flash('mgs', 'Thêm sản phẩm thành công');
            return redirect()->route('sanpham.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return redirect()->route('sanpham.create');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sp = $this->spham->find($id);
        $htmlOpt = $this->getDanhMuc($sp->dm_id);
        $ThOpt = $this->getThuongHieu($sp->thuong_hieu_id);
        $KmOpt = $this->getKhuyenMai($sp->km_id);
        return view('backend.sanpham.sua', compact('sp', "htmlOpt", "ThOpt", "KmOpt"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_sp' => 'required|max:191',
            'num_soluong' => 'required|numeric|min:0|not_in:0',
            'num_gia' => 'required|numeric',
            'opt_tagsp' => 'required',
            'opt_km' => 'required',
            'opt_th' => 'required',
            'opt_dm' => 'required',
        ], [
            'ten_sp.required' => 'Hãy nhập sản phẩm',
            'ten_sp.max' => 'Sản phẩm tối đa 191 ký tự',
            'num_soluong.required' => 'Hãy nhập số lượng',
            'num_soluong.numeric' => 'Số lượng phải là số',
            'num_soluong.min' => 'Số lượng phải lớn hơn 0',
            'num_soluong.not_in' => 'Số lượng phải khác 0',
            'num_gia.required' => 'Hãy nhập giá',
            'num_gia.numeric' => 'Giá phải là số',
            'opt_tagsp.required' => 'Hãy nhập tag sản phẩm',
            'opt_km.required' => 'Hãy chọn khuyến mãi',
            'opt_th.required' => 'Hãy chọn thương hiệu',
            'opt_dm.required' => 'Hãy nhập danh mục',
        ]);
        try {
            DB::beginTransaction();
            if ($request->hasFile('fdaidien'))
                $hanh = implode('', $this->StorageTraitUpload($request, 'fdaidien', 'sanpham'));
            else
                $hanh = $this->spham->find($id)->hinh_anh_chinh;
            $this->spham->find($id)->update([
                'ten_sp' => trim($request->ten_sp),
                'slug' => Str::slug($request->ten_sp, "-"),
                'hinh_anh_chinh' => $hanh,
                'mo_ta' => $request->txt_mota,
                'so_luong' => $request->num_soluong,
                'ton' => $request->num_soluong,
                'gia' => $request->num_gia,
                'km_id' => $request->opt_km,
                'dm_id' => $request->opt_dm,
                'thuong_hieu_id' => $request->opt_th,
                'user_id' => auth()->id(),
            ]);
            $sanpham = $this->spham->find($id);

            //insert image vào bảng hinhanh
            if ($request->hasFile('fchitiet')) {
                $this->hanh->where('sp_id', $id)->delete();
                foreach ($request->fchitiet as $fItem) {
                    $dataHinhChiTiet = $this->StorageTraitUploadMutiple($fItem, 'sanpham');
                    $sanpham->HinhAnh()->create([
                        'hinh_anh' => $dataHinhChiTiet['file_path'],
                    ]);
                }
            }

            //insert tag vào bảng sp_tag
            $tagId = [];
            if (!empty($request->tags)) {
                foreach ($request->opt_tagsp as $tagItem) {
                    $tag = $this->tag->firstOrCreate([
                        'ten_tag' => $tagItem
                    ]);
                    $tagId[] = $tag->id;
                }
            }
            $this->spham->SanPhamTag()->sync($tagId);
            DB::commit();
            Session::flash('mgs-update', 'Cập nhật sản phẩm thành công');
            return redirect()->route('sanpham.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Session::flash('error', 'Cập nhật sản phẩm thất bại.');
            return redirect()->route('sanpham.edit', ['id' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->deleteModelTrait($id, $this->spham);
    }
}
