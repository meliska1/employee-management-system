<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = Employee::count();

        $todayPresent = EmployeeAttendance::whereDate('attendance_date', today())
            ->where('status', 'present')
            ->count();

        $todayAbsent = EmployeeAttendance::whereDate('attendance_date', today())
            ->where('status', 'absent')
            ->count();

        $todayLate = EmployeeAttendance::whereDate('attendance_date', today())
            ->where('status', 'late')
            ->count();

        return view('admin.dashboard', compact(
            'totalEmployees',
            'todayPresent',
            'todayAbsent',
            'todayLate'
        ));
    }
}