<?php

namespace App\Imports;

use App\Models\Nilai;
use App\Models\Siswa;
use App\Models\Tugas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;


class InputNilaiSiswaImport implements ToModel, WithStartRow
{
    protected $mapel, $kelas, $tugas = [];
    public function __construct($kelas, $mapel)
    {
        $this->mapel = $mapel;
        $this->kelas = $kelas;
    }

    public function startRow(): int
    {
        return 1;
    }
    public function model(array $row)
    {
        $nis = $row[1];
        $nilai = [];

        // ? Ambil id tugas dan nilai siswa
        for ($i = 3; $i < count($row); $i++) {
            $id_tugas = Tugas::all()->where("nama", $row[$i]);
            if ($id_tugas->count() != 0) {
                array_push($this->tugas, $id_tugas->first()->id);
            } else {
                array_push($nilai, $row[$i]);
            }
        }

        // ? Update/Create nilai siswa
        $siswa = Siswa::where('nis', $nis)->first();
        if ($siswa) {
            $id_siswa = $siswa->id;
            $check_nilai = Nilai::where('id_siswa', $id_siswa)->get();
            foreach ($this->tugas as $index => $tugas) {
                $nilaiTugas = ($nilai[$index] >= 0 && $nilai[$index] <= 100) ? $nilai[$index] : null;
                $nilaiSiswa = $check_nilai->where('id_tugas', $tugas)->first();
                if ($nilaiSiswa) {
                    $nilaiSiswa->update([
                        'nilai' => $nilaiTugas,
                    ]);
                } else {
                    if ($nilaiTugas !== null) {
                        Nilai::create([
                            'id_siswa' => $id_siswa,
                            'id_tugas' => $tugas,
                            'nilai' => $nilaiTugas,
                            'tahun_ajar' => $this->kelas->tahun_ajar,
                            'semester' => $this->kelas->semester,
                        ]);
                    }
                }
            }
        }
    }
}
