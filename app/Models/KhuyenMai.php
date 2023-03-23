<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KhuyenMai extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'khuyen_mais';
    protected $fillable = [
        'khuyenmai',
    ];

    public function SanPham()
    {
        return $this->hasMany(SanPham::class, 'km_id', 'id');
    }
}