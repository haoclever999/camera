<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ThuongHieu extends Model
{
    use HasFactory;
    protected $table = 'thuong_hieus';
    protected $fillable = [
        'ten_thuong_hieu', 'slug', 'logo',
    ];

    public function SanPham()
    {
        return $this->hasMany(SanPham::class, 'thuong_hieu_id', 'id');
    }
}
