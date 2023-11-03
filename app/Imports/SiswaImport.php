<?php

namespace App\Imports;

use App\Models\Kelas;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class SiswaImport implements ToModel, WithStartRow, WithValidation
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
            'email' => $row[3]
        ]);
    }
    public function rules(): array
    {
        return [
            '0' => 'required|numeric|unique:siswa,nis',
            '1' => 'required|string|max:255',
            '2' => 'required',
            '3' => 'required|email',
        ];
    }
}
