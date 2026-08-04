<?php

namespace App\Services;

use App\Models\EmployeeAttendance;

class EmployeeAttendanceReportService
{
    public function getStatistics(): array
    {
        return [
            'total_attendance' => EmployeeAttendance::count(),

            'present' => EmployeeAttendance::where('status', 'Present')->count(),

            'absent' => EmployeeAttendance::where('status', 'Absent')->count(),

            'late' => EmployeeAttendance::where('late_minutes', '>', 0)->count(),
        ];
    }
}