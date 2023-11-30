<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Sekolah extends Model
{
    use HasFactory, SoftDeletes, Searchable, CascadeSoftDeletes;
    protected $guarded =  [
        'id'
    ];
    protected $cascadeDeletes = ['pengajar', 'kelas', 'siswa'];
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
    public function toSearchableArray()
    {
        return [
            'nama' => $this->nama
        ];
    }
}
