<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;

class DanhMucController extends Controller
{
    use DeleteModelTrait;
    private $dmuc;

    public function __construct(DanhMuc $dmuc)
    {
        // $this->middleware('auth');
        $this->dmuc = $dmuc;
    }

    public function index()
    {
        $page = 10;
        $dm = $this->dmuc::orderBy('id', 'desc')->paginate($page);
        return view('backend.danhmuc.home', compact("dm"))->with('i', (request()->input('page', 1) - 1) * $page);
    }
    public function store(Request $request)
    {
        $request->validate([
            'ten_dm' => 'required|max:191|unique:danh_mucs',

        ], [
            'ten_dm.required' => 'Hãy nhập danh mục',
            'ten_dm.max' => 'Danh mục tối đa 191 ký tự',
            'ten_dm.unique' => 'Danh mục đã tồn tại',
        ]);
        try {
            DB::beginTransaction();
            $this->dmuc->firstOrCreate([
                'ten_dm' => trim($request->ten_dm),
                'slug' => Str::slug($request->ten_dm, "-"),
            ]);
            DB::commit();
            Session::flash('mgs', 'Thêm danh mục thành công');
            return redirect()->route('danhmuc.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return redirect()->route('danhmuc.create');
        }
    }

    public function edit($id)
    {
        $dm = $this->dmuc->find($id);
        return view('backend.danhmuc.sua', compact('dm'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_dm' => 'required|max:191|unique:danh_mucs',

        ], [
            'ten_dm.required' => 'Hãy nhập danh mục',
            'ten_dm.max' => 'Danh mục tối đa 191 ký tự',
            'ten_dm.unique' => 'Danh mục đã tồn tại',

        ]);
        try {
            DB::beginTransaction();
            $dm = $this->dmuc->find($id);
            $dm->id = $request->id;
            $dm->ten_dm = $request->ten_dm;
            $dm->slug = Str::slug($request->ten_dm, "-");
            $dm->save();
            DB::commit();
            Session::flash('mgs-update', 'Cập nhật danh mục thành công');
            return redirect()->route('danhmuc.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return redirect()->route('danhmuc.edit', ['id' => $id]);
        }
    }


    public function destroy($id)
    {
        return $this->deleteModelTrait($id, $this->dmuc);
    }
}
