<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>بيانات الموظف</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

<div class="container py-4">

    {{-- عنوان الصفحة --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1>
            بيانات الموظف
        </h1>

        <a
            href="{{ route('employees.index') }}"
            class="btn btn-secondary"
        >
            رجوع
        </a>

    </div>


    {{-- بيانات الموظف --}}

    <div class="card mb-4">

        <div class="card-header bg-primary text-white">

            <h5 class="mb-0">
                المعلومات الأساسية
            </h5>

        </div>


        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-6">
                    <strong>الاسم الكامل:</strong>
                    {{ $employee->full_name }}
                </div>

                <div class="col-md-6">
                    <strong>رقم السجل المدني:</strong>
                    {{ $employee->national_id }}
                </div>

                <div class="col-md-6">
                    <strong>تاريخ الميلاد:</strong>
                    {{ optional($employee->birth_date)->format('Y-m-d') ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>الحالة الاجتماعية:</strong>
                    {{ $employee->maritalStatus?->name ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>رقم الجوال:</strong>
                    {{ $employee->mobile ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>المؤهل العلمي:</strong>
                    {{ $employee->qualification ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>تاريخ المؤهل:</strong>
                    {{ optional($employee->qualification_date)->format('Y-m-d') ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>رقم الآيبان:</strong>
                    {{ $employee->iban ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>البنك:</strong>
                    {{ $employee->bank?->name ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>المسمى الوظيفي:</strong>
                    {{ $employee->jobTitle?->name ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>تاريخ بداية العمل:</strong>
                    {{ optional($employee->start_work_date)->format('Y-m-d') ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>اسم المدير المباشر:</strong>
                    {{ $employee->direct_manager_name ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>جهة العمل الأولى:</strong>
                    {{ $employee->workplace_1 ?? '-' }}
                </div>

                <div class="col-md-6">
                    <strong>جهة العمل الثانية:</strong>
                    {{ $employee->workplace_2 ?? '-' }}
                </div>

            </div>

        </div>

    </div>


    {{-- سجل الحضور --}}

    <div class="card">

        <div class="card-header bg-light">

            <h5 class="mb-0">
                سجل الحضور والغياب
            </h5>

        </div>


        {{-- فلترة الحضور --}}

        <div class="card-body border-bottom">

            <form
                method="GET"
                class="row g-2"
            >

                <div class="col-md-4">

                    <label
                        for="date_from"
                        class="form-label"
                    >
                        من تاريخ
                    </label>

                    <input
                        type="date"
                        name="date_from"
                        id="date_from"
                        class="form-control"
                        value="{{ request('date_from') }}"
                    >

                </div>


                <div class="col-md-4">

                    <label
                        for="date_to"
                        class="form-label"
                    >
                        إلى تاريخ
                    </label>

                    <input
                        type="date"
                        name="date_to"
                        id="date_to"
                        class="form-control"
                        value="{{ request('date_to') }}"
                    >

                </div>


                <div class="col-md-4 d-flex align-items-end gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary flex-grow-1"
                    >
                        بحث / فلترة
                    </button>


                    <a
                        href="{{ url()->current() }}"
                        class="btn btn-secondary"
                    >
                        إعادة تعيين
                    </a>

                </div>

            </form>

        </div>


        {{-- جدول الحضور --}}

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-bordered mb-0">

                    <thead>

                        <tr>

                            <th>
                                التاريخ
                            </th>

                            <th>
                                وقت الحضور
                            </th>

                            <th>
                                وقت الانصراف
                            </th>

                            <th>
                                الحالة
                            </th>

                            <th>
                                دقائق التأخير
                            </th>

                            <th>
                                الخروج المبكر
                            </th>

                            <th>
                                ملاحظات
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($attendances as $attendance)

                            <tr>

                                <td>
                                    {{ optional($attendance->attendance_date)->format('Y-m-d') ?? '-' }}
                                </td>

                                <td>
                                    {{ $attendance->check_in ?? '-' }}
                                </td>

                                <td>
                                    {{ $attendance->check_out ?? '-' }}
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


                                    <span class="badge bg-info">

                                        {{ $statusLabels[$attendance->status] ?? $attendance->status }}

                                    </span>

                                </td>


                                <td>
                                    {{ $attendance->late_minutes ?? 0 }}
                                </td>


                                <td>
                                    {{ $attendance->early_leave_minutes ?? 0 }}
                                </td>


                                <td>
                                    {{ $attendance->notes ?? '-' }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted py-4"
                                >
                                    لا توجد سجلات حضور لهذا الموظف حتى الآن.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

</body>

</html>