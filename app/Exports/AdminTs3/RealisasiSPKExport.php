<?php

namespace App\Exports\AdminTs3;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RealisasiSPKExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles, WithEvents
{
    protected $data;
    protected $from_date;
    protected $to_date;
    protected $spkno;
    protected $regional;

    public function __construct($data, $from_date = null, $to_date = null, $spkno = null, $regional = null)
    {
        $this->data = $data;
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->spkno = $spkno;
        $this->regional = $regional;
    }

    public function collection()
    {
        $realisasi_spk = $this->data['realisasi_spk'];

        return $realisasi_spk->map(function ($item, $index) {
            return [
                'no' => $index + 1,
                'nopol' => $item->nopol ?? '',
                'norangka' => $item->norangka ?? '',
                'nomesin' => $item->nomesin ?? '',
                'regional' => $item->regional ?? '',
                'area' => $item->area ?? '',
                'cabang' => $item->cabang ?? '',
                'spk_no' => $item->spk_no ?? '',
                'service_no' => $item->service_no ?? '',
                'tanggal_service' => $item->tanggal_service ?? '',
                'keterangan' => $item->keterangan ?? '',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'No Polisi',
            'No Rangka',
            'No Mesin',
            'Regional',
            'Area',
            'Cabang',
            'SPK No',
            'Service No',
            'Tanggal Service',
            'Keterangan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            3    => ['font' => ['bold' => true]], // Header table styling
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;

                // Title
                $sheet->setCellValue('A1', 'REALISASI SPK');
                $sheet->mergeCells('A1:K1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 16
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ]
                ]);
                $sheet->getRowDimension(1)->setRowHeight(30);

                // Period and Regional Information
                $headerText = '';
                if ($this->from_date && $this->to_date) {
                    $headerText .= "PERIOD {$this->from_date} SAMPAI {$this->to_date}\n";
                }
                if ($this->spkno) {
                    $headerText .= "SPK No: {$this->spkno}\n";
                }
                if ($this->regional) {
                    $headerText .= "Regional: {$this->regional}\n";
                }

                $sheet->setCellValue('A2', trim($headerText));
                $sheet->mergeCells('A2:K2');
                $sheet->getStyle('A2')->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ]
                ]);
                $sheet->getRowDimension(2)->setRowHeight(60);

                // Header Row Styling
                $sheet->getStyle('A3:K3')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => '16A085'
                        ]
                    ],
                    'font' => [
                        'color' => ['rgb' => 'FFFFFF']
                    ]
                ]);
                $sheet->getStyle('A3:K3')->getAlignment()->setHorizontal('center');

                // Borders
                $lastRow = $this->data['realisasi_spk']->count() + 3; // Adjust for title and headers
                $sheet->getStyle('A3:K' . $lastRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
            }
        ];
    }
}
