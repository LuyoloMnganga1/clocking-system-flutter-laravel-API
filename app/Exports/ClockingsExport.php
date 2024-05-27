<?php
namespace App\Exports;

use App\Models\Clocking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClockingsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Clocking::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'User ID',
            'Clock In Time',
            'Clock Out Time',
            'Location In',
            'Location Out',
            'Created At',
            'Updated At',
        ];
    }
}
