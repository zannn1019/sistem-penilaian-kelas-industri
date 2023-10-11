<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;

class NilaiExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles,
    WithColumnFormatting,
    WithTitle,
    WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $kelas, $heading, $no = 0;
    public function __construct($kelas, array $heading)
    {
        $this->kelas = $kelas;
        $this->heading = $heading;
    }
    public function getNilai($kelas)
    {
        $data_kelas = $kelas;
        $data_siswa = collect([$this->heading]);
        $data_mapel = $kelas->pengajar->pluck('mapel')->flatten();
        $no = 0;
        foreach ($data_kelas->siswa as $siswa) {
            $siswaData = [
                'no' => $no += 1,
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
            ];
            foreach ($data_mapel as $mapel) {
                $nilai = $this->hitungRataRataNilai($mapel, $siswa);
                $siswaData[$mapel->nama_mapel] = $nilai ?? "Belum lengkap";
            }
            $data_siswa->push($siswaData);
        }
        return $data_siswa;
    }


    private function hitungRataRataNilai($mapel, $siswa)
    {
        return $mapel->tugas
            ->where('tahun_ajar', $siswa->kelas->tahun_ajar)
            ->where('semester', $siswa->kelas->semester)
            ->avg(function ($tugas) use ($siswa) {
                return $tugas->nilai
                    ->where('id_siswa', $siswa->id)
                    ->where('tahun_ajar', $siswa->kelas->tahun_ajar)
                    ->where('semester', $siswa->kelas->semester)
                    ->avg('nilai');
            });
    }


    public function collection()
    {
        return $this->getNilai($this->kelas);
    }

    public function title(): string
    {
        return  $this->kelas->tingkat . '-' . $this->kelas->jurusan . '-' . $this->kelas->kelas;
    }

    public function headings(): array
    {
        return $this->heading;
    }
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '25364f'],
                ],
            ],
            2 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '25364f'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $sheet->mergeCells('A1:' . $sheet->getHighestColumn() . '1');
                $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A1')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->setCellValue('A1', "RAPORT KELAS " . strtoupper($this->kelas->tingkat . ' ' . $this->kelas->jurusan . ' ' . $this->kelas->kelas));
                $cellRange = 'A1:' . $sheet->getHighestColumn() . $sheet->getHighestRow();
                $sheet->getDelegate()->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => '###00000',
        ];
    }
}
