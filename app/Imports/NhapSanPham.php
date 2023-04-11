<?php

namespace App\Imports;

use App\Models\SanPham;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Str;
use App\Components\Traits\StorageImageTrait;

class NhapSanPham implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use StorageImageTrait;
    public function model(array $row)
    {

        return new SanPham([

            'ten_sp' => trim($row[0]),
            'slug' => Str::slug($row[0], '-'),
            'hinh_anh_chinh' => $this->StorageTraitImport(strchr($row[1], "."), 'sanpham'),
            'mo_ta' => trim($row[2]),
            'so_luong' => trim($row[3]),
            'gia_nhap' => trim($row[4]),
            'gia_ban' => trim($row[5]),
            'giam_gia' => trim($row[6]) || '0',
            'bao_hanh' => trim($row[7]),
            'tinh_nang' => trim($row[8]),
            'dm_id' => trim($row[9]),
            'thuong_hieu_id' => trim($row[10]),
            'user_id' => auth()->id(),
        ]);
    }
}
