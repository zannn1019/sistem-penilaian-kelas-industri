<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $table = 'nilai';
    // protected $with = ['tugas'];
    // public function pengajar()
    // {
    //     return $this->belongsTo(Pengajar::class);
    // }
    // public function tugas()
    // {
    //     return $this->belongsTo(Tugas::class, 'id_tugas');
    // }
}
