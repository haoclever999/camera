<?php

namespace App\Http\Controllers;

use App\Models\KhuyenMai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Components\Traits\DeleteModelTrait;
use RealRashid\SweetAlert\Facades\Alert;

class KhuyenMaiController extends Controller
{
    use DeleteModelTrait;
    private $kmai;
    public function __construct(KhuyenMai $kmai)
    {
        // $this->middleware('auth');
        $this->kmai = $kmai;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = 10;
        $km = $this->kmai::orderBy('id', 'desc')->paginate($page);
        return view('backend.khuyenmai.home', compact("km"))->with('i', (request()->input('page', 1) - 1) * $page);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'khuyenmai' => 'required|unique:khuyen_mais',

        ], [
            'khuyenmai.required' => 'Hãy nhập khuyến mãi',
            'khuyenmai.unique' => 'Khuyến mãi đã tồn tại',
        ]);
        try {
            DB::beginTransaction();
            $this->kmai->firstOrCreate([
                'khuyenmai' => trim($request->khuyenmai),
            ]);
            DB::commit();
            Alert::success('Thành công', 'Thêm khuyến mãi thành công');
            return redirect()->route('khuyenmai.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Thêm khuyến mãi thất bại');
            return redirect()->route('khuyenmai.create');
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $km = $this->kmai->find($id);
        return view('backend.khuyenmai.sua', compact('km'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'khuyenmai' => 'required|unique:khuyen_mais',
            ],
            [
                'khuyenmai.required' => 'Hãy nhập khuyến mãi',
                'khuyenmai.unique' => 'Khuyến mãi đã tồn tại',
            ]
        );
        try {
            DB::beginTransaction();
            $km = $this->kmai->find($id);
            $km->id = $request->id;
            $km->khuyenmai = $request->khuyenmai;
            $km->save();
            DB::commit();
            Alert::success('Thành công', 'Cập nhật khuyến mãi thành công');
            return redirect()->route('khuyenmai.index');
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            Alert::error('Thất bại', 'Cập nhật khuyến mãi thất bại');
            return redirect()->route('khuyenmai.edit', ['id' => $id]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        return $this->deleteModelTrait($id, $this->kmai);
    }
}
