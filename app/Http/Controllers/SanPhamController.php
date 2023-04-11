<?php

namespace App\Http\Controllers;

use App\Components\GetOption;
use App\Components\LaySP;
use App\Models\DanhMuc;
use App\Models\HinhAnh;
use App\Models\SanPham;
use App\Models\ThuongHieu;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Components\Traits\StorageImageTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;
use App\Imports\NhapSanPham;
use App\Models\CauHinh;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;


class SanPhamController extends Controller
{
    use DeleteModelTrait, StorageImageTrait;
    private $dmuc, $hanh, $tag, $spham, $thuonghieu, $cauhinh;
    public function __construct(DanhMuc $dmuc, SanPham $spham, HinhAnh $hanh, Tag $tag, ThuongHieu $thuonghieu, CauHinh $cauhinh)
    {
        $this->dmuc = $dmuc;
        $this->hanh = $hanh;
        $this->tag = $tag;
        $this->spham = $spham;
        $this->thuonghieu = $thuonghieu;
        $this->cauhinh = $cauhinh;
    }

    // Bắt đầu trang admin
    public function getDanhMuc($id)
    {
        $option = new GetOption($this->dmuc::all());
        $DmOpt = $option->OptionDanhMuc($id);
        return $DmOpt;
    }
    public function getThuongHieu($id)
    {
        $option = new GetOption($this->thuonghieu::all());
        $ThOpt = $option->OptionThuongHieu($id);
        return $ThOpt;
    }

