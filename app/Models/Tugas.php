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
    // protected $with  = ['kelas', 'nilai'];
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_tugas');
    }
}
