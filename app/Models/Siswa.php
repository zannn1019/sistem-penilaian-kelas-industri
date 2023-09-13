<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $guarded = [
        'id'
    ];
    protected $table = 'siswa';
    // protected $with = ['nilai'];
    // public function sekolah()
    // {
    //     return $this->belongsTo(Sekolah::class, 'id_sekolah');
    // }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_siswa');
    }
}
