<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sekolah extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded =  [
        'id'
    ];
    protected $table = 'sekolah';
    protected $dates = ['deleted_at'];
    // protected $with = ['kelas', 'siswa'];
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
