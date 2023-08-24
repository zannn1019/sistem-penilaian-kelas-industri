<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;

    protected $guarded = [
        'id'
    ];
    // public function nilai()
    // {
    //     return $this->hasMany(Nilai::class);
    // }
    // public function pengajar()
    // {
    //     return $this->belongsTo(Pengajar::class, 'id_pengajar');
    // }
}
