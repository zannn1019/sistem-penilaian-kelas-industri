<?php

namespace App\Models;

use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;
    protected $guarded = [
        'id'
    ];
    protected $cascadeDeletes = ['nilai_akhir', 'nilai'];
    protected $table = 'siswa';
    protected $dates = ['deleted_at'];
    protected $with = ['nilai_akhir'];
    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'id_sekolah');
    }
    public function nilai_akhir()
    {
        return $this->hasMany(NilaiAkhir::class, 'id_siswa');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_siswa');
    }
}
