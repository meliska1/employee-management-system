
<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EmployeeAttendancesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeAttendanceRequest;
use App\Models\Employee;
use App\Models\EmployeeAttendance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeAttendanceController extends Controller
{
    /**
     * عرض سجلات الحضور.
     */
    public function index(Request $request)
    {
        $attendances = EmployeeAttendance::with('employee')
            ->when($request->filled('employee_id'), function ($query) use ($request) {
                $query->where('employee_id', $request->employee_id);
            })
            ->when($request->filled('attendance_date'), function ($query) use ($request) {
                $query->whereDate(
                    'attendance_date',
                    $request->attendance_date
                );
            })
            ->latest('attendance_date')
            ->paginate(10)
            ->withQueryString();

        $employees = Employee::orderBy('full_name')->get();

        return view(
            'admin.attendances.index',
            compact('attendances', 'employees')
        );
    }


    /**
     * عرض نموذج إضافة حضور.
     */
    public function create()
    {
        $employees = Employee::orderBy('full_name')->get();

        return view(
            'admin.attendances.create',
            compact('employees')
        );
    }


    /**
     * حفظ سجل حضور جديد.
     */
    public function store(EmployeeAttendanceRequest $request)
    {
        EmployeeAttendance::create($request->validated());

        return redirect()
            ->route('employee-attendances.index')
            ->with('success', 'تم إضافة سجل الحضور بنجاح.');
    }


    /**
     * عرض تفاصيل سجل حضور واحد.
     */
    public function show(EmployeeAttendance $attendance)
    {
        $attendance->load('employee');

        return view(
            'admin.attendances.show',
            compact('attendance')
        );
    }


    /**
     * عرض نموذج تعديل سجل الحضور.
     */
    public function edit(EmployeeAttendance $attendance)
    {
        $attendance->load('employee');

        $employees = Employee::orderBy('full_name')->get();

        return view(
            'admin.attendances.edit',
            compact('attendance', 'employees')
        );
    }


    /**
     * تحديث سجل الحضور.
     */
    public function update(
        EmployeeAttendanceRequest $request,
        EmployeeAttendance $attendance
    ) {
        $attendance->update($request->validated());

        return redirect()
            ->route('employee-attendances.index')
            ->with('success', 'تم تحديث سجل الحضور بنجاح.');
    }


    /**
     * تصدير سجلات الحضور إلى Excel.
     */
    public function export(Request $request)
    {
        return Excel::download(
            new EmployeeAttendancesExport($request->all()),
            'employee-attendances.xlsx'
        );
    }


    /**
     * حذف سجل الحضور.
     */
    public function destroy(EmployeeAttendance $attendance)
    {
        $attendance->delete();

        return redirect()
            ->route('employee-attendances.index')
            ->with('success', 'تم حذف سجل الحضور بنجاح.');
    }
}

