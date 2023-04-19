<?php

namespace App\Imports;

use App\Models\HinhAnh;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Components\Traits\StorageImageTrait;

class NhapHinhAnhSP implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    use StorageImageTrait;
    public function model(array $row)
    {
        return new HinhAnh([
            'sp_id' => $row[0],
            'hinh_anh' => $this->StorageTraitImport($row[1], 'sanpham'),
        ]);
    }
}