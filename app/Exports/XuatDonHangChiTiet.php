<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class XuatDonHangChiTiet implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithTitle, WithEvents
{
    use Exportable;
    /**
     * @return \Illuminate\Support\Collection
     */
    private $dhct;
    public function __construct($data)
    {
        $this->dhct = $data;
    }

    public function collection()
    {
        return $this->dhct;
    }

    public function map($row): array
    {
        return [
            $row->don_hang_id,
            $row->SanPham->ten_sp,
            $row->so_luong_ban,
            $row->gia,
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
            "Thành tiền",
            "Ngày tạo đơn",
        ];
    }

    public function title(): string
    {
        return 'Đơn hàng chi tiết';
    }

    public function registerEvents(): array
    {
        return [
            // Array callable, refering to a static method.
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:F1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ]
                ]);
            }

        ];
    }
}