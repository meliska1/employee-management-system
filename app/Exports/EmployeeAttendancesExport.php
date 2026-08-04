<?php

namespace App\Exports;

use App\Models\EmployeeAttendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeAttendancesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return EmployeeAttendance::with('employee')->get()->map(function ($attendance) {
            return [
                'Employee' => $attendance->employee->name ?? '',
                'Date' => $attendance->attendance_date,
                'Check In' => $attendance->check_in,
                'Check Out' => $attendance->check_out,
                'Status' => $attendance->status,
                'Late Minutes' => $attendance->late_minutes,
                'Early Leave Minutes' => $attendance->early_leave_minutes,
                'Notes' => $attendance->notes,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Attendance Date',
            'Check In',
            'Check Out',
            'Status',
            'Late Minutes',
            'Early Leave Minutes',
            'Notes',
        ];
    }
}