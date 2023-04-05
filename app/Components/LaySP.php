<?php

namespace App\Components;

use App\Models\DanhMuc;
use App\Models\SanPham;
use App\Models\ThuongHieu;

class LaySP
{
    public function getSanPham()
    {
        //danh mục đã xoá
        $d = DanhMuc::select('id')->onlyTrashed()->get();
        if (count($d) > 0) {
            foreach ($d as $value)
                $id_d[] = $value->id;
        } else
            $id_d = [];
        //thương hiệu đã xoá
        $th = ThuongHieu::select('id')->onlyTrashed()->get();
        if (count($th) > 0) {
            foreach ($th as $value)
                $id_t[] = $value->id;
        } else
            $id_t = [];

        $sp = SanPham::whereNotIn('dm_id', $id_d)->whereNotIn('thuong_hieu_id', $id_t);
        return $sp;
    }
}