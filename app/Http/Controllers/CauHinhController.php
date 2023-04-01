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
        $page = 10;
        $cauhinh = $this->cauhinh::orderBy('id', 'desc')->paginate($page);
        return view('backend.cauhinh.home', compact("cauhinh"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    public function store(Request $request)
    {
        $request->validate([
            'config_key' => 'required|max:191|unique:cau_hinhs',
            'config_value' => 'required|max:191',
        ], [
            'config_key.required' => 'Hãy nhập tên cấu hình',
            'config_key.max' => 'Tên cấu hình quá dài',
            'config_key.unique' => 'Tên cấu hình đã tồn tại',
            'config_value.required' => 'Hãy nhập giá trị của cấu hình',
            'config_value.max' => 'Giá trị của cấu hình quá dài',

        ]);
        try {
            DB::beginTransaction();
            $this->cauhinh->firstOrCreate([
                'config_key' => trim($request->config_key),
                'config_value' => trim($request->config_value),
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
        if ($request->has('config_key')) {
            $request->validate([
                'config_key' => 'required|max:191|unique:cau_hinhs',
                'config_value' => 'required|max:191',
            ], [
                'config_key.required' => 'Hãy nhập tên cấu hình',
                'config_key.max' => 'Tên cấu hình quá dài',
                'config_key.unique' => 'Tên cấu hình đã tồn tại',
                'config_value.required' => 'Hãy nhập giá trị của cấu hình',
                'config_value.max' => 'Giá trị của cấu hình quá dài',

            ]);
        } else {
            $request->validate([
                'config_key' => 'required|max:191',
                'config_value' => 'required|max:191',
            ], [
                'config_key.required' => 'Hãy nhập tên cấu hình',
                'config_key.max' => 'Tên cấu hình quá dài',
                'config_value.required' => 'Hãy nhập giá trị của cấu hình',
                'config_value.max' => 'Giá trị của cấu hình quá dài',

            ]);
        }
        try {
            DB::beginTransaction();
            if ($request->has('config_key2')) $config_key = $request->config_key2;
            else $config_key = $request->config_key;

            $ch = $this->cauhinh->find($id);
            $ch->id = $request->id;
            $ch->config_key = trim($config_key);
            $ch->config_value = trim($request->config_value);
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
}
