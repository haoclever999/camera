<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;

class XuatDonHang implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    private $dhang;
    public function __construct($data)
    {
        $this->dhang = $data;
    }

    public function collection()
    {
        return $this->dhang;
    }

    public function map($row): array
    {
        return [
            $row->don_hang_id,
            $row->SanPham->ten_sp,
            $row->so_luong_ban,
            $row->gia,
            $row->thue,
            $row->thanh_tien,
            $row->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            "Mã đơn hàng",
            "Tên sản phẩm",
            "Số lượng bán",
            "Giá bán",
            "Thue",
            "Thành tiền",
            "Ngày tạo đơn",
        ];
    }
}
