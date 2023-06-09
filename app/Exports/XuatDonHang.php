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

class XuatDonHang implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithTitle, WithEvents
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
            $row->id,
            $row->ten_kh,
            $row->sdt_kh,
            $row->dia_chi_kh,
            $row->tong_so_luong,
            $row->thue,
            $row->tong_tien,
            $row->hinh_thuc,
            $row->ghi_chu,
            $row->trang_thai,
            $row->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            "Mã đơn hàng",
            "Tên khách hàng",
            "Số điện thoại",
            "Địa chỉ khách hàng",
            "Tổng số lượng",
            "Thuế",
            "Tổng tiền",
            "Hình thức thanh toán",
            "Ghi chú",
            "Trạng thái",
            "Ngày tạo đơn",
        ];
    }

    public function title(): string
    {
        return 'Đơn hàng';
    }

    public function registerEvents(): array
    {
        return [
            // Array callable, refering to a static method.
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:K1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ]
                ]);
            }

        ];
    }
}
