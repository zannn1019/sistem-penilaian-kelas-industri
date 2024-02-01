<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class inputNilaiTugasExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithColumnFormatting,
    WithEvents
{
    protected $kelas;
    public function __construct($kelas)
    {
        $this->kelas = $kelas;
    }

    public function columnFormats(): array
    {
        return [
            'B' => '###00000',
        ];
    }

    public function headings(): array
    {
        $heading = [
            'NO',
            "NIS",
            'Nama Siswa'
        ];
        foreach ($this->kelas->tugas as $tugas) {
            array_push($heading, $tugas->nama);
        }
        return $heading;
    }

    /**
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->getSiswaTugas();
    }

    public function getSiswaTugas()
    {
        $result = collect([]);
        $no = 0;
        $tempt = [];
        $nilai = Nilai::all();
        foreach ($this->kelas->siswa as $siswa) {
            $data_siswa = [];
            //? Push data siswa
            $data_siswa['no'] = ++$no;
            $data_siswa['nis'] = $siswa->nis;
            $data_siswa['nama_siswa'] = $siswa->nama;

            //? Push nilai siswa
            foreach ($this->kelas->tugas as $tugas) {
                $nilai_siswa = $nilai->where('id_tugas', $tugas->id)->where('id_siswa', $siswa->id)->first();
                if ($nilai_siswa) {
                    $data_siswa[$tugas->nama] = $nilai_siswa->nilai;
                } else {
                    $data_siswa[$tugas->nama] = '';
                }
            }

            array_push($tempt, $data_siswa);
        }
        $result->push($tempt);
        return $result;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $cellRange = 'A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow();
                $sheet->getDelegate()->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }
}
