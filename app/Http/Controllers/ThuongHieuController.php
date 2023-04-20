<?php

namespace App\Http\Controllers;

use App\Components\LaySP;
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
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

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
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $page = 5;
        $th = $this->thuonghieu::orderBy('ten_thuong_hieu')->paginate($page);
        return view('backend.thuonghieu.home', compact("th"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function postThem(Request $request)
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

    public function getSua($id)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        $th = $this->thuonghieu->find($id);
        return view('backend.thuonghieu.sua', compact('th'));
    }

    public function postSua(Request $request, $id)
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
            return redirect()->route('thuonghieu.getSua', ['id' => $id]);
        }
    }

    public function xoa($id)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        return $this->deleteModelTrait($id, $this->thuonghieu);
    }

    public function timkiem(Request $request)
    {
        if (!Gate::allows('quyen', "Khách hàng")) {
            return redirect()->route('home.index');
        }
        if ($request->ajax()) {
            $page = 5;
            $timkiem =  $this->thuonghieu->where('ten_thuong_hieu', 'LIKE', '%' . $request->timkiem_th . '%')->orderby('ten_thuong_hieu')->paginate($page);
            if ($timkiem->count() > 0) {
                $kq = '';
                $i = (request()->input('page', 1) - 1) * $page;

                foreach ($timkiem as $th) {
                    $kq .= '<tr>
                        <td>' . ++$i . '</td>
                        <td >' . $th->ten_thuong_hieu . '</td>
                        <td> <img class="list_sp_img_150" src="' . $th->logo . '" alt="HaoNganTelecom" /> </td>
                        <td>' . Carbon::createFromFormat("Y-m-d H:i:s", $th->updated_at)->format("H:i:s d/m/Y") . '</td>
                        <td>
                            <a
                                style="
                                    width: 88px;
                                    padding: 3px 10px;
                                    margin: 3px;
                                "
                                class="btn btn-warning"
                                href="' . route("thuonghieu.getSua", ["id" => $th->id]) . '"
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
                                data-url="' . route("thuonghieu.xoa", ["id" => $th->id]) . '"
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
    // Kết thúc trang admin

    // Bắt đầu trang người dùng
    public function getThuongHieuDanhMuc(Request $request, $id_dm, $slug, $id)
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

        if ($request->hienthi)
            $hienthi = $request->hienthi;
        else
            $hienthi = 6;

        $sx_sp = $request->sx_sp;

        $spham = (new LaySP)->getSanPham()->where('thuong_hieu_id', $id)->where('dm_id', $id_dm);
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

        $sp = $spham->paginate($hienthi);

        $dm =  $this->dmuc->orderby('ten_dm')->get();
        $ten_th = $this->thuonghieu->where('id', $id)->limit(1)->get();
        $ten_dm = $this->dmuc->where('id', $id_dm)->limit(1)->get();

        $spham = (new LaySP)->getSanPham()->where('dm_id', $id_dm)->paginate(6);
        foreach ($spham as $value)
            $id_th[] = $value->thuong_hieu_id;
        $th_sp = $this->thuonghieu->whereIn('id', $id_th)->distinct()->get();
        return view('frontend.thuonghieu_sanpham', compact('dm', 'sp', 'ten_dm', 'ten_th', 'th_sp', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dt', 'fb', 'email'));
    }

    public function getThuongHieuSanPham(Request $request, $slug, $id)
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

        if ($request->hienthi)
            $hienthi = $request->hienthi;
        else
            $hienthi = 6;

        $sx_sp = $request->sx_sp;

        $spham = (new LaySP)->getSanPham()->where('thuong_hieu_id', $id);
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

        $sp = $spham->paginate($hienthi);

        $dm =  $this->dmuc->orderby('ten_dm')->get();
        $ten_th = $this->thuonghieu->where('id', $id)->limit(1)->get();
        $th = $this->thuonghieu->orderby('ten_thuong_hieu')->get();

        return view('frontend.thuonghieu_sanpham', compact('dm', 'sp', 'th', 'ten_th', 'url_canonical', 'meta_keyword', 'meta_image', 'meta_description', 'meta_title', 'dt', 'fb', 'email'));
    }
}