<?php

namespace App\Exports;

use App\Models\Kehadiran;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KehadiranExports implements FromCollection, WithTitle, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{

    protected $tipe;
    public function __construct(string $tipe)
    {
        $this->tipe = $tipe;
    }
    public function title(): string
    {
        return $this->tipe;
    }
    public function headings(): array
    {
        switch ($this->tipe) {
            case 'year':
                $kehadiran = Kehadiran::whereYear('tanggal', Carbon::now()->year)->get()->sortBy("tanggal")->pluck('tanggal')->toArray();
                break;
            case 'month':
                $kehadiran = Kehadiran::whereMonth('tanggal', Carbon::now()->month)->get()->sortBy("tanggal")->pluck('tanggal')->toArray();
                break;
            default:
                $kehadiran = Kehadiran::select("tanggal")->get()->sortBy("tanggal")->pluck('tanggal')->toArray();
                break;
        }
        $tanggalColumns = collect($kehadiran)->map(function ($tanggal) {
            return Carbon::parse($tanggal)->format('Y-m-d');
        })->toArray();
        return [
            [
                strtoupper("Data Kehadiran pengajar"),
            ],
            [
                'No',
                'Nama Pengajar',
                ...$tanggalColumns,
                'Total Jam',
                'Total Gaji'
            ]
        ];
    }



    public function styles(Worksheet $sheet)
    {
        $lastColumn = $sheet->getHighestColumn();
        $columnsToCenter = range('C', $lastColumn);

        $styles = [
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
        ];

        foreach ($columnsToCenter as $column) {
            $styles[$column] = [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ];
        }
        return $styles;
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
                $lastRow = $sheet->getDelegate()->getHighestRow();
                $sheet->mergeCells('A1:' . $sheet->getHighestColumn() . '1');
                $cellRange = 'A3:' . $sheet->getHighestColumn() . $sheet->getHighestRow();
                $sheet->getDelegate()->getStyle($cellRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            },
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function collection()
    {
        return $this->exportSesuaiTipe();
    }

    public function exportSesuaiTipe()
    {
        $no = 0;
        switch ($this->tipe) {
            case 'year':
                $kehadiran = Kehadiran::whereYear('tanggal', Carbon::now()->year)->sortBy("tanggal")->get();
                break;
            case 'month':
                $kehadiran = Kehadiran::whereMonth('tanggal', Carbon::now()->month)->sortBy("tanggal")->get();
                break;
            default:
                $kehadiran = Kehadiran::all()->sortBy("tanggal");
                break;
        }
        $kehadiran = $kehadiran->groupBy('user.nama')->map(function ($userKehadiran, $nama) use (&$no, $kehadiran) {
            $totalJam = array_sum($userKehadiran->pluck('kegiatan')->flatten()->map(function ($kegiatan) {
                $jam_mulai = Carbon::parse($kegiatan->jam_mulai);
                $jam_selesai = Carbon::parse($kegiatan->jam_selesai);
                return number_format($jam_mulai->diffInMinutes($jam_selesai) / 60, 1);
            })->toArray());

            $jamPertanggal = $userKehadiran->pluck('kegiatan')->flatten()->map(function ($kegiatan) {
                $jam_mulai = Carbon::parse($kegiatan->jam_mulai);
                $jam_selesai = Carbon::parse($kegiatan->jam_selesai);
                return collect([
                    'tanggal' => $kegiatan->kehadiran->tanggal,
                    'total jam' => number_format($jam_mulai->diffInMinutes($jam_selesai) / 60, 1)
                ]);
            });

            $jamPertanggal = $jamPertanggal->groupBy('tanggal')->map(function ($items) {
                return [
                    'tanggal' => $items->first()['tanggal'],
                    'total jam' => $items->sum('total jam')
                ];
            })->values();

            $tanggalColumns = collect($kehadiran->pluck('tanggal')->toArray())->map(function ($tanggal) {
                return Carbon::parse($tanggal)->format('Y-m-d');
            });
            return [
                'No' => $no += 1,
                'Nama' => strtoupper($nama),
                ...$tanggalColumns->map(function ($tanggal) use ($jamPertanggal) {
                    $tanggal = Carbon::parse($tanggal)->format('Y-m-d');
                    $jamPertanggalData = $jamPertanggal->firstWhere('tanggal', $tanggal);

                    return $jamPertanggalData ? $jamPertanggalData['total jam'] : "-";
                })->toArray(),
                'Total Jam' => $totalJam,
                'Total Gaji' => 'Rp. ' . $totalJam * env("GAJI_PERJAM"),
            ];
        });
        return $kehadiran->values();
    }
}
