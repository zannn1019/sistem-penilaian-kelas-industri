<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Sekolah extends Model
{
    use HasFactory;
    protected $guarded =  [
        'id'
    ];
    protected $table = 'sekolah';
    protected $with = ['kelas', 'siswa'];
    public function pengajar()
    {
        return $this->belongsToMany(User::class, 'pengajar_sekolah', 'id_sekolah', 'id_user');
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
