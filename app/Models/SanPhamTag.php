<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPhamTag extends Model
{
    use HasFactory;
    protected $table = 'san_pham_tags';
    protected $fillable = [
        'sp_id', 'tag_id',
    ];

    public function SanPham()
    {
        return $this->belongsTo(SanPham::class, 'sp_id', 'id');
    }

    public function Tag()
    {
        return $this->belongsTo(Tag::class, 'tag_id', 'id');
    }
}