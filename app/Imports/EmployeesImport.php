<?php

namespace App\Imports;

use App\Services\EmployeeImportService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeesImport implements ToCollection, WithHeadingRow
{
    public function __construct(
        protected EmployeeImportService $service
    ) {
    }

    public function collection(Collection $rows): void
    {
        $this->service->import($rows);
    }
}