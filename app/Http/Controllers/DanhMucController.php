<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;
use RealRashid\SweetAlert\Facades\Alert;

class DanhMucController extends Controller
{
    use DeleteModelTrait;
    private $dmuc;

    public function __construct(DanhMuc $dmuc)
    {
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
            'ten_dm.max' => 'Danh mục quá dài',
            'ten_dm.unique' => 'Danh mục đã tồn tại',
        ]);
        try {
            DB::beginTransaction();
            $this->dmuc->firstOrCreate([
                'ten_dm' => trim($request->ten_dm),
                'slug' => Str::slug($request->ten_dm, "-"),
            ]);
            DB::commit();
            Alert::success('Thành công', 'Thêm danh mục thành công');
            return redirect()->route('danhmuc.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Thêm danh mục thất bại');
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
            'ten_dm.max' => 'Danh mục quá dài',
            'ten_dm.unique' => 'Danh mục đã tồn tại',
        ]);
        try {
            DB::beginTransaction();
            $dm = $this->dmuc->find($id);
            $dm->id = $request->id;
            $dm->ten_dm = trim($request->ten_dm);
            $dm->slug = Str::slug($request->ten_dm, "-");
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
}
