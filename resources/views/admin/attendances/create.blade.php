@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إضافة سجل حضور</h2>

        <a href="{{ route('employee-attendances.index') }}"
           class="btn btn-secondary">
            العودة لسجلات الحضور
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('employee-attendances.store') }}" method="POST">

        @csrf

        {{-- الموظف --}}
        <div class="mb-3">
            <label for="employee_id" class="form-label">
                الموظف
            </label>

            <select
                name="employee_id"
                id="employee_id"
                class="form-select @error('employee_id') is-invalid @enderror"
                required
            >
                <option value="">اختر الموظف</option>

                @foreach($employees as $employee)
                    <option
                        value="{{ $employee->id }}"
                        {{ old('employee_id') == $employee->id ? 'selected' : '' }}
                    >
                        {{ $employee->full_name }}
                    </option>
                @endforeach
            </select>

            @error('employee_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- التاريخ --}}
        <div class="mb-3">
            <label for="attendance_date" class="form-label">
                تاريخ الحضور
            </label>

            <input
                type="date"
                name="attendance_date"
                id="attendance_date"
                class="form-control @error('attendance_date') is-invalid @enderror"
                value="{{ old('attendance_date', now()->format('Y-m-d')) }}"
                required
            >

            @error('attendance_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- الحالة --}}
        <div class="mb-3">
            <label for="status" class="form-label">
                حالة الحضور
            </label>

            <select
                name="status"
                id="status"
                class="form-select @error('status') is-invalid @enderror"
                required
            >
                <option value="">اختر الحالة</option>

                <option value="present" {{ old('status') === 'present' ? 'selected' : '' }}>
                    حاضر
                </option>

                <option value="absent" {{ old('status') === 'absent' ? 'selected' : '' }}>
                    غائب
                </option>

                <option value="late" {{ old('status') === 'late' ? 'selected' : '' }}>
                    متأخر
                </option>

                <option value="leave" {{ old('status') === 'leave' ? 'selected' : '' }}>
                    إجازة
                </option>

                <option value="permission" {{ old('status') === 'permission' ? 'selected' : '' }}>
                    استئذان
                </option>

                <option value="half_day" {{ old('status') === 'half_day' ? 'selected' : '' }}>
                    نصف يوم
                </option>
            </select>

            @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- وقت الدخول --}}
        <div class="mb-3">
            <label for="check_in" class="form-label">
                وقت الدخول
            </label>

            <input
                type="time"
                name="check_in"
                id="check_in"
                class="form-control @error('check_in') is-invalid @enderror"
                value="{{ old('check_in') }}"
            >

            @error('check_in')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- وقت الخروج --}}
        <div class="mb-3">
            <label for="check_out" class="form-label">
                وقت الخروج
            </label>

            <input
                type="time"
                name="check_out"
                id="check_out"
                class="form-control @error('check_out') is-invalid @enderror"
                value="{{ old('check_out') }}"
            >

            @error('check_out')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- دقائق التأخير --}}
        <div class="mb-3">
            <label for="late_minutes" class="form-label">
                دقائق التأخير
            </label>

            <input
                type="number"
                name="late_minutes"
                id="late_minutes"
                class="form-control @error('late_minutes') is-invalid @enderror"
                value="{{ old('late_minutes', 0) }}"
                min="0"
            >

            @error('late_minutes')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- دقائق الخروج المبكر --}}
        <div class="mb-3">
            <label for="early_leave_minutes" class="form-label">
                دقائق الخروج المبكر
            </label>

            <input
                type="number"
                name="early_leave_minutes"
                id="early_leave_minutes"
                class="form-control @error('early_leave_minutes') is-invalid @enderror"
                value="{{ old('early_leave_minutes', 0) }}"
                min="0"
            >

            @error('early_leave_minutes')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- الملاحظات --}}
        <div class="mb-3">
            <label for="notes" class="form-label">
                ملاحظات
            </label>

            <textarea
                name="notes"
                id="notes"
                class="form-control @error('notes') is-invalid @enderror"
                rows="4"
            >{{ old('notes') }}</textarea>

            @error('notes')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">
            حفظ سجل الحضور
        </button>

        <a
            href="{{ route('employee-attendances.index') }}"
            class="btn btn-secondary"
        >
            إلغاء
        </a>

    </form>

</div>

@endsection