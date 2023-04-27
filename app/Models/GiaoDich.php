<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoDich extends Model
{
    use HasFactory;
    protected $table = 'giao_dichs';
    protected $fillable = [
        'user_id', 'so_tien', 'noi_dung_thanh_toan', 'ma_phan_hoi', 'ma_giao_dich', 'ma_ngan_hang',
    ];
}
