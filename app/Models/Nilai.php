<?php

namespace App\Models;

use Carbon\Carbon;
use NumberToWords\NumberToWords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nilai extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [
        'id'
    ];
    protected $table = 'nilai';
    protected $dates = ['deleted_at'];
    protected $with = ['tugas', 'siswa'];
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }
    public function tugas()
    {
        return $this->belongsTo(Tugas::class, 'id_tugas');
    }

    public function getHurufNilai(int $nilai)
    {
        return NumberToWords::transformNumber('id', $nilai);
    }

    public function scopeFilterByTgl($query, $tgl)
    {
        if ($tgl) {
            return $query->where('created_at', '>=', date('Y-m-d', strtotime($tgl)) . ' 00:00:00')->where('created_at', '<=', date('Y-m-d', strtotime($tgl)) . ' 23:59:59');
        }
        return $query;
    }

    public function scopeFilterBySekolah($query, $sekolah)
    {
        if ($sekolah) {
            return $query->whereHas('siswa', function ($q) use ($sekolah) {
                $q->where('id_sekolah', $sekolah);
            });
        }
        return $query;
    }

    public function scopeFilterByKelas($query, $kelas)
    {
        if ($kelas) {
            return $query->whereHas('siswa', function ($q) use ($kelas) {
                $q->where('id_kelas', $kelas);
            });
        }
        return $query;
    }

    public function scopeFilterBySemester($query, $semester)
    {
        if ($semester) {
            return $query->where('semester', $semester);
        }
        return $query;
    }

    public function scopeFilterByTugas($query, $tugas)
    {
        if ($tugas) {
            return $query->where('id_tugas', $tugas);
        }
        return $query;
    }

    public function getTimeElapsedAttribute()
    {
        $timestamp = $this->created_at;
        $now = Carbon::now();
        $diff = $timestamp->diffForHumans($now);

        return $diff;
    }

    public static function siswaAvg(Siswa $siswa)
    {
        $pengajarDikelas = $siswa->kelas->pengajar;
        $nilaiSiswa = collect([]);
        $totalTugas = 0;
        $totalNilai = 0;
        $tugasBelumDinilai = [];

        foreach ($pengajarDikelas->pluck('mapel')->flatten() as $mapel) {
            $nilaiMapel = collect([]);
            $totalTugasMapel = 0;

            foreach ($mapel->tugas->where('id_kelas', $siswa->kelas->id) as $tugas) {
                $totalTugas++;
                $totalTugasMapel++;
                $nilai = $tugas->nilai->where('id_siswa', $siswa->id)
                    ->where('tahun_ajar', $siswa->kelas->tahun_ajar)
                    ->where('semester', $siswa->kelas->semester)
                    ->first();

                if ($nilai === null) {
                    $tugasBelumDinilai[] = $tugas->nama;
                } else {
                    $totalNilai += $nilai->nilai;
                    $nilaiMapel->push($nilai->nilai);
                }
            }

            if ($totalTugasMapel > 0) {
                $rataRataMapel = $nilaiMapel->avg();
                $nilaiSiswa->push($rataRataMapel);
            }
        }

        if ($totalTugas > 0) {
            return $nilaiSiswa->avg();
        }
    }
}
