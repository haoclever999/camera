<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class DanhMuc extends Model
{
    use HasFactory;
    protected $table = 'danh_mucs';
    protected $fillable = [
        'ten_dm', 'slug',
    ];

    public function SanPham()
    {
        return $this->hasMany(SanPham::class, 'dm_id', 'id');
    }
}