    public function index()
    {
        $page = 5;
        $sp = (new LaySP)->getSanPham()->orderBy('ten_sp')->paginate($page);
        return view('backend.sanpham.home', compact('sp'))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function chitiet($id)
    {
        $sp = $this->spham->find($id);
        return view('backend.sanpham.show', compact('sp'));
    }

    public function getThem()
    {
        $DmOpt = $this->getDanhMuc('0');
        $ThOpt = $this->getThuongHieu('0');
        return view('backend.sanpham.them', compact('DmOpt', 'ThOpt'));
    }

    public function postThem(Request $request)
    {
        $request->validate(
            [
                'ten_sp' => 'required|max:191|unique:san_phams',
                'num_gia_ban' => 'gt:num_gia_nhap',
            ],
            [
                'ten_sp.required' => 'Hãy nhập sản phẩm',
                'ten_sp.max' => 'Tên sản phẩm quá dài',
                'ten_sp.unique' => 'Sản phẩm đã tồn tại',
                'num_gia_ban.gt' => 'Giá bán phải lớn hơn giá nhập',
            ]
        );
        try {
            DB::beginTransaction();
            if ($request->hasFile('fdaidien')) $hanh = $this->StorageTraitUpload($request, 'fdaidien', 'sanpham');
            $sanpham = $this->spham->create([
                'ten_sp' => trim($request->ten_sp),
                'slug' => Str::slug($request->ten_sp, '-'),
                'hinh_anh_chinh' => $hanh,
                'mo_ta' => $request->txt_mo_ta,
                'so_luong' => $request->num_so_luong,
                'gia_nhap' => $request->num_gia_nhap,
                'gia_ban' => $request->num_gia_ban,
                'giam_gia' => $request->num_giam_gia,
                'bao_hanh' => $request->num_bao_hanh,
                'tinh_nang' => $request->txt_tinh_nang,
                'dm_id' => $request->opt_dm,
                'thuong_hieu_id' => $request->opt_th,
                'user_id' => auth()->id(),
            ]);
            //insert image vào bảng hinhanh
            if ($request->hasFile('fchitiet')) {
                foreach ($request->fchitiet as $fItem) {
                    $dataHinhChiTiet = $this->StorageTraitUploadMutiple($fItem, 'sanpham');
                    $sanpham->HinhAnh()->create([
                        'hinh_anh' => $dataHinhChiTiet,
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
            Alert::success('Thành công', 'Thêm sản phẩm thành công');
            return redirect()->route('sanpham.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Thêm sản phẩm thất bại');
            return redirect()->route('sanpham.getThem');
        }
    }

    public function getSua($id)
    {
        $sp = $this->spham->find($id);
        $DmOpt = $this->getDanhMuc($sp->dm_id);
        $ThOpt = $this->getThuongHieu($sp->thuong_hieu_id);

        return view('backend.sanpham.sua', compact('sp', 'DmOpt', 'ThOpt'));
    }

    public function postSua(Request $request, $id)
    {
        if ($request->has('ten_sp')) {
            $request->validate(
                [
                    'ten_sp' => 'required|max:191|unique:san_phams',
                    'num_gia_ban' => 'gt:num_gia_nhap',
                ],
                [
                    'ten_sp.required' => 'Hãy nhập sản phẩm',
                    'ten_sp.max' => 'Tên sản phẩm quá dài',
                    'ten_sp.unique' => 'Sản phẩm đã tồn tại',
                    'num_gia_ban.gt' => 'Giá bán phải lớn hơn giá nhập',
                ]
            );
        } else {

            $request->validate(
                [
                    'ten_spham' => 'required|max:191',
                    'num_gia_ban' => 'gt:num_gia_nhap',
                ],
                [
                    'ten_spham.required' => 'Hãy nhập sản phẩm',
                    'ten_spham.max' => 'Tên sản phẩm quá dài',
                    'num_gia_ban.gt' => 'Giá bán phải lớn hơn giá nhập',
                ]
            );
        }
        try {
            DB::beginTransaction();
            $sanpham = $this->spham->find($id);

            if ($request->hasFile('fdaidien')) $hanh = $this->StorageTraitUpload($request, 'fdaidien', 'sanpham');
            else $hanh = $sanpham->hinh_anh_chinh;

            if ($request->has('ten_spham')) $ten_sp = $request->ten_spham;
            else $ten_sp = $request->ten_sp;

            if (!empty($request->num_so_luong)) $sluong = $sanpham->so_luong + $request->num_so_luong;
            else $sluong = $sanpham->so_luong;

            $sanpham->update([
                'ten_sp' => trim($ten_sp),
                'slug' => Str::slug($ten_sp, '-'),
                'hinh_anh_chinh' => $hanh,
                'mo_ta' => $request->txt_mo_ta,
                'so_luong' => $sluong,

                'gia_nhap' => $request->num_gia_nhap,
                'gia_ban' => $request->num_gia_ban,
                'giam_gia' => $request->num_giam_gia,
                'bao_hanh' => $request->num_bao_hanh,
                'tinh_nang' => $request->txt_tinh_nang,
                'dm_id' => $request->opt_dm,
                'thuong_hieu_id' => $request->opt_th,
                'user_id' => auth()->id(),
            ]);

            //insert image vào bảng hinhanh
            if ($request->hasFile('fchitiet')) {
                $this->hanh->where('sp_id', $id)->delete();
                foreach ($request->fchitiet as $fItem) {
                    $dataHinhChiTiet = $this->StorageTraitUploadMutiple($fItem, 'sanpham');
                    $sanpham->HinhAnh()->create([
                        'hinh_anh' => $dataHinhChiTiet,
                    ]);
                }
            }

            //insert tag vào bảng sp_tag
            $tagId = [];
            if (!empty($request->opt_tagsp)) {
                foreach ($request->opt_tagsp as $tagItem) {
                    $tag = $this->tag->firstOrCreate([
                        'ten_tag' => $tagItem
                    ]);
                    $tagId[] = $tag->id;
                }
            }

            $sanpham->SanPhamTag()->sync($tagId);
            DB::commit();
            Alert::success('Thành công', 'Cập nhật sản phẩm thành công');
            return redirect()->route('sanpham.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Cập nhật sản phẩm thất bại');
            return redirect()->route('sanpham.getSua', ['id' => $id]);
        }
    }

    public function xoa($id)
    {
        return $this->deleteModelTrait($id, $this->spham);
    }

    public function timkiem(Request $request)
    {
        $th = $this->thuonghieu->where('ten_thuong_hieu ', 'LIKE', '%' . $request->timkiem_sp . '%');
        $dm = $this->dmuc->where('dm_id ', 'LIKE', '%' . $request->timkiem_sp . '%');
        $page = 5;
        if ($request->san_pham == 'ten_sp')
            $timkiem =  (new LaySP)->getSanPham()->where('ten_sp', 'LIKE', '%' . $request->timkiem_sp . '%')->orderby('ten_sp')->paginate($page);
        elseif ($request->san_pham == 'danh_muc')
            $timkiem =  (new LaySP)->getSanPham()->where('dm_id ', $dm->id)->orderby('dm_id')->paginate($page);
        else
            $timkiem =  (new LaySP)->getSanPham()->where('thuong_hieu_id', $th->id)->orderby('thuong_hieu_id')->paginate($page);
        return view('backend.sanpham.timkiem', compact('timkiem'))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function nhap_excel()
    {
        Excel::import(new NhapSanPham, request()->file('file'));
        return back();
    }
    // Kết thúc trang admin

    // Bắt đầu trang người dùng
    public function getChiTietSanPham(Request $request, $id)
    {
        $dt = $this->cauhinh->where('cau_hinh_key', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('cau_hinh_key', 'Facebook')->first();
        $email = $this->cauhinh->where('cau_hinh_key', 'Email')->first();

        //tăng lượt xem
        $l_xem = $this->spham->find($id);
        $xem = $l_xem->luot_xem;
        $l_xem->update(['luot_xem' => $xem + 1]);

        $dm =  $this->dmuc->orderby('ten_dm', 'asc')->get();
        $sp_chitiet = $this->spham->where('id', $id)->limit(1)->get();
        foreach ($sp_chitiet as $value) {
            $id_dm = $value->dm_id;
            $url_canonical = $request->url();
            $meta_keyword = $value->slug;
            $meta_image = url($value->hinh_anh_chinh);
            $meta_description =  $value->mo_ta;
            $meta_title = $value->ten_sp;
        }

        //SEO

        $sp_lienquan = (new LaySP)->getSanPham()->where('dm_id', $id_dm)->whereNotIn('id', [$id])->get();
        return view('frontend.sanpham_chitiet', compact('dm', 'sp_chitiet', 'sp_lienquan', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dt', 'fb', 'email'));
    }

    public function getAllSanPham(Request $request)
    {
        $dt = $this->cauhinh->where('cau_hinh_key', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('cau_hinh_key', 'Facebook')->first();
        $email = $this->cauhinh->where('cau_hinh_key', 'Email')->first();

        //SEO
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';

        $url_canonical = $request->url();
        $dm =  $this->dmuc->orderby('ten_dm')->get();
        $th = $this->thuonghieu->orderby('ten_thuong_hieu')->get();
        $sp = (new LaySP)->getSanPham()->orderBy('ten_sp')->paginate(12);
        return view('frontend.sanpham_all', compact('dm', 'sp', 'th', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dt', 'fb', 'email'));
    }

    public function timKiemSanPham(Request $request)
    {
        $dt = $this->cauhinh->where('cau_hinh_key', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('cau_hinh_key', 'Facebook')->first();
        $email = $this->cauhinh->where('cau_hinh_key', 'Email')->first();

        //SEO
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';

        $url_canonical = $request->url();
        $dm =  $this->dmuc->orderby('ten_dm')->get();
        $th = $this->thuonghieu->orderby('ten_thuong_hieu')->get();
        $timkiem = (new LaySP)->getSanPham()->where('ten_sp', 'LIKE', '%' . $request->timkiem . '%')->paginate(12);;
        return view('frontend.sanpham_timkiem', compact('dm', 'th', 'timkiem', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dt', 'fb', 'email'));
    }

    public function getTagSanPham($tag)
    {
        return $tag;
    }
    // Kết thúc trang người dùng
}
