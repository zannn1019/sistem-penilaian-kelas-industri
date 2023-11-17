<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
{
    protected $kelas;
    protected $duplicate = 0;
    protected $dataError = 0;
    protected $success = 0;
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
        if (empty($row[0]) || empty($row[1]) || empty($row[2]) || empty($row[3])) {
            $this->dataError++;
        } else {
            $siswa = Siswa::where('nis', $row[0])->first();

            if ($siswa) {
                $this->duplicate++;
            } else {
                $this->success++;
                return new Siswa([
                    'id_sekolah' => $this->kelas->sekolah->id,
                    'id_kelas'   => $this->kelas->id,
                    'nis'        => $row[0],
                    'nama'       => $row[1],
                    'no_telp'    => $row[2],
                    'email'      => $row[3]
                ]);
            }
        }
    }

    public function getDuplicateData(): int
    {
        return $this->duplicate;
    }

    public function getErrorCount(): int
    {
        return $this->dataError;
    }
    public function getSuccessCount(): int
    {
        return $this->success;
    }
}
