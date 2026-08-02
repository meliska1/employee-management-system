<?php

namespace App\Services;

use App\Models\Bank;
use App\Models\Employee;
use App\Models\JobTitle;
use App\Models\MaritalStatus;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Throwable;

class EmployeeImportService
{
    private array $errors = [];

    private int $importedCount = 0;

    public function import(Collection $rows): void
    {
        $this->errors = [];
        $this->importedCount = 0;

        foreach ($rows as $index => $row) {
            // الصف الأول هو العناوين، لذلك يبدأ رقم البيانات من الصف الثاني.
            $rowNumber = $index + 2;

            try {
                $this->importRow(
                    $row instanceof Collection ? $row->toArray() : (array) $row,
                    $rowNumber
                );
            } catch (Throwable $exception) {
                $this->errors[] = [
                    'row' => $rowNumber,
                    'national_id' => $row['national_id'] ?? null,
                    'errors' => [
                        'حدث خطأ أثناء معالجة الصف: ' . $exception->getMessage(),
                    ],
                ];
            }
        }
    }

    private function importRow(array $row, int $rowNumber): void
    {
        $row = $this->normalizeRow($row);

        if ($this->isEmptyRow($row)) {
            return;
        }

        $bank = Bank::where('name', $row['bank'] ?? '')->first();

        $jobTitle = JobTitle::where(
            'name',
            $row['job_title'] ?? ''
        )->first();

        $maritalStatus = MaritalStatus::where(
            'name',
            $row['marital_status'] ?? ''
        )->first();

        $data = [
            'full_name' => $row['full_name'] ?? null,
            'national_id' => $this->stringValue(
                $row['national_id'] ?? null
            ),
            'birth_date' => $this->parseDate(
                $row['birth_date'] ?? null
            ),
            'marital_status_id' => $maritalStatus?->id,
            'mobile' => $this->stringValue(
                $row['mobile'] ?? null
            ),
            'qualification' => $row['qualification'] ?? null,
            'qualification_date' => $this->parseDate(
                $row['qualification_date'] ?? null
            ),
            'iban' => $this->stringValue(
                $row['iban'] ?? null
            ),
            'bank_id' => $bank?->id,
            'job_title_id' => $jobTitle?->id,
            'start_work_date' => $this->parseDate(
                $row['start_work_date'] ?? null
            ),
            'direct_manager_name' =>
                $row['direct_manager_name'] ?? null,
            'workplace_1' => $row['workplace_1'] ?? null,
            'workplace_2' => $row['workplace_2'] ?? null,
        ];

        $validator = Validator::make(
            $data,
            [
                'full_name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'national_id' => [
                    'required',
                    'string',
                    'max:50',
                    'unique:employees,national_id',
                ],

                'birth_date' => [
                    'nullable',
                    'date',
                ],

                'marital_status_id' => [
                    'required',
                    'exists:marital_statuses,id',
                ],

                'mobile' => [
                    'nullable',
                    'string',
                    'max:30',
                ],

                'qualification' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'qualification_date' => [
                    'nullable',
                    'date',
                ],

                'iban' => [
                    'nullable',
                    'string',
                    'max:50',
                ],

                'bank_id' => [
                    'required',
                    'exists:banks,id',
                ],

                'job_title_id' => [
                    'required',
                    'exists:job_titles,id',
                ],

                'start_work_date' => [
                    'nullable',
                    'date',
                ],

                'direct_manager_name' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'workplace_1' => [
                    'nullable',
                    'string',
                    'max:255',
                ],

                'workplace_2' => [
                    'nullable',
                    'string',
                    'max:255',
                ],
            ],
            [
                'full_name.required' =>
                    'الاسم الكامل مطلوب.',

                'national_id.required' =>
                    'رقم السجل المدني مطلوب.',

                'national_id.unique' =>
                    'رقم السجل المدني مستخدم مسبقًا.',

                'birth_date.date' =>
                    'تاريخ الميلاد غير صحيح.',

                'marital_status_id.required' =>
                    'الحالة الاجتماعية غير موجودة أو غير صحيحة.',

                'marital_status_id.exists' =>
                    'الحالة الاجتماعية غير موجودة في النظام.',

                'mobile.max' =>
                    'رقم الجوال أطول من الحد المسموح.',

                'qualification_date.date' =>
                    'تاريخ المؤهل غير صحيح.',

                'bank_id.required' =>
                    'البنك غير موجود أو غير صحيح.',

                'bank_id.exists' =>
                    'البنك غير موجود في النظام.',

                'job_title_id.required' =>
                    'المسمى الوظيفي غير موجود أو غير صحيح.',

                'job_title_id.exists' =>
                    'المسمى الوظيفي غير موجود في النظام.',

                'start_work_date.date' =>
                    'تاريخ بداية العمل غير صحيح.',
            ]
        );

        if ($validator->fails()) {
            $this->errors[] = [
                'row' => $rowNumber,
                'national_id' => $data['national_id'],
                'errors' => $validator->errors()->all(),
            ];

            return;
        }

        Employee::create($validator->validated());

        $this->importedCount++;
    }

    private function normalizeRow(array $row): array
    {
        return collect($row)
            ->mapWithKeys(function ($value, $key) {
                $normalizedKey = strtolower(
                    trim((string) $key)
                );

                return [$normalizedKey => $value];
            })
            ->toArray();
    }

    private function isEmptyRow(array $row): bool
    {
        return collect($row)
            ->filter(function ($value) {
                return $value !== null && trim((string) $value) !== '';
            })
            ->isEmpty();
    }

    private function stringValue(mixed $value): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        return trim((string) $value);
    }

    private function parseDate(mixed $value): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        try {
            if (is_numeric($value)) {
                return ExcelDate::excelToDateTimeObject($value)
                    ->format('Y-m-d');
            }

            return Carbon::parse($value)->format('Y-m-d');
        } catch (Throwable) {
            return null;
        }
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getImportedCount(): int
    {
        return $this->importedCount;
    }

    public function getFailedCount(): int
    {
        return count($this->errors);
    }
}