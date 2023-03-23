<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        $page = 5;
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
        //
    }

    public function getcapnhatquyen($id)
    {
        $id_sua = $id;
        $capnhatquyen = 'capnhatquyen';
        $page = 5;
        $users = $this->user::orderBy('id', 'desc')->paginate($page);
        return view('backend.nguoidung.home', compact("users", "capnhatquyen", "id_sua"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function capnhatquyen(Request $request,  $id)
    {
        dd([$request, $id]);
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
