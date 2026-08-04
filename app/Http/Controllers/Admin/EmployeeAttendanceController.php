<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeAttendance;
use App\Http\Requests\EmployeeAttendanceRequest;

class EmployeeAttendanceController extends Controller
{
    public function index()
    {
        $attendances = EmployeeAttendance::all();

        return view('admin.employee_attendances.index', compact('attendances'));
    }

    public function create()
    {
        return view('admin.employee_attendances.create');
    }

    public function store(EmployeeAttendanceRequest $request)
    {
        EmployeeAttendance::create($request->validated());

        return redirect()->route('employee-attendances.index');
    }

    public function show(EmployeeAttendance $employeeAttendance)
    {
        return view('admin.employee_attendances.show', compact('employeeAttendance'));
    }

    public function edit(EmployeeAttendance $employeeAttendance)
    {
        return view('admin.employee_attendances.edit', compact('employeeAttendance'));
    }

    public function update(EmployeeAttendanceRequest $request, EmployeeAttendance $employeeAttendance)
    {
        $employeeAttendance->update($request->validated());

        return redirect()->route('employee-attendances.index');
    }

    public function destroy(EmployeeAttendance $employeeAttendance)
    {
        $employeeAttendance->delete();

        return redirect()->route('employee-attendances.index');
    }
}