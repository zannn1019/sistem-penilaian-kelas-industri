<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajar extends Model
{
    use HasFactory;
    protected $guarded = [
        "id"
    ];
    protected $table = 'pengajar';

    protected $with = ['sekolah', 'kelas'];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'id_user');
    // }
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id');
    }
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }
    // public function mapel()
    // {
    //     return $this->belongsTo(Mapel::class, 'id_mapel');
    // }
    // public function nilai()
    // {
    //     return $this->hasMany(Nilai::class, 'id_pengajar');
    // }
    // public function tugas()
    // {
    //     return $this->hasMany(Tugas::class);
    // }
}
