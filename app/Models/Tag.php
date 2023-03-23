<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'tags';
    protected $fillable = [
        'ten_tag',
    ];

    public function SanPhamTag()
    {
        return $this->belongsToMany(SanPham::class, 'san_pham_tags', 'tag_id', 'sp_id')->withTimestamps();
    }
}