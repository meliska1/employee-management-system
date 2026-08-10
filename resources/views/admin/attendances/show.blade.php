
@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <h2>تفاصيل سجل الحضور</h2>

    <div>

        <a href="{{ route('employee-attendances.edit', $attendance) }}"
           class="btn btn-warning">
            تعديل
        </a>

        <a href="{{ route('employee-attendances.index') }}"
           class="btn btn-secondary">
            العودة لسجلات الحضور
        </a>

    </div>

</div>


<div class="card">

    <div class="card-header bg-light">

        <h5 class="mb-0">
            معلومات سجل الحضور
        </h5>

    </div>


    <div class="card-body">

        <div class="row g-4">

            {{-- الموظف --}}
            <div class="col-md-6">

                <strong>
                    الموظف
                </strong>

                <div class="mt-1">
                    {{ $attendance->employee?->full_name ?? '-' }}
                </div>

            </div>


            {{-- التاريخ --}}
            <div class="col-md-6">

                <strong>
                    التاريخ
                </strong>

                <div class="mt-1">
                    {{ optional($attendance->attendance_date)->format('Y-m-d') ?? '-' }}
                </div>

            </div>


            {{-- الحالة --}}
            <div class="col-md-6">

                <strong>
                    الحالة
                </strong>

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

                <div class="mt-1">

                    <span class="badge bg-info">
                        {{ $statusLabels[$attendance->status] ?? $attendance->status }}
                    </span>

                </div>

            </div>


            {{-- وقت الدخول --}}
            <div class="col-md-6">

                <strong>
                    وقت الدخول
                </strong>

                <div class="mt-1">
                    {{ $attendance->check_in ?? '-' }}
                </div>

            </div>


            {{-- وقت الخروج --}}
            <div class="col-md-6">

                <strong>
                    وقت الخروج
                </strong>

                <div class="mt-1">
                    {{ $attendance->check_out ?? '-' }}
                </div>

            </div>


            {{-- دقائق التأخير --}}
            <div class="col-md-6">

                <strong>
                    دقائق التأخير
                </strong>

                <div class="mt-1">
                    {{ $attendance->late_minutes ?? 0 }}
                    دقيقة
                </div>

            </div>


            {{-- الخروج المبكر --}}
            <div class="col-md-6">

                <strong>
                    دقائق الخروج المبكر
                </strong>

                <div class="mt-1">
                    {{ $attendance->early_leave_minutes ?? 0 }}
                    دقيقة
                </div>

            </div>


            {{-- الملاحظات --}}
            <div class="col-md-12">

                <strong>
                    الملاحظات
                </strong>

                <div class="mt-2 p-3 bg-light rounded">

                    {{ $attendance->notes ?? 'لا توجد ملاحظات.' }}

                </div>

            </div>

        </div>

    </div>

</div>


{{-- حذف السجل --}}
<div class="mt-3">

    <form
        action="{{ route('employee-attendances.destroy', $attendance) }}"
        method="POST"
        onsubmit="return confirm('هل أنت متأكد من حذف سجل الحضور؟');"
    >

        @csrf
        @method('DELETE')

        <button type="submit"
                class="btn btn-danger">
            حذف سجل الحضور
        </button>

    </form>

</div>

@endsection

