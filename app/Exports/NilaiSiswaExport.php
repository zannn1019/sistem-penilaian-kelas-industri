<?php

namespace App\Exports;

use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\PengajarMapel;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use NumberToWords\NumberToWords;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiSiswaExport implements
    FromCollection,
    WithEvents,
    WithStyles,
    WithHeadings,
    ShouldAutoSize,
    WithTitle
{
    protected $data_siswa;
    public function __construct($siswa)
    {
        $this->data_siswa = $siswa;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function title(): string
    {
        return $this->data_siswa->nama;
    }
    public function headings(): array
    {
        return [
            [
                strtoupper($this->data_siswa->kelas->sekolah->nama),
            ],
            [
                strtoupper($this->data_siswa->nama),
            ],
            [
                strtoupper($this->data_siswa->kelas->tingkat . '-' . $this->data_siswa->kelas->jurusan . '-' . $this->data_siswa->kelas->kelas . ' semester ' . $this->data_siswa->kelas->semester . ' (' . $this->data_siswa->kelas->tahun_ajar . ')'),
            ],
            [
                'No',
                'Mata Pelajaran',
                'Nilai',
                "Huruf",
                'Deskripsi'
            ]
        ];
    }
    public static function ExportNilaiSiswa($siswa)
    {
        $kelas = $siswa->kelas;
        $mapelIds = PengajarMapel::whereIn('id_user', $kelas->pengajar->pluck('id')->toArray())
            ->pluck('id_mapel')
            ->toArray();
        $daftar_mapel = Mapel::whereIn('id', $mapelIds)->get();
        $result = collect([]);
        $no = 0;

        // Loop melalui daftar mata pelajaran
        foreach ($daftar_mapel as $mapel) {
            $nilaiKosong = false;
            $totalNilai = 0;
            $totalTugas = 0;
            $tugasBelumDinilai = [];
            $daftar_tugas = [];

            // Loop melalui tugas dalam mata pelajaran
            foreach ($mapel->tugas
                ->where('id_kelas', $kelas->id)
                ->where('tahun_ajar', $kelas->tahun_ajar)
                ->where('semester', $kelas->semester)
                as $tugas) {
                $nilai = $tugas->nilai
                    ->where('id_siswa', $siswa->id)
                    ->where('tahun_ajar', $siswa->kelas->tahun_ajar)
                    ->where('semester', $siswa->kelas->semester)
                    ->first();
                if ($nilai === null) {
                    $nilaiKosong = true;
                    $tugasBelumDinilai[] = $tugas->nama;
                    $nilaiHuruf = "-";
                } else {
                    $totalNilai += $nilai->nilai;
                    $totalTugas++;
                    $nilaiHuruf = NumberToWords::transformNumber('id', $nilai->nilai);
                }

                $daftar_tugas[] = [
                    'no' => '',
                    'nama_tugas' => strtoupper($tugas->nama),
                    'nilai' => $nilai->nilai ?? '-',
                    'huruf' => strtoupper($nilaiHuruf) ?? '-',
                    'deskripsi' => $nilaiKosong ? "Belum dinilai" : ""
                ];
            }

            // Hitung nilai rata-rata atau gunakan tanda - jika nilai kosong
            $avgNilai = $nilaiKosong ? '-' : number_format($totalTugas > 0 ? $totalNilai / $totalTugas : 0);
            $isKosong = $nilaiKosong ? 'belum_dinilai' : 'dinilai';

            // Simpan informasi mata pelajaran di indeks ke-0
            if ($avgNilai != '-') {
                $deskripsi = $mapel->tugas->where('tahun_ajar', $kelas->tahun_ajar)->where('semester', $kelas->semester)->avg(function ($tugas) use ($siswa) {
                    return $tugas->nilai->where('id_siswa', $siswa->id)->where('tahun_ajar', $siswa->kelas->tahun_ajar)->where('semester', $siswa->kelas->semester)->avg('nilai');
                }) <= 75
                    ? 'Nilai kurang'
                    : 'Terlampaui';
            } else {
                $deskripsi = "Belum lengkap";
            }
            $mapelInfo = [
                'no' => $no += 1,
                'mapel' =>  strtoupper($mapel->nama_mapel),
                'nilai' => $avgNilai,
                'huruf' => $isKosong == "belum_dinilai" ?  "-"  : strtoupper(NumberToWords::transformNumber('id', $avgNilai)),
                'deskripsi' => $deskripsi
            ];

            $tugasInfo = $daftar_tugas;

            $result->push($mapelInfo);
            foreach ($tugasInfo as $tugas) {
                $result->push($tugas);
            }
        }
        $nilai_akhir = $siswa->nilai_akhir()->where('tahun_ajar', $kelas->tahun_ajar)->where('semester', $kelas->semester)->first()->nilai;
        $nilaiMapel = [
            "#",
            "Nilai Mapel",
            $avgNilai,
            strtoupper(NumberToWords::transformNumber('id', $avgNilai)) ?? "-",
        ];
        $result->push($nilaiMapel);
        $nilaiAkhir = [
            "#",
            "Nilai Akhir",
            $nilai_akhir ?? "-",
            strtoupper(NumberToWords::transformNumber('id', $nilai_akhir)) ?? "-",
        ];
        $result->push($nilaiAkhir);
        $nilaiTambah = [
            "#",
            "Nilai Tambahan",
            ($avgNilai / 10) + (70 - $nilai_akhir),
            strtoupper(NumberToWords::transformNumber('id', ($avgNilai / 10) + (70 - $nilai_akhir)))
        ];
        $result->push($nilaiTambah);
        $nilaiTotal = [
            "#",
            "Total Nilai",
            $nilai_akhir + ($avgNilai / 10) + (70 - $nilai_akhir),
            strtoupper(NumberToWords::transformNumber('id', $nilai_akhir + ($avgNilai / 10) + (70 - $nilai_akhir)))
        ];
        $result->push($nilaiTotal);
        return $result;
    }

    public function collection()
    {
        return $this->ExportNilaiSiswa($this->data_siswa);
    }


    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 24
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
            3 => [
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
            4 => [
                'font' => [
                    'bold' => true,
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '19c8da'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            "C" => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            "D" => [
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
                $lastRow = $sheet->getDelegate()->getHighestRow();
                $sheet->mergeCells('A1:' . $sheet->getHighestColumn() . '1');
                $sheet->mergeCells('A2:' . $sheet->getHighestColumn() . '2');
                $sheet->mergeCells('A3:' . $sheet->getHighestColumn() . '3');
                $cellRange = 'A4:' . $sheet->getHighestColumn() . $sheet->getHighestRow();
                $sheet->getDelegate()->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                for ($row = 5; $row <= $lastRow; $row++) {
                    if (!$sheet->getDelegate()->getCell('A' . $row)->getValue()) {
                        $nilai = $sheet->getDelegate()->getCell('C' . $row)->getValue();

                        if ($nilai < 75) {
                            $sheet->getDelegate()->getStyle('A' . $row . ':' . $sheet->getHighestColumn() . $row)->applyFromArray([
                                'fill' => [
                                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                    'startColor' => ['rgb' => 'FF0000'],
                                ],
                                'font' => [
                                    'color' => ['rgb' => 'FFFFFF'],
                                ],
                            ]);
                        }
                    }
                }
            },
        ];
    }
}
