<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use NumberToWords\NumberToWords;

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
    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['tgl'] ?? null,
            fn ($query, $filter) =>
            $query->where('created_at', '>=', date('Y-m-d', strtotime($filter)) . ' 00:00:00')->where('created_at', '<=', date('Y-m-d', strtotime($filter)) . ' 23:59:59')
        );
    }
    public static function siswaAvg(Siswa $siswa)
    {
        $pengajarDikelas = $siswa->kelas->pengajar;
        $nilaiSiswa = collect([]);
        $totalTugas = 0;
        $totalNilai = 0;
        $tugasBelumDinilai = [];
        foreach ($pengajarDikelas->pluck('mapel')->flatten() as $mapel) {
            foreach ($mapel->tugas->where('id_kelas', $siswa->kelas->id) as $tugas) {
                $totalTugas++;
                $nilai = $tugas->nilai->where('id_siswa', $siswa->id)->where('id_siswa', $siswa->id)
                    ->where('tahun_ajar', $siswa->kelas->tahun_ajar)
                    ->where('semester', $siswa->kelas->semester)->first();
                if ($nilai === null) {
                    $tugasBelumDinilai[] = $tugas->nama;
                } else {
                    $totalNilai += $nilai->nilai;
                    $nilaiSiswa->push($nilai->nilai);
                }
            }
        }
        if ($totalTugas == $nilaiSiswa->count()) {
            return $nilaiSiswa->avg();
        }
    }
}
