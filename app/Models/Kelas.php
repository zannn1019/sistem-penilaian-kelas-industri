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
    // protected $with = ['siswa'];

    public function pengajar()
    {
        return $this->belongsToMany(User::class, 'pengajar_sekolah', 'id_kelas', 'id_user');
    }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }
    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'id_kelas');
    }
}
