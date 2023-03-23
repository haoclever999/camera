<?php

namespace App\Http\Controllers;

use App\Models\ThuongHieu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Components\Traits\DeleteModelTrait;

class ThuongHieuController extends Controller
{
    use DeleteModelTrait;
    private $thuonghieu;
    public function __construct(ThuongHieu $thuonghieu)
    {
        // $this->middleware('auth');
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
            $this->thuonghieu->firstOrCreate([
                'ten_thuong_hieu' => trim($request->ten_thuong_hieu),
                'slug' => Str::slug($request->ten_thuong_hieu, "-"),
            ]);
            DB::commit();
            Session::flash('mgs', 'Thêm thương hiệu thành công');
            return redirect()->route('thuonghieu.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return redirect()->route('thuonghieu.create');
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
            $th = $this->thuonghieu->find($id);
            $th->id = $request->id;
            $th->ten_thuong_hieu = $request->ten_thuong_hieu;
            $th->slug = Str::slug($request->ten_thuong_hieu, "-");
            $th->save();
            DB::commit();
            Session::flash('mgs-update', 'Cập nhật thương hiệu thành công');
            return redirect()->route('thuonghieu.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
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
