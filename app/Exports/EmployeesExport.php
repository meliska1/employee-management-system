<?php

namespace App\Exports;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromQuery, WithHeadings, WithMapping
{
    public function __construct(
        private array $filters = []
    ) {
    }

    public function query(): Builder
    {
        $query = Employee::query()
            ->with([
                'bank',
                'jobTitle',
                'maritalStatus',
            ]);

        if (!empty($this->filters['full_name'])) {
            $query->where(
                'full_name',
                'like',
                '%' . $this->filters['full_name'] . '%'
            );
        }

        if (!empty($this->filters['national_id'])) {
            $query->where(
                'national_id',
                'like',
                '%' . $this->filters['national_id'] . '%'
            );
        }

        if (!empty($this->filters['mobile'])) {
            $query->where(
                'mobile',
                'like',
                '%' . $this->filters['mobile'] . '%'
            );
        }

        if (!empty($this->filters['bank_id'])) {
            $query->where('bank_id', $this->filters['bank_id']);
        }

        if (!empty($this->filters['job_title_id'])) {
            $query->where(
                'job_title_id',
                $this->filters['job_title_id']
            );
        }

        if (!empty($this->filters['marital_status_id'])) {
            $query->where(
                'marital_status_id',
                $this->filters['marital_status_id']
            );
        }

        if (!empty($this->filters['workplace'])) {
            $workplace = $this->filters['workplace'];

            $query->where(function (Builder $subQuery) use ($workplace) {
                $subQuery
                    ->where(
                        'workplace_1',
                        'like',
                        '%' . $workplace . '%'
                    )
                    ->orWhere(
                        'workplace_2',
                        'like',
                        '%' . $workplace . '%'
                    );
            });
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'الرقم',
            'الاسم الكامل',
            'رقم السجل المدني',
            'تاريخ الميلاد',
            'الحالة الاجتماعية',
            'رقم الجوال',
            'المؤهل العلمي',
            'تاريخ المؤهل',
            'رقم الآيبان',
            'البنك',
            'المسمى الوظيفي',
            'تاريخ بداية العمل',
            'اسم المدير المباشر',
            'جهة العمل الأولى',
            'جهة العمل الثانية',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->full_name,
            $employee->national_id,
            optional($employee->birth_date)->format('Y-m-d') ?? '-',
            $employee->maritalStatus?->name ?? '-',
            $employee->mobile ?? '-',
            $employee->qualification ?? '-',
            optional($employee->qualification_date)->format('Y-m-d') ?? '-',
            $employee->iban ?? '-',
            $employee->bank?->name ?? '-',
            $employee->jobTitle?->name ?? '-',
            optional($employee->start_work_date)->format('Y-m-d') ?? '-',
            $employee->direct_manager_name ?? '-',
            $employee->workplace_1 ?? '-',
            $employee->workplace_2 ?? '-',
        ];
    }
}