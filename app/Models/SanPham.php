<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SanPham extends Model
{
    use HasFactory;
    protected $table = 'san_phams';
    protected $fillable = [
        'ten_sp', 'slug', 'hinh_anh_chinh', 'mo_ta', 'so_luong', 'gia_nhap', 'gia_ban', 'giam_gia', 'bao_hanh', 'tinh_nang', 'luot_xem', 'luot_mua', 'dm_id', 'thuong_hieu_id',  'user_id',
    ];

    public function DanhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'dm_id', 'id');
    }

    public function ThuongHieu()
    {
        return $this->belongsTo(ThuongHieu::class, 'thuong_hieu_id', 'id');
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function DonHangChiTiet()
    {
        return $this->hasMany(DonHangChiTiet::class, 'sp_id', 'id');
    }

    public function HinhAnh()
    {
        return $this->hasMany(HinhAnh::class, 'sp_id', 'id');
    }

    public function SanPhamTag()
    {
        return $this->belongsToMany(Tag::class, 'san_pham_tags', 'sp_id', 'tag_id')->withTimestamps();
    }
}
