<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmployeesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeRequest;
use App\Models\Bank;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\MaritalStatus;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with([
            'bank',
            'jobTitle',
            'maritalStatus',
        ]);

        if ($request->filled('full_name')) {
            $query->where(
                'full_name',
                'like',
                '%' . $request->full_name . '%'
            );
        }

        if ($request->filled('national_id')) {
            $query->where(
                'national_id',
                'like',
                '%' . $request->national_id . '%'
            );
        }

        if ($request->filled('mobile')) {
            $query->where(
                'mobile',
                'like',
                '%' . $request->mobile . '%'
            );
        }

        if ($request->filled('bank_id')) {
            $query->where('bank_id', $request->bank_id);
        }

        if ($request->filled('job_title_id')) {
            $query->where('job_title_id', $request->job_title_id);
        }

        if ($request->filled('marital_status_id')) {
            $query->where(
                'marital_status_id',
                $request->marital_status_id
            );
        }

        if ($request->filled('workplace')) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery
                    ->where(
                        'workplace_1',
                        'like',
                        '%' . $request->workplace . '%'
                    )
                    ->orWhere(
                        'workplace_2',
                        'like',
                        '%' . $request->workplace . '%'
                    );
            });
        }

        $employees = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.employees.index', [
            'employees' => $employees,
            'banks' => Bank::orderBy('name')->get(),
            'jobTitles' => JobTitle::orderBy('name')->get(),
            'maritalStatuses' => MaritalStatus::orderBy('name')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.employees.create', [
            'banks' => Bank::orderBy('name')->get(),
            'jobTitles' => JobTitle::orderBy('name')->get(),
            'maritalStatuses' => MaritalStatus::orderBy('name')->get(),
        ]);
    }

    public function store(EmployeeRequest $request)
    {
        Employee::create($request->validated());

        return redirect()
            ->route('employees.index')
            ->with('success', 'تمت إضافة الموظف بنجاح.');
    }

    public function show(Request $request, Employee $employee)
    {
        $employee->load([
            'bank',
            'jobTitle',
            'maritalStatus',
        ]);

        $attendances = $employee
            ->attendances()
            ->when(
                $request->filled('date_from'),
                function ($query) use ($request) {
                    $query->whereDate(
                        'attendance_date',
                        '>=',
                        $request->date_from
                    );
                }
            )
            ->when(
                $request->filled('date_to'),
                function ($query) use ($request) {
                    $query->whereDate(
                        'attendance_date',
                        '<=',
                        $request->date_to
                    );
                }
            )
            ->latest('attendance_date')
            ->get();

        return view('admin.employees.show', [
            'employee' => $employee,
            'attendances' => $attendances,
        ]);
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', [
            'employee' => $employee,
            'banks' => Bank::orderBy('name')->get(),
            'jobTitles' => JobTitle::orderBy('name')->get(),
            'maritalStatuses' => MaritalStatus::orderBy('name')->get(),
        ]);
    }

    public function update(
        EmployeeRequest $request,
        Employee $employee
    ) {
        $employee->update($request->validated());

        return redirect()
            ->route('employees.index')
            ->with('success', 'تم تحديث بيانات الموظف بنجاح.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();

        return redirect()
            ->route('employees.index')
            ->with('success', 'تم حذف الموظف بنجاح.');
    }

    public function export(Request $request)
    {
        return Excel::download(
            new EmployeesExport($request->all()),
            'employees.xlsx'
        );
    }
}