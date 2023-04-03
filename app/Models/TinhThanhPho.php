<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinhThanhPho extends Model
{
    use HasFactory;
    protected $table = 'tinh_thanh_phos';
    protected $fillable = [
        'ten_tp', 'type'
    ];

    public function QuanHuyen()
    {
        return $this->hasMany(QuanHuyen::class, 'id_tp', 'id');
    }
}
