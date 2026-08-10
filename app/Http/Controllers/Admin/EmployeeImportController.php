<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\EmployeesImport;
use App\Services\EmployeeImportService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Throwable;

class EmployeeImportController extends Controller
{
    public function create(): View
    {
        return view('admin.employees.import');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate(
            [
                'file' => [
                    'required',
                    'file',
                    'mimes:xlsx,xls,csv',
                    'max:10240',
                ],
            ],
            [
                'file.required' => 'يرجى اختيار ملف للاستيراد.',
                'file.file' => 'الملف المرفوع غير صالح.',
                'file.mimes' => 'يجب أن يكون الملف بصيغة xlsx أو xls أو csv.',
                'file.max' => 'حجم الملف يجب ألا يتجاوز 10 ميجابايت.',
            ]
        );

        try {
            $service = new EmployeeImportService();
            $import = new EmployeesImport($service);

            Excel::import($import, $request->file('file'));

            return redirect()
                ->route('employees.import.create')
                ->with([
                    'success' => 'اكتملت عملية الاستيراد.',
                    'imported_count' => $import->getImportedCount(),
                    'failed_count' => $import->getFailedCount(),
                    'import_errors' => $import->getErrors(),
                ]);
        } catch (Throwable $exception) {
            return redirect()
                ->route('employees.import.create')
                ->withInput()
                ->with(
                    'error',
                    'حدث خطأ أثناء استيراد الملف: ' .
                    $exception->getMessage()
                );
        }
    }
}