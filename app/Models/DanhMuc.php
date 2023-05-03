<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DanhMuc extends Model
{
    protected $table = 'danh_mucs';
    protected $fillable = [
        'ten_dm', 'slug', 'trang_thai',
    ];

    public function SanPham()
    {
        return $this->hasMany(SanPham::class, 'dm_id', 'id');
    }
}
