<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuanHuyen extends Model
{
    use HasFactory;
    protected $table = 'quan_huyens';
    protected $fillable = [
        'ten_qh', 'type', 'id_tp',
    ];

    public function XaPhuong()
    {
        return $this->hasMany(XaPhuong::class, 'id_qh', 'id');
    }

    public function TinhTP()
    {
        return $this->belongsTo(TinhThanhPho::class, 'id_tp', 'id');
    }
}
