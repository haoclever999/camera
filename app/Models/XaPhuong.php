<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XaPhuong extends Model
{
    use HasFactory;
    protected $table = 'xa_phuongs';
    protected $fillable = [
        'ten_xa', 'type', 'id_qh',
    ];

    public function XaPhuong()
    {
        return $this->belongsTo(QuanHuyen::class, 'id_qh', 'id');
    }
}
