<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Components\Traits\DeleteModelTrait;
use RealRashid\SweetAlert\Facades\Alert;

class NguoiDungController extends Controller
{
    use DeleteModelTrait;
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    //Bắt đầu trang admin
    public function index()
    {
        $id_sua = '0';
        $capnhatquyen = '';
        $page = 5;
        $users = $this->user::orderBy('ho_ten')->paginate($page);
        return view('backend.nguoidung.home', compact("users", "capnhatquyen", "id_sua"))->with('i', (request()->input('page', 1) - 1) * $page);
    }


    public function getThem()
    {
        return view('backend.nguoidung.them');
    }


    public function postThem(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required|max:191|unique:users',
            'email' => 'required|max:191|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|unique:users',
            'password' => 'required',
            'opt_quyen' => 'required'
        ], [
            'ho_ten.required' => 'Hãy nhập tên người dùng',
            'ho_ten.max' => 'Tên người dùng quá dài',
            'ho_ten.unique' => 'Tên người dùng đã được sử dụng',
            'email.required' => 'Hãy nhập email',
            'email.regex' => 'Email không đúng dạng. VD: abc@gmail.com',
            'email.max' => 'Email quá dài',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Hãy nhập password',
            'opt_quyen.required' => 'Hãy chọn quyền',
        ]);
        try {
            DB::beginTransaction();
            $this->user->firstOrCreate([
                'ho_ten' => trim($request->ho_ten),
                'email' => trim($request->email),
                'password' => bcrypt(trim($request->password)),
                'quyen' => trim($request->opt_quyen),
            ]);
            DB::commit();
            Alert::success('Thành công', 'Thêm người dùng thành công');
            return redirect()->route('nguoidung.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Thêm người dùng thất bại');
            return redirect()->route('nguoidung.getThem');
        }
    }

    public function gethoso($id)
    {
        $user = $this->user->find($id);
        return view('backend.nguoidung.capnhathoso', compact('user'));
    }

    public function posthoso(Request $request, $id)
    {
        if ($request->has('ho_ten') && $request->has('sdt')) {
            $request->validate([
                'ho_ten' => 'required|max:191|unique:users',
                'sdt' => 'required|unique:users',
                'dia_chi' => 'required',
            ], [
                'ho_ten.required' => 'Hãy nhập tên người dùng',
                'ho_ten.max' => 'Tên người dùng quá dài',
                'ho_ten.unique' => 'Tên người dùng đã được sử dụng',
                'sdt.required' => 'Hãy nhập số điện thoại',
                'sdt.unique' => 'Số điện thoại đã được sử dụng',
                'dia_chi.required' => 'Hãy nhập địa chỉ',

            ]);
        } elseif ($request->has('ho_ten')) {
            $request->validate([
                'ho_ten' => 'required|max:191|unique:users',
                'dia_chi' => 'required',
            ], [
                'ho_ten.required' => 'Hãy nhập tên người dùng',
                'ho_ten.max' => 'Tên người dùng quá dài',
                'ho_ten.unique' => 'Tên người dùng đã được sử dụng',
                'dia_chi.required' => 'Hãy nhập địa chỉ',

            ]);
        } elseif ($request->has('sdt')) {
            $request->validate([
                'ho_ten' => 'max:191',
                'sdt' => 'required|unique:users',
                'dia_chi' => 'required|max:191',
            ], [
                'ho_ten.max' => 'Tên người dùng quá dài',
                'sdt.required' => 'Hãy nhập số điện thoại',
                'sdt.unique' => 'Số điện thoại đã được sử dụng',
                'dia_chi.required' => 'Hãy nhập địa chỉ',

            ]);
        } else {
            $request->validate([
                'ten_nd' => 'max:191',
                'dia_chi' => 'required|max:191',
            ], [
                'ten_nd.max' => 'Tên người dùng quá dài',
                'dia_chi.required' => 'Hãy nhập địa chỉ',
            ]);
        }

        try {
            DB::beginTransaction();
            if ($request->has('ten_nd')) $ten = $request->ten_nd;
            else $ten = $request->ho_ten;

            if ($request->has('sodt')) $sdt = $request->sodt;
            else $sdt = $request->sdt;

            $user = $this->user->find($id);
            $user->id = $request->id;
            $user->ho_ten = trim($ten);
            $user->sdt = trim($sdt);
            $user->dia_chi = trim($request->dia_chi);
            $user->save();
            DB::commit();
            Alert::success('Thành công', 'Cập nhật hồ sơ thành công');
            return redirect()->route('admin.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Cập nhật hồ sơ thất bại');
            return redirect()->route('nguoidung.gethoso', ['id' => $id]);
        }
    }

    public function getdoimatkhau($id)
    {
        $user = $this->user->find($id);
        return view('backend.nguoidung.doimatkhau', compact('user'));
    }

    public function postdoimatkhau(Request $request,  $id)
    {
        $request->validate([
            'password' => 'required',
            'password_new' => 'required|different:password',
            'password_confirm' => 'required|same:password_new',
        ], [
            'password.required' => 'Hãy nhập mật khẩu cũ',
            'password_new.required' => 'Hãy nhập mật khẩu mới',
            'password_new.different' => 'Mật khẩu mới phải khác mật khẩu cũ',
            'password_confirm.required' => 'Hãy nhập lại mật khẩu mới',
            'password_confirm.same' => 'Nhập lại mật khẩu và mật khẩu mới phải giống nhau',
        ]);
        try {
            DB::beginTransaction();
            $u = $this->user->find($id);
            if (Hash::check($request->password, $u->password)) {
                $u->update([
                    'password' => Hash::make($request->password_new)
                ]);
                DB::commit();
                Alert::success('Thành công', 'Mật khẩu đã được thay đổi');
                return redirect()->route('nguoidung.index');
            } else {
                Alert::error('Thất bại', 'Mật khẩu cũ không đúng');
                return redirect()->route('nguoidung.getdoimatkhau', ['id' => $id]);
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Đổi mật khẩu thất bại');
            return redirect()->route('nguoidung.getdoimatkhau', ['id' => $id]);
        }
    }

    public function getcapnhatquyen($id)
    {
        $id_sua = $id;
        $capnhatquyen = 'capnhatquyen';
        $page = 5;
        $users = $this->user::orderBy('ho_ten')->paginate($page);
        return view('backend.nguoidung.home', compact("users", "capnhatquyen", "id_sua"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function postcapnhatquyen(Request $request,  $id)
    {
        try {
            DB::beginTransaction();
            $u = $this->user->find($id);
            $u->id = $request->id;
            $u->quyen = $request->opt_quyen;
            $u->save();
            DB::commit();
            Alert::success('Thành công', 'Cập nhật quyền thành công');
            return redirect()->route('nguoidung.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Cập nhật quyền thất bại');
            return redirect()->route('nguoidung.index');
        }
    }

    public function trangthai(Request $request,  $id)
    {
        try {
            DB::beginTransaction();
            $u = $this->user->find($id);
            $u->id = $request->id;
            $u->trang_thai = $request->khoa;
            $u->save();
            DB::commit();
            Alert::success('Thành công', 'Thay đổi trạng thái tài khoản thành công');
            return redirect()->route('nguoidung.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Thay đổi trạng thái tài khoản thất bại');
            return redirect()->route('nguoidung.index');
        }
    }

    public function xoa($id)
    {
        return $this->deleteModelTrait($id, $this->user);
    }
    public function timkiem(Request $request)
    {
        $id_sua = '0';
        $capnhatquyen = '';
        $page = 5;
        $timkiem =  $this->user->where('ho_ten', 'LIKE', '%' . $request->timkiem_nd . '%')->orderby('ho_ten')->paginate($page);
        return view('backend.nguoidung.timkiem', compact('timkiem', "capnhatquyen", "id_sua"))->with('i', (request()->input('page', 1) - 1) * $page);
    }
    // Kết thúc trang admin 

    //Bắt đầu trang user

}
