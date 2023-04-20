<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class XuatDonHangMultiple implements WithMultipleSheets
{

    private $dhang, $dhct;
    public function __construct($dhang, $dhct)
    {
        $this->dhang = $dhang;
        $this->dhct = $dhct;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function sheets(): array
    {
        $sheet = [
            new XuatDonHang($this->dhang),
            new XuatDonHangChiTiet($this->dhct),
        ];

        return $sheet;
    }
}
