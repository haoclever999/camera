<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CauHinh extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'cau_hinhs';
    protected $fillable = [
        'config_key', 'config_value',
    ];
}
