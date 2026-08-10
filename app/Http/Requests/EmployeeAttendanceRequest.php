<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // الحصول على سجل الحضور الحالي في حالة التعديل
        $attendance = $this->route('attendance');

        $attendanceId = is_object($attendance)
            ? $attendance->id
            : $attendance;

        return [
            'employee_id' => [
                'required',
                'exists:employees,id',

                // منع تكرار حضور نفس الموظف في نفس التاريخ
                Rule::unique('employee_attendances', 'employee_id')
                    ->where(function ($query) {
                        return $query->where(
                            'attendance_date',
                            $this->attendance_date
                        );
                    })
                    ->ignore($attendanceId),
            ],

            'attendance_date' => [
                'required',
                'date',
            ],

            'check_in' => [
                'nullable',
                'date_format:H:i',
            ],

            'check_out' => [
                'nullable',
                'date_format:H:i',
                'after_or_equal:check_in',
            ],

            'status' => [
                'required',
                'in:present,absent,late,leave,permission,half_day',
            ],

            'late_minutes' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'early_leave_minutes' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'notes' => [
                'nullable',
                'string',
            ],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'employee_id.required' =>
                'الموظف مطلوب.',

            'employee_id.exists' =>
                'الموظف غير موجود في النظام.',

            'employee_id.unique' =>
                'تم تسجيل حضور هذا الموظف مسبقًا في نفس التاريخ.',

            'attendance_date.required' =>
                'تاريخ الحضور مطلوب.',

            'attendance_date.date' =>
                'تاريخ الحضور غير صحيح.',

            'check_in.date_format' =>
                'وقت الدخول يجب أن يكون بصيغة ساعة:دقيقة.',

            'check_out.date_format' =>
                'وقت الخروج يجب أن يكون بصيغة ساعة:دقيقة.',

            'check_out.after_or_equal' =>
                'وقت الخروج يجب أن يكون بعد أو مساويًا لوقت الدخول.',

            'status.required' =>
                'حالة الحضور مطلوبة.',

            'status.in' =>
                'حالة الحضور غير صحيحة.',

            'late_minutes.integer' =>
                'دقائق التأخير يجب أن تكون رقمًا صحيحًا.',

            'late_minutes.min' =>
                'دقائق التأخير لا يمكن أن تكون سالبة.',

            'early_leave_minutes.integer' =>
                'دقائق الخروج المبكر يجب أن تكون رقمًا صحيحًا.',

            'early_leave_minutes.min' =>
                'دقائق الخروج المبكر لا يمكن أن تكون سالبة.',
        ];
    }
}