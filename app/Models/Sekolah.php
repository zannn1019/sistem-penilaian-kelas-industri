<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    protected $guarded =  [
        'id'
    ];
    protected $table = 'sekolah';
    protected $with = ['kelas'];
    public function pengajar()
    {
        return $this->hasMany(Pengajar::class, 'id_sekolah');
    }
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_sekolah');
    }
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_sekolah');
    }
}
