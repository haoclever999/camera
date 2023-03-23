<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DanhMuc extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'danh_mucs';
    protected $fillable = [
        'ten_dm', 'slug',
    ];

    public function SanPham()
    {
        return $this->hasMany(SanPham::class, 'dm_id', 'id');
    }
}