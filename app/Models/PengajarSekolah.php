<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajarSekolah extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "pengajar_sekolah";
    protected $dates = ['deleted_at'];
}
