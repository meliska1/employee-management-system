@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <h2>
        سجلات الحضور والانصراف
    </h2>

    <div class="d-flex gap-2">

        <a
            href="{{ route('employee-attendances.export', request()->query()) }}"
            class="btn btn-success"
        >
            تصدير Excel
        </a>

        <a
            href="{{ route('employee-attendances.create') }}"
            class="btn btn-primary"
        >
            إضافة حضور
        </a>

    </div>

</div>


{{-- رسالة النجاح --}}
@if(session('success'))

    <div class="alert alert-success">
        {{ session('success') }}
    </div>

@endif


{{-- أخطاء التحقق --}}
@if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>
                    {{ $error }}
                </li>

            @endforeach

        </ul>

    </div>

@endif


{{-- الفلاتر --}}

<div class="card mb-4">

    <div class="card-body">

        <form
            method="GET"
            action="{{ route('employee-attendances.index') }}"
        >

            <div class="row g-3">

                {{-- الموظف --}}

                <div class="col-md-5">

                    <label
                        for="employee_id"
                        class="form-label"
                    >
                        الموظف
                    </label>

                    <select
                        name="employee_id"
                        id="employee_id"
                        class="form-select"
                    >

                        <option value="">
                            كل الموظفين
                        </option>

                        @foreach($employees as $employee)

                            <option
                                value="{{ $employee->id }}"
                                {{ request('employee_id') == $employee->id ? 'selected' : '' }}
                            >
                                {{ $employee->full_name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- التاريخ --}}

                <div class="col-md-5">

                    <label
                        for="attendance_date"
                        class="form-label"
                    >
                        التاريخ
                    </label>

                    <input
                        type="date"
                        name="attendance_date"
                        id="attendance_date"
                        class="form-control"
                        value="{{ request('attendance_date') }}"
                    >

                </div>


                {{-- البحث --}}

                <div class="col-md-2 d-flex align-items-end">

                    <button
                        type="submit"
                        class="btn btn-secondary w-100"
                    >
                        بحث
                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


{{-- جدول الحضور --}}

<div class="card">

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-striped align-middle">

                <thead>

                    <tr>

                        <th>الموظف</th>
                        <th>التاريخ</th>
                        <th>الحالة</th>
                        <th>وقت الدخول</th>
                        <th>وقت الخروج</th>
                        <th>دقائق التأخير</th>
                        <th>الخروج المبكر</th>
                        <th>الإجراءات</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($attendances as $attendance)

                        <tr>

                            <td>
                                {{ $attendance->employee?->full_name ?? '-' }}
                            </td>


                            <td>
                                {{ optional($attendance->attendance_date)->format('Y-m-d') ?? '-' }}
                            </td>


                            <td>

                                @php

                                    $statusLabels = [
                                        'present' => 'حاضر',
                                        'absent' => 'غائب',
                                        'late' => 'متأخر',
                                        'leave' => 'إجازة',
                                        'permission' => 'استئذان',
                                        'half_day' => 'نصف يوم',
                                    ];

                                @endphp

                                {{ $statusLabels[$attendance->status] ?? $attendance->status }}

                            </td>


                            <td>
                                {{ $attendance->check_in ?? '-' }}
                            </td>


                            <td>
                                {{ $attendance->check_out ?? '-' }}
                            </td>


                            <td>
                                {{ $attendance->late_minutes ?? 0 }}
                            </td>


                            <td>
                                {{ $attendance->early_leave_minutes ?? 0 }}
                            </td>


                            <td>

                                <a
                                    href="{{ route('employee-attendances.show', $attendance) }}"
                                    class="btn btn-info btn-sm"
                                >
                                    عرض
                                </a>


                                <a
                                    href="{{ route('employee-attendances.edit', $attendance) }}"
                                    class="btn btn-warning btn-sm"
                                >
                                    تعديل
                                </a>


                                <form
                                    action="{{ route('employee-attendances.destroy', $attendance) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('هل أنت متأكد من حذف سجل الحضور؟');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                    >
                                        حذف
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="8"
                                class="text-center text-muted py-4"
                            >
                                لا توجد سجلات حضور.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


{{-- Pagination --}}

<div class="mt-3">

    {{ $attendances->links() }}

</div>

@endsection

