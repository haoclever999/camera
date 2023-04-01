<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHangChiTiet extends Model
{
    use HasFactory;
    protected $table = 'don_hang_chi_tiets';
    protected $fillable = [
        'don_hang_id', 'sp_id', 'so_luong_ban', 'gia', 'thanh_tien',
    ];

    public function SanPham()
    {
        return $this->belongsTo(SanPham::class, 'sp_id', 'id');
    }

    public function DonHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id', 'id');
    }
}
