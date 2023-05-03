<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CauHinh extends Model
{
    use HasFactory;
    protected $table = 'cau_hinhs';
    protected $fillable = [
        'ten', 'gia_tri',
    ];
}
