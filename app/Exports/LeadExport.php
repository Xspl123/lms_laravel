<?php

namespace App\Exports;

use App\Models\CreateLead;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LeadExport implements FromCollection, WithHeadings, WithStyles 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data =  CreateLead::select('related_activities','lead_Name','email','lead_Source','Owner','fullName','phone','website','lead_status','annualRevenue','secondaryEmail','city','street','pinCode','state','country','discription','created_at','updated_at')->get();
            // Check if there is data to export
        if ($data->isEmpty()) {
            // If no data, return an empty array
            return [];
        }

        // If there is data, return the selected columns
        return $data;
    
    }

    public function headings(): array
    {
        return [
            'Related Activities', 'Lead Name', 'Email', 'Lead Source', 'Owner',
            'Full Name', 'Phone', 'Website', 'Lead Status',
            'Annual Revenue','Secondary Email',
            'City', 'Street', 'Pin Code', 'State', 'Country', 'Description',
            'Create Date', 'Updated Date',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);

        // Apply borders to all cells
        $sheet->getStyle('A1:' . $highestColumn . $highestRow)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Apply background colors to each column starting from A1
        for ($i = 1; $i <= $highestColumnIndex; $i++) {
            $color = $this->generateRandomPastelColor();
            $columnLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($i);
            $sheet->getStyle($columnLetter . '1:' . $columnLetter . $highestRow)->applyFromArray([
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => $color],
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF'], // Set text color to white
                ],
            ]);
        }

        // Apply bold font to the header row (A1 to the last column of the header row)
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray([
            'font' => ['bold' => true],
        ]);

        // Apply horizontal center alignment to all cells from A2 to the last row
        $sheet->getStyle('A2:' . $highestColumn . $highestRow)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }

    private function generateRandomPastelColor()
    {
        // Generate random RGB values with lower intensity to get a pastel color
        $r = mt_rand(100, 200);
        $g = mt_rand(100, 200);
        $b = mt_rand(100, 200);

        return sprintf('%02X%02X%02X', $r, $g, $b);
    }
}

