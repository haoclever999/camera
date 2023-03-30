<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HinhAnh extends Model
{
    use HasFactory;
    protected $table = 'hinh_anhs';
    protected $fillable = [
        'hinh_anh', 'sp_id',
    ];

    public function SanPham()
    {
        return $this->belongsTo(SanPham::class, 'sp_id', 'id');
    }
}
