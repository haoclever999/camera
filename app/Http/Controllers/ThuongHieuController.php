<?php

namespace App\Http\Controllers;

use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;
use App\Components\Traits\StorageImageTrait;
use RealRashid\SweetAlert\Facades\Alert;

class ThuongHieuController extends Controller
{
    use DeleteModelTrait, StorageImageTrait;
    private $thuonghieu;
    public function __construct(ThuongHieu $thuonghieu)
    {
        $this->thuonghieu = $thuonghieu;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = 10;
        $th = $this->thuonghieu::orderBy('id', 'desc')->paginate($page);
        return view('backend.thuonghieu.home', compact("th"))->with('i', (request()->input('page', 1) - 1) * $page);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $th = $this->thuonghieu->find($id);
        return view('backend.thuonghieu.sua', compact('th'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
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
            return redirect()->route('thuonghieu.edit', ['id' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->deleteModelTrait($id, $this->thuonghieu);
    }
}
