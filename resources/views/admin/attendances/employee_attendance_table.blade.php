{{-- فلترة الحضور --}}

<div class="card mb-4">

    <div class="card-body">

        <form method="GET" class="row g-2">

            <div class="col-md-4">

                <label for="date_from" class="form-label">
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

                <label for="date_to" class="form-label">
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

</div>


{{-- سجل الحضور والغياب --}}

<div class="card">

    <div class="card-header bg-light">

        <h5 class="mb-0">
            سجل الحضور والغياب
        </h5>

    </div>


    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-hover table-bordered mb-0">

                <thead>

                    <tr>

                        <th>التاريخ</th>

                        <th>وقت الحضور</th>

                        <th>وقت الانصراف</th>

                        <th>الحالة</th>

                        <th>دقائق التأخير</th>

                        <th>الخروج المبكر</th>

                        <th>ملاحظات</th>

                    </tr>

                </thead>


                <tbody>

                    @forelse($attendances as $attendance)

                        <tr>

                            {{-- التاريخ --}}

                            <td>
                                {{ optional($attendance->attendance_date)->format('Y-m-d') ?? '-' }}
                            </td>


                            {{-- وقت الحضور --}}

                            <td>
                                {{ $attendance->check_in ?? '-' }}
                            </td>


                            {{-- وقت الانصراف --}}

                            <td>
                                {{ $attendance->check_out ?? '-' }}
                            </td>


                            {{-- الحالة --}}

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


                            {{-- دقائق التأخير --}}

                            <td>
                                {{ $attendance->late_minutes ?? 0 }}
                            </td>


                            {{-- الخروج المبكر --}}

                            <td>
                                {{ $attendance->early_leave_minutes ?? 0 }}
                            </td>


                            {{-- الملاحظات --}}

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

