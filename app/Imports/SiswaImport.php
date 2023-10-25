<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
{
    protected $kelas;

    public function startRow(): int
    {
        return 2;
    }
    public function __construct(Kelas $kelas)
    {
        $this->kelas = $kelas;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Siswa([
            'id_sekolah' => $this->kelas->sekolah->id,
            'id_kelas' => $this->kelas->id,
            'nis'     => $row[0],
            'nama'    => $row[1],
            'no_telp' => $row[2],
        ]);
    }
}
