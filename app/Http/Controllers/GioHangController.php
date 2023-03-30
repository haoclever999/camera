<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use App\Models\SanPham;
use Illuminate\Http\Request;

class GioHangController extends Controller
{
    private $spham;
    private $dmuc;
    public function __construct(SanPham $spham, DanhMuc $dmuc)
    {
        $this->spham = $spham;
        $this->dmuc = $dmuc;
    }

    public function index()
    {
        //
    }


    public function show(Request $request)
    {
        $dm =  $this->dmuc->where('parent_id', 0)->orderby('ten_dm', 'asc')->get();
        $giohang = $this->spham->where('id', $request->id)->get();
        return view('frontend.giohang.giohang_show', compact('giohang', 'dm'));
    }


    public function store(Request $request)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
