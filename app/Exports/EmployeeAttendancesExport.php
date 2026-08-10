<?php

namespace App\Exports;

use App\Models\EmployeeAttendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmployeeAttendancesExport implements FromCollection, WithHeadings
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    /**
     * Export employee attendance records with filters.
     */
    public function collection()
    {
        $query = EmployeeAttendance::with('employee');

        // فلترة حسب الموظف
        if (!empty($this->filters['employee_id'])) {
            $query->where(
                'employee_id',
                $this->filters['employee_id']
            );
        }

        // فلترة حسب تاريخ محدد
        if (!empty($this->filters['attendance_date'])) {
            $query->whereDate(
                'attendance_date',
                $this->filters['attendance_date']
            );
        }

        // من تاريخ
        if (!empty($this->filters['date_from'])) {
            $query->whereDate(
                'attendance_date',
                '>=',
                $this->filters['date_from']
            );
        }

        // إلى تاريخ
        if (!empty($this->filters['date_to'])) {
            $query->whereDate(
                'attendance_date',
                '<=',
                $this->filters['date_to']
            );
        }

        return $query
            ->latest('attendance_date')
            ->get()
            ->map(function ($attendance) {
                return [
                    'Employee' => $attendance->employee?->full_name ?? '',
                    'Date' => $attendance->attendance_date?->format('Y-m-d'),
                    'Check In' => $attendance->check_in,
                    'Check Out' => $attendance->check_out,
                    'Status' => $attendance->status,
                    'Late Minutes' => $attendance->late_minutes ?? 0,
                    'Early Leave Minutes' => $attendance->early_leave_minutes ?? 0,
                    'Notes' => $attendance->notes ?? '',
                ];
            });
    }

    /**
     * Excel headings.
     */
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
      