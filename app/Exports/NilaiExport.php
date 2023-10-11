<?php

namespace App\Exports;

use App\Models\Kelas;
use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class NilaiExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $data, $heading, $no = 0;

    public static function getNilai()
    {
    }

    public function __construct($data, array $heading)
    {
        $this->data = $data;
        $this->heading = $heading;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return $this->heading;
    }

    // public function map($row): array
    // {
    //     $daftar_siswa = $row->siswa;
    //     $data = [];
    //     foreach ($daftar_siswa as $siswa) {
    //         array_push(
    //             $data,
    //             [
    //                 "nis" => strval($siswa->nis),
    //                 "nama" => $siswa->nama
    //             ]
    //         );
    //     }
    //     foreach ($data as $siswa) {
    //         return [
    //             'No' => $this->no += 1,
    //             'nis' => str_replace(',', '', $siswa['nis']),
    //             'nama' => $siswa['nama']
    //         ];
    //     }
    // }
}
