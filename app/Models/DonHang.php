<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DonHang extends Model
{
    use HasFactory;
    protected $table = 'don_hangs';
    protected $fillable = [
        'user_id', 'ten_kh', 'sdt_kh', 'dia_chi_kh', 'tong_so_luong', 'tong_tien', 'hinh_thuc', 'ghi_chu', 'trang_thai',
    ];

    public function DonHangChiTiet()
    {
        return $this->hasMany(DonHangChiTiet::class, 'don_hang_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
