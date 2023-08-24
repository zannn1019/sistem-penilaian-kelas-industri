<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    // protected $with = ['sekolah', 'pengajar'];

    // public function pengajar()
    // {
    //     return $this->belongsTo(Pengajar::class);
    // }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }
}
