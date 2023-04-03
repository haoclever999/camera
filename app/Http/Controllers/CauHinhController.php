<?php

namespace App\Http\Controllers;

use App\Models\CauHinh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;
use RealRashid\SweetAlert\Facades\Alert;

class CauHinhController extends Controller
{
    use DeleteModelTrait;
    private $cauhinh;
    public function __construct(CauHinh $cauhinh)
    {
        $this->cauhinh = $cauhinh;
    }

    public function index()
    {
        $page = 5;
        $cauhinh = $this->cauhinh::orderBy('cau_hinh_key')->paginate($page);
        return view('backend.cauhinh.home', compact("cauhinh"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cau_hinh_key' => 'required|max:191|unique:cau_hinhs',
            'cau_hinh_value' => 'required|max:191',
        ], [
            'cau_hinh_key.required' => 'Hãy nhập tên cấu hình',
            'cau_hinh_key.max' => 'Tên cấu hình quá dài',
            'cau_hinh_key.unique' => 'Tên cấu hình đã tồn tại',
            'cau_hinh_value.required' => 'Hãy nhập giá trị của cấu hình',
            'cau_hinh_value.max' => 'Giá trị của cấu hình quá dài',

        ]);
        try {
            DB::beginTransaction();
            $this->cauhinh->firstOrCreate([
                'cau_hinh_key' => trim($request->cau_hinh_key),
                'cau_hinh_value' => trim($request->cau_hinh_value),
            ]);
            DB::commit();
            Alert::success('Thành công', 'Thêm cấu hình thành công');
            return redirect()->route('cauhinh.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Thêm cấu hình thất bại');
            return redirect()->route('cauhinh.index');
        }
    }

    public function edit($id)
    {
        $cauhinh = $this->cauhinh->find($id);
        return view('backend.cauhinh.sua', compact('cauhinh'));
    }

    public function update(Request $request, $id)
    {
        if ($request->has('cau_hinh_key')) {
            $request->validate([
                'cau_hinh_key' => 'required|max:191|unique:cau_hinhs',
                'cau_hinh_value' => 'required|max:191',
            ], [
                'cau_hinh_key.required' => 'Hãy nhập tên cấu hình',
                'cau_hinh_key.max' => 'Tên cấu hình quá dài',
                'cau_hinh_key.unique' => 'Tên cấu hình đã tồn tại',
                'cau_hinh_value.required' => 'Hãy nhập giá trị của cấu hình',
                'cau_hinh_value.max' => 'Giá trị của cấu hình quá dài',

            ]);
        } else {
            $request->validate([
                'cau_hinh_key' => 'required|max:191',
                'cau_hinh_value' => 'required|max:191',
            ], [
                'cau_hinh_key.required' => 'Hãy nhập tên cấu hình',
                'cau_hinh_key.max' => 'Tên cấu hình quá dài',
                'cau_hinh_value.required' => 'Hãy nhập giá trị của cấu hình',
                'cau_hinh_value.max' => 'Giá trị của cấu hình quá dài',

            ]);
        }
        try {
            DB::beginTransaction();
            if ($request->has('cau_hinh_key2')) $cau_hinh_key = $request->cau_hinh_key2;
            else $cau_hinh_key = $request->cau_hinh_key;

            $ch = $this->cauhinh->find($id);
            $ch->id = $request->id;
            $ch->cau_hinh_key = trim($cau_hinh_key);
            $ch->cau_hinh_value = trim($request->cau_hinh_value);
            $ch->save();
            DB::commit();
            Alert::success('Thành công', 'Cập nhật cấu hình thành công');
            return redirect()->route('cauhinh.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Cập nhật cấu hình thất bại');
            return redirect()->route('cauhinh.edit', ['id' => $id]);
        }
    }

    public function destroy($id)
    {
        return $this->deleteModelTrait($id, $this->cauhinh);
    }

    public function timkiem(Request $request)
    {
        $page = 5;
        if ($request->cau_hinh == 'cau_hinh_key')
            $timkiem =  $this->cauhinh->where('cau_hinh_key', 'LIKE', '%' . $request->timkiem_th . '%')->orderby('cau_hinh_key')->paginate($page);
        else
            $timkiem =  $this->cauhinh->where('cau_hinh_value', 'LIKE', '%' . $request->timkiem_th . '%')->orderby('cau_hinh_key')->paginate($page);
        return view('backend.cauhinh.timkiem', compact('timkiem'))->with('i', (request()->input('page', 1) - 1) * $page);
    }
}