<?php

namespace App\Exports;

use App\Models\Project;
use App\Models\CostPlanSection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class CostPlanProjectExport implements FromArray, WithStyles, WithColumnWidths, WithEvents, WithDrawings
{
    protected $projectId;

    public function __construct($projectId)
    {
        $this->project = Project::findOrFail($projectId);
    }

    public function array(): array
    {
        $rows = [];

         // Space for logo
        $rows[] = [];
        $rows[] = [];
        $rows[] = [];

        // Title section
        $rows[] = ['IMPERIAL CONSTRUCTION'];
        $rows[] = ['COST PLAN'];

        $rows[] = [];
            $sections = CostPlanSection::with('items')
            ->where('project_id', $this->project->id)
            ->get();


        foreach ($sections as $section) {

            $rows[] = [
                "SECTION: {$section->section_code} - {$section->section_name}"
            ];

            $rows[] = [
                'Item Code',
                'Description',
                'Quantity',
                'Unit',
                'Rate',
                'Cost',
                'Total'
            ];

            foreach ($section->items as $item) {
                $rows[] = [
                    $item->item_code,
                    $item->description,
                    $item->quantity,
                    $item->unit,
                    $item->rate,
                    $item->cost,
                    $item->total
                ];
            }

            $rows[] = [];
        }

        return $rows;
    }

    // Font styles
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14
                ]
            ]
        ];
    }

    // Column widths
    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 80, // Description column wider
            'C' => 12,
            'D' => 10,
            'E' => 15,
            'F' => 15,
            'G' => 15
        ];
    }

    // Wrap text for description column
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
    
                $sheet = $event->sheet->getDelegate();
    
                // Wrap description column
                $sheet->getStyle('B:B')
                    ->getAlignment()
                    ->setWrapText(true);
    
                $highestRow = $sheet->getHighestRow();
    
                for ($row = 1; $row <= $highestRow; $row++) {
    
                    $value = $sheet->getCell('A'.$row)->getValue();
    
                    // SECTION HEADER STYLE
                    if (str_contains($value, 'SECTION:')) {
    
                        $sheet->mergeCells("A{$row}:G{$row}");
    
                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('000000');
    
                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFont()
                            ->setBold(true)
                            ->setColor(new Color(Color::COLOR_WHITE));
                    }
    
                    // TABLE HEADER STYLE
                    if ($value === 'Item Code') {
    
                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFont()
                            ->setBold(true);
    
                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getFill()
                            ->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('D9D9D9'); // light gray
    
                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getAlignment()
                            ->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
                        $sheet->getStyle("A{$row}:G{$row}")
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(Border::BORDER_THIN);
                    }
                }
            },
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();

        $drawing->setName('Company Logo');
        $drawing->setDescription('Company Logo');

        // Path to your logo
        $drawing->setPath(public_path('assets/images/imperial-logo.png'));

        // Position in Excel
        $drawing->setCoordinates('A1');

        // Logo height
        $drawing->setHeight(70);

        return $drawing;
    }
}