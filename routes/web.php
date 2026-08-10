<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\EmployeeImportController;
use App\Http\Controllers\Admin\EmployeeAttendanceController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| الصفحة الرئيسية
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('employees.index');
});


/*
|--------------------------------------------------------------------------
| Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');


    /*
    |--------------------------------------------------------------------------
    | Employee Import
    |--------------------------------------------------------------------------
    */

    Route::get('/employees/import', [EmployeeImportController::class, 'create'])
        ->name('employees.import.create');

    Route::post('/employees/import', [EmployeeImportController::class, 'store'])
        ->name('employees.import.store');


    /*
    |--------------------------------------------------------------------------
    | Employee Export
    |--------------------------------------------------------------------------
    */

    Route::get('/employees/export', [EmployeeController::class, 'export'])
        ->name('employees.export');


    /*
    |--------------------------------------------------------------------------
    | Employees
    |--------------------------------------------------------------------------
    */

    Route::resource('employees', EmployeeController::class);


    /*
    |--------------------------------------------------------------------------
    | Employee Attendances Export
    |--------------------------------------------------------------------------
    */

    Route::get('/employee-attendances/export', [
        EmployeeAttendanceController::class,
        'export'
    ])->name('employee-attendances.export');


    /*
    |--------------------------------------------------------------------------
    | Employee Attendances
    |--------------------------------------------------------------------------
    */

    Route::resource(
        'employee-attendances',
        EmployeeAttendanceController::class
    );

});

