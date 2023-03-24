<?php

namespace App\Http\Controllers;

use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class NguoiDungController extends Controller
{
    private $user;
    public function __construct(User $user)
    {
        // $this->middleware('auth');
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id_sua = '0';
        $capnhatquyen = '';
        $page = 10;
        $users = $this->user::orderBy('id', 'desc')->paginate($page);
        return view('backend.nguoidung.home', compact("users", "capnhatquyen", "id_sua"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.nguoidung.them');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            Session::flash('mgs', 'Thêm người dùng thành công');

            return redirect()->route('nguoidung.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return redirect()->route('nguoidung.create');
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
            $user->ho_ten = $ten;
            $user->sdt = $sdt;
            $user->dia_chi = $request->dia_chi;
            $user->save();
            DB::commit();

            // Alert()->success('Post Created', 'Successfully');

            return redirect()->route('admin.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
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
        try {
            DB::beginTransaction();
            $u = $this->user->find($id);
            $u->id = $request->id;
            $u->quyen = $request->opt_quyen;
            $u->save();
            DB::commit();
            return redirect()->route('nguoidung.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return redirect()->route('nguoidung.index');
        }
    }

    public function getcapnhatquyen($id)
    {
        $id_sua = $id;
        $capnhatquyen = 'capnhatquyen';
        $page = 10;
        $users = $this->user::orderBy('id', 'desc')->paginate($page);
        return view('backend.nguoidung.home', compact("users", "capnhatquyen", "id_sua"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function capnhatquyen(Request $request,  $id)
    {
        try {
            DB::beginTransaction();
            $u = $this->user->find($id);
            $u->id = $request->id;
            $u->quyen = $request->opt_quyen;
            $u->save();
            DB::commit();
            return redirect()->route('nguoidung.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
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
            return redirect()->route('nguoidung.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return redirect()->route('nguoidung.index');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
