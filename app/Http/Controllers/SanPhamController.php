<?php

namespace App\Http\Controllers;

use App\Components\GetOption;
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
use App\Imports\NhapHinhAnhSP;
use App\Imports\NhapSanPham;
use App\Models\CauHinh;
use App\Models\DonHang;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class SanPhamController extends Controller
{
    use DeleteModelTrait, StorageImageTrait;
    private $dmuc, $hanh, $tag, $spham, $thuonghieu, $cauhinh, $dhang;
    public function __construct(DanhMuc $dmuc, SanPham $spham, HinhAnh $hanh, Tag $tag, ThuongHieu $thuonghieu, CauHinh $cauhinh, DonHang $dhang)
    {
        $this->dmuc = $dmuc;
        $this->hanh = $hanh;
        $this->tag = $tag;
        $this->spham = $spham;
        $this->thuonghieu = $thuonghieu;
        $this->cauhinh = $cauhinh;
        $this->dhang = $dhang;
    }

    // Bắt đầu trang admin
    public function getDanhMuc($id)
    {
        $option = new GetOption($this->dmuc::where('trang_thai', 1));
        $DmOpt = $option->OptionDanhMuc($id);
        return $DmOpt;
    }
    public function getThuongHieu($id)
    {
        $option = new GetOption($this->thuonghieu::where('trang_thai', 1));
        $ThOpt = $option->OptionThuongHieu($id);
        return $ThOpt;
    }

    public function index(Request $request)
    {
        if (Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $sapxep = $request->sapxep;
        $spham = $this->spham->where('trang_thai', 1);
        switch ($sapxep) {
            case 'a_z':
                $spham->orderby('ten_sp');
                break;
            case 'z_a':
                $spham->orderby('ten_sp', 'desc');
                break;
            case 'thap_cao':
                $spham->orderby('gia_ban');
                break;
            case 'cao_thap':
                $spham->orderby('gia_ban', 'desc');
                break;
            default:
                $spham->orderby('id', 'desc');
        }

        $page = 5;
        $sp = $spham->paginate($page)->appends($request->query());
        $dh_moi =  $this->dhang->where('trang_thai', "Đang chờ xử lý")->count();
        return view('backend.sanpham.home', compact('sp', 'dh_moi'))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function chitiet($id)
    {
        if (Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $sp = $this->spham->find($id);
        $dh_moi =  $this->dhang->where('trang_thai', "Đang chờ xử lý")->count();
        return view('backend.sanpham.show', compact('sp', 'dh_moi'));
    }

    public function getThem()
    {
        if (Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $DmOpt = $this->getDanhMuc('0');
        $ThOpt = $this->getThuongHieu('0');
        $dh_moi =  $this->dhang->where('trang_thai', "Đang chờ xử lý")->count();
        return view('backend.sanpham.them', compact('DmOpt', 'ThOpt', 'dh_moi'));
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
        if (Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $sp = $this->spham->find($id);
        $DmOpt = $this->getDanhMuc($sp->dm_id);
        $ThOpt = $this->getThuongHieu($sp->thuong_hieu_id);
        $dh_moi =  $this->dhang->where('trang_thai', "Đang chờ xử lý")->count();
        return view('backend.sanpham.sua', compact('sp', 'DmOpt', 'ThOpt', 'dh_moi'));
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
        if (Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        return $this->deleteModelTrait($id, $this->spham);
    }

    public function timkiem(Request $request)
    {
        if (Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        if ($request->ajax()) {

            $page = 10;
            $spham = $this->spham->where('trang_thai', 1)->where('ten_sp', 'LIKE', '%' . $request->timkiem_sp . '%')->orderby('ten_sp')->paginate($page)->appends($request->query());
            if ($spham->count() > 0) {
                $kq = '';
                $i = (request()->input('page', 1) - 1) * $page;
                foreach ($spham as $s) {
                    $kq .= '<tr>
                        <td>' . ++$i . '</td>
                        <td>' . $s->ten_sp . '</td>
                        <td> <img class="list_sp_img_150" src="' . $s->hinh_anh_chinh . '" /> </td>
                        <td>' . number_format($s->gia_ban, 0, ",", ".") . 'đ</td>
                        <td>' . optional($s->DanhMuc)->ten_dm . '</td>
                        <td>' . optional($s->ThuongHieu)->ten_thuong_hieu . '</td>

                        <td>' . Carbon::createFromFormat("Y-m-d H:i:s", $s->updated_at)->format("H:i:s d/m/Y") . '</td>
                        <td>
                            <a
                                style="
                                    width: 100%;
                                    padding: 3px 8px;
                                    margin: 3px;
                                "
                                class="btn btn-primary"
                                href="' . route("sanpham.chitiet", ["id" => $s->id]) . '"
                            >
                                Chi tiết
                            </a>
                            <br />
                            <a
                                style="
                                    width: 100%;
                                    padding: 3px 8px;
                                    margin: 3px;
                                "
                                class="btn btn-warning"
                                href="' . route("sanpham.getSua", ["id" => $s->id]) . '"
                            >
                                Cập nhật
                            </a>
                            <br />';

                    if (auth()->check() && auth()->user()->quyen == "Quản trị") {
                        $kq .= '
                            <a
                                style="
                                    width: 100%;
                                    padding: 3px 8px;
                                    margin: 3px;
                                "
                                class="btn btn-danger action_del"
                                href=""
                                data-url="' . route("sanpham.xoa", ["id" => $s->id]) . '"
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

    public function nhap_excel()
    {
        try {
            DB::beginTransaction();
            Excel::import(new NhapSanPham, request()->file('file'));
            DB::commit();
            Alert::success('Thành công', 'Nhập sản phẩm thành công');
            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Nhập sản phẩm thất bại');
            return back();
        }
    }

    public function nhap_hinhanh()
    {

        try {
            DB::beginTransaction();
            Excel::import(new NhapHinhAnhSP, request()->file('file_Hinhanh'));
            DB::commit();
            Alert::success('Thành công', 'Nhập hình ảnh thành công');
            return back();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Nhập hình ảnh thất bại');
            return back();
        }
    }
    // Kết thúc trang admin

    // Bắt đầu trang người dùng
    public function getChiTietSanPham(Request $request, $id)
    {
        $dt = $this->cauhinh->where('ten', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('ten', 'Facebook')->first();
        $email = $this->cauhinh->where('ten', 'Email')->first();
        $dc = $this->cauhinh->where('ten', 'Địa chỉ')->first();

        //tăng lượt xem
        $l_xem = $this->spham->find($id);
        $xem = $l_xem->luot_xem;
        $l_xem->update(['luot_xem' => $xem + 1]);

        $dm =  $this->dmuc->where('trang_thai', 1)->orderby('ten_dm', 'asc')->get();
        $sp_chitiet = $this->spham->where('id', $id)->limit(1)->get();
        foreach ($sp_chitiet as $value) {
            $id_dm = $value->dm_id;
            $url_canonical = $request->url();
            $meta_keyword = $value->slug;
            $meta_image = url($value->hinh_anh_chinh);
            $meta_description =  $value->mo_ta;
            $meta_title = $value->ten_sp;
        }

        $sp_lienquan = $this->spham->where('trang_thai', 1)->where('dm_id', $id_dm)->whereNotIn('id', [$id])->get();
        return view('frontend.sanpham_chitiet', compact('dm', 'sp_chitiet', 'sp_lienquan', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dc', 'dt', 'fb', 'email'));
    }

    public function getAllSanPham(Request $request)
    {
        $dt = $this->cauhinh->where('ten', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('ten', 'Facebook')->first();
        $email = $this->cauhinh->where('ten', 'Email')->first();
        $dc = $this->cauhinh->where('ten', 'Địa chỉ')->first();

        //SEO
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';
        $url_canonical = $request->url();

        if ($request->hienthi)
            $hienthi = $request->hienthi;
        else
            $hienthi = 6;

        $sx_sp = $request->sx_sp;
        $loc_gia = $request->gia;
        $spham = $this->spham->where('trang_thai', 1);
        switch ($sx_sp) {
            case 'a_z':
                $spham->orderby('ten_sp')->get();
                break;
            case 'z_a':
                $spham->orderby('ten_sp', 'desc')->get();
                break;
            case 'thap_cao':
                $spham->orderby('gia_ban')->get();
                break;
            case 'cao_thap':
                $spham->orderby('gia_ban', 'desc')->get();
                break;
            default:
                $spham->get();
        }
        switch ($loc_gia) {
            case '1':
                $spham->where('gia_ban', '<', '1000000')->orderby('ten_sp')->get();
                break;
            case '1-3':
                $spham->whereBetween('gia_ban', ['1000000', '3000000'])->orderby('ten_sp', 'desc')->get();
                break;
            case '3-5':
                $spham->whereBetween('gia_ban', ['3000000', '5000000'])->orderby('gia_ban')->get();
                break;
            case '5-8':
                $spham->whereBetween('gia_ban', ['5000000', '8000000'])->orderby('gia_ban', 'desc')->get();
                break;
            case '8-10':
                $spham->whereBetween('gia_ban', ['8000000', '10000000'])->orderby('gia_ban', 'desc')->get();
                break;
            case '10':
                $spham->where('gia_ban', '>', '10000000')->orderby('gia_ban', 'desc')->get();
                break;
            default:
                $spham->get();
        }

        $sp = $spham->paginate($hienthi)->appends($request->query());

        $dm =  $this->dmuc->where('trang_thai', 1)->where('trang_thai', 1)->orderby('ten_dm')->get();
        $th = $this->thuonghieu->where('trang_thai', 1)->orderby('ten_thuong_hieu')->get();

        return view('frontend.sanpham_all', compact('dm', 'sp', 'th', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dc', 'dt', 'fb', 'email'));
    }

    public function timKiemSanPham(Request $request)
    {
        $dt = $this->cauhinh->where('ten', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('ten', 'Facebook')->first();
        $email = $this->cauhinh->where('ten', 'Email')->first();
        $dc = $this->cauhinh->where('ten', 'Địa chỉ')->first();

        //SEO
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';

        if ($request->hienthi)
            $hienthi = $request->hienthi;
        else
            $hienthi = 6;

        $sx_sp = $request->sx_sp;
        $loc_gia = $request->gia;
        $spham = $this->spham->where('trang_thai', 1)->where('ten_sp', 'LIKE', '%' . $request->timkiem . '%');
        switch ($sx_sp) {
            case 'a_z':
                $spham->orderby('ten_sp')->get();
                break;
            case 'z_a':
                $spham->orderby('ten_sp', 'desc')->get();
                break;
            case 'thap_cao':
                $spham->orderby('gia_ban')->get();
                break;
            case 'cao_thap':
                $spham->orderby('gia_ban', 'desc')->get();
                break;
            default:
                $spham->get();
        }
        switch ($loc_gia) {
            case '1':
                $spham->where('gia_ban', '<', '1000000')->orderby('ten_sp')->get();
                break;
            case '1-3':
                $spham->whereBetween('gia_ban', ['1000000', '3000000'])->orderby('ten_sp', 'desc')->get();
                break;
            case '3-5':
                $spham->whereBetween('gia_ban', ['3000000', '5000000'])->orderby('gia_ban')->get();
                break;
            case '5-8':
                $spham->whereBetween('gia_ban', ['5000000', '8000000'])->orderby('gia_ban', 'desc')->get();
                break;
            case '8-10':
                $spham->whereBetween('gia_ban', ['8000000', '10000000'])->orderby('gia_ban', 'desc')->get();
                break;
            case '10':
                $spham->where('gia_ban', '>', '10000000')->orderby('gia_ban', 'desc')->get();
                break;
            default:
                $spham->get();
        }

        $url_canonical = $request->url();
        $dm =  $this->dmuc->where('trang_thai', 1)->orderby('ten_dm')->get();
        $th = $this->thuonghieu->where('trang_thai', 1)->orderby('ten_thuong_hieu')->get();
        $timkiem = $spham->paginate($hienthi)->appends($request->query());
        return view('frontend.sanpham_timkiem', compact('dm', 'th', 'timkiem', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dc', 'dt', 'fb', 'email'));
    }

    public function timKiem_Header(Request $request)
    {
        if ($request->ajax()) {
            $spham = $this->spham->where('trang_thai', 1)->where('ten_sp', 'LIKE', '%' . $request->timkiem_header . '%')->orderby('ten_sp')->get();
            if ($spham->count() > 0) {
                $kq = '';
                $kq .= '<ul style="text-align: left">';
                foreach ($spham as $s) {
                    $kq .= '<li style="margin-bottom: 5px"><a style="color:#000" href="' . route("sanpham.chitiet_sp", [$s->id]) . '">' . $s->ten_sp . ' </a></li>';
                }
                $kq .= '</ul>';
                return Response($kq);
            } else {
                return response()->json(['status' => 'Không tìm thấy',]);
            }
        }
    }

    public function getTagSanPham(Request $request, $tag)
    {
        $dt = $this->cauhinh->where('ten', 'Điện thoại')->first();
        $fb = $this->cauhinh->where('ten', 'Facebook')->first();
        $email = $this->cauhinh->where('ten', 'Email')->first();
        $dc = $this->cauhinh->where('ten', 'Địa chỉ')->first();

        //SEO
        $url_canonical = $request->url();
        $meta_keyword = '';
        $meta_image = '';
        $meta_description = '';
        $meta_title = '';

        $dm =  $this->dmuc->where('trang_thai', 1)->orderby('ten_dm')->get();
        $th = $this->thuonghieu->where('trang_thai', 1)->orderby('ten_thuong_hieu')->get();

        $tags = $this->tag->where('ten_tag', $tag)->first();
        return view('frontend.sanpham_tag', compact('dm', 'tags', 'th', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dc', 'dt', 'fb', 'email'));
    }
    // Kết thúc trang người dùng
}
