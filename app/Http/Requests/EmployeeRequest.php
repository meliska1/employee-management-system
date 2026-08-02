<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee')?->id;

        return [
            'full_name' => ['required', 'string', 'max:255'],

            'national_id' => [
                'required',
                'string',
                'max:50',
                Rule::unique('employees', 'national_id')->ignore($employeeId),
            ],

            'birth_date' => ['nullable', 'date'],

            'marital_status_id' => [
                'required',
                'exists:marital_statuses,id'
            ],

            'mobile' => ['nullable', 'string', 'max:30'],

            'qualification' => ['nullable', 'string', 'max:255'],

            'qualification_date' => ['nullable', 'date'],

            'iban' => ['nullable', 'string', 'max:50'],

            'bank_id' => [
                'required',
                'exists:banks,id'
            ],

            'job_title_id' => [
                'required',
                'exists:job_titles,id'
            ],

            'start_work_date' => ['nullable', 'date'],

            'direct_manager_name' => ['nullable', 'string', 'max:255'],

            'workplace_1' => ['nullable', 'string', 'max:255'],

            'workplace_2' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'الاسم الكامل للموظف مطلوب.',

            'national_id.required' => 'رقم السجل المدني مطلوب.',
            'national_id.unique' => 'رقم السجل المدني مستخدم مسبقًا.',

            'bank_id.required' => 'اختيار البنك مطلوب.',
            'bank_id.exists' => 'البنك المحدد غير موجود.',

            'job_title_id.required' => 'اختيار المسمى الوظيفي مطلوب.',
            'job_title_id.exists' => 'المسمى الوظيفي المحدد غير موجود.',

            'marital_status_id.required' => 'اختيار الحالة الاجتماعية مطلوب.',
            'marital_status_id.exists' => 'الحالة الاجتماعية المحددة غير موجودة.',
        ];
    }
}