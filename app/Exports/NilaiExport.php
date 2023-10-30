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

    protected $kelas, $heading, $tipe, $judul, $mapel;
    /**
     * @param $kelas Model untuk kelas
     * @param $heading heading untuk tabel
     */
    public function __construct($kelas, array $heading, int $tipe, string $judul, $mapel = null)
    {
        $this->kelas = $kelas;
        $this->heading = $heading;
        $this->tipe = $tipe;
        $this->judul = $judul;
        $this->mapel = $mapel;
    }
    public function nilaiPerMapel($kelas)
    {
        $data_kelas = $kelas;
        $data_siswa = collect([$this->heading]);
        $data_mapel = $kelas->pengajar->pluck('mapel')->flatten();
        $no = 0;

        foreach ($data_kelas->siswa as $siswa) {
            $nilai_mapel = collect([]);
            $siswaData = [
                'no' => $no += 1,
                'nis' => $siswa->nis,
                'nama' => $siswa->nama
            ];

            $tugasTuntas = true;

            foreach ($data_mapel as $mapel) {
                $nilai = $this->hitungRataRataNilai($mapel, $siswa);
                $nilai_mapel->push($nilai);

                if ($nilai === "Belum lengkap") {
                    $tugasTuntas = false;
                }

                $siswaData[$mapel->nama_mapel] = ($nilai !== null) ? $nilai : "Belum lengkap";
            }
            if ($tugasTuntas) {
                $siswaData['Nilai Akhir'] = $siswa->nilai_akhir()->where('tahun_ajar', $data_kelas->tahun_ajar)->where('semester', $data_kelas->semester)->first()->nilai;
                if ($siswaData['Nilai Akhir'] >= 65 && $siswaData['Nilai Akhir'] <= 75) {
                    $siswaData['Nilai Mapel'] = ($nilai_mapel->avg() / 10) +  (70 - $siswaData['Nilai Akhir']);
                    $siswaData['Total Nilai'] = $siswaData['Nilai Akhir'] + $siswaData['Nilai Mapel'];
                }
                if ($siswaData['Nilai Akhir'] >= 76 && $siswaData['Nilai Akhir'] <= 100) {
                    $siswaData['Nilai Akhir'] = $siswa->nilai_akhir()->where('tahun_ajar', $data_kelas->tahun_ajar)->where('semester', $data_kelas->semester)->first()->nilai;
                    $siswaData['Nilai Mapel'] = "-";
                    $siswaData['Total Nilai'] = $siswaData['Nilai Akhir'];
                }
                if ($siswaData['Nilai Akhir'] <= 50) {
                    $siswaData['Nilai Akhir'] = $siswa->nilai_akhir()->where('tahun_ajar', $data_kelas->tahun_ajar)->where('semester', $data_kelas->semester)->first()->nilai;
                    $siswaData['Nilai Mapel'] = "Remedial";
                    $siswaData['Total Nilai'] = "Remedial";
                }
            } else {
                $siswaData['Nilai Mapel'] = "Belum lengkap";
                $siswaData['Nilai Akhir'] = "Belum lengkap";
                $siswaData['Total Nilai'] = "Belum lengkap";
            }

            $data_siswa->push($siswaData);
        }

        return $data_siswa;
    }


    public function nilaiPerTugas($kelas, $mapel)
    {
        $data_kelas = $kelas;
        $data_siswa = collect([$this->heading]);
        $data_mapel = $mapel;
        $no = 0;
        foreach ($data_kelas->siswa as $siswa) {
            $siswaData = [
                'no' => $no += 1,
                'nis' => $siswa->nis,
                'nama' => $siswa->nama,
            ];
            foreach ($data_mapel->tugas->where('tahun_ajar', $data_kelas->tahun_ajar)->where('semester', $data_kelas->semester) as $tugas) {
                $siswaData[$tugas->nama] = $tugas->nilai->where('id_siswa', $siswa->id)->where('tahun_ajar', $data_kelas->tahun_ajar)->where('semester', $data_kelas->semester)->where('id_tugas', $tugas->id)->value('nilai') ?? "Belum dinilai";
            }
            $data_siswa->push($siswaData);
        }
        return $data_siswa;
    }


    private function hitungRataRataNilai($mapel, $siswa)
    {
        $nilaiTugas = $mapel->tugas
            ->where('tahun_ajar', $siswa->kelas->tahun_ajar)
            ->where('semester', $siswa->kelas->semester)
            ->pluck('nilai')
            ->flatten()
            ->where('id_siswa', $siswa->id)
            ->where('tahun_ajar', $siswa->kelas->tahun_ajar)
            ->where('semester', $siswa->kelas->semester)
            ->whereNotNull('nilai')
            ->pluck('nilai');
        $totalTugas =  $mapel->tugas
            ->where('tahun_ajar', $siswa->kelas->tahun_ajar)
            ->where('semester', $siswa->kelas->semester)
            ->where('id_kelas', $siswa->kelas->id)
            ->count();

        if ($totalTugas == $nilaiTugas->count()) {
            $nilaiRataRata = number_format($nilaiTugas->avg(), 0);
            return intval($nilaiRataRata);
        }
        return "Belum lengkap";
    }



    public function collection()
    {
        switch ($this->tipe) {
            case 1:
                return $this->nilaiPerMapel($this->kelas);
                break;

            case 2:
                return $this->nilaiPerTugas($this->kelas, $this->mapel);
                break;
        }
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
                $sheet->setCellValue('A1', strtoupper($this->judul));
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
