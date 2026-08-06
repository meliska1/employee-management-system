
<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EmployeeImportController;
use App\Http\Controllers\Admin\EmployeeAttendanceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('employees.index');
});

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    Route::get('/employees/import', [EmployeeImportController::class, 'create'])
        ->name('employees.import.create');

    Route::post('/employees/import', [EmployeeImportController::class, 'store'])
        ->name('employees.import.store');

    Route::resource('employees', EmployeeController::class);

    Route::get('/employees/export', [EmployeeController::class, 'export'])
        ->name('employees.export');

    Route::resource('employee-attendances', EmployeeAttendanceController::class);
});
```
