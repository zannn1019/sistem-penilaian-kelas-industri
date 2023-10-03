<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Kelas extends Model
{
    use HasFactory, SoftDeletes, Searchable;
    protected $guarded = [
        'id'
    ];
    protected $dates = ['deleted_at'];
    // protected $with = ['tugas'];

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
    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'id_kelas');
    }
    public function scopeFilter($query, array $params)
    {
        if ($params['tingkat'] != 'all') {
            $query->when(
                $params['tingkat'] ?? null,
                fn ($query, $tingkat) =>
                $query->where('tingkat', $tingkat)
            );
        }
        if ($params['jurusan'] != 'all') {
            $semuaJurusan = $query->pluck('jurusan')->unique()->values()->all();
            $jurusanUnik = collect($semuaJurusan)->mapWithKeys(function ($jurusan) {
                return [
                    Str::slug($jurusan) => $jurusan,
                ];
            })->toArray();
            $query->when(
                $params['jurusan'] ?? null,
                fn ($query, $jurusan) =>
                $query->where('jurusan', $jurusanUnik[$params['jurusan']])
            );
        }
        if ($params['ajaran'] != 'all') {
            $query->when(
                $params['ajaran'] ?? null,
                fn ($query, $ajaran) =>
                $query->where('tahun_ajar', $ajaran)
            );
        }
        return $query;
    }
    public function toSearchableArray()
    {
        return [
            'nama_kelas' => $this->nama_kelas,
            'tingkat' => $this->tingkat,
            'jurusan' => $this->jurusan,
            'kelas' => $this->kelas
        ];
    }
}
