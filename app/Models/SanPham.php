<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SanPham extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'san_phams';
    protected $fillable = [
        'ten_sp', 'slug', 'hinh_anh_chinh', 'mo_ta', 'so_luong', 'da_ban', 'ton', 'gia', 'bao_hanh', 'goc_camera', 'chuan_nen', 'do_phan_giai', 'dam_thoai', 'tam_quan_sat', 'tinh_nang', 'nguon_dien', 'luot_xem', 'km_id', 'dm_id', 'thuong_hieu_id',  'user_id',
    ];

    public function DanhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'dm_id', 'id');
    }

    public function ThuongHieu()
    {
        return $this->belongsTo(ThuongHieu::class, 'thuong_hieu_id', 'id');
    }

    public function KhuyenMai()
    {
        return $this->belongsTo(KhuyenMai::class, 'km_id', 'id');
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