@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Attendance</h2>

    <form action="{{ route('attendances.update', $attendance->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Employee</label>
            <select name="employee_id" class="form-control">
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}"
                        {{ $attendance->employee_id == $employee->id ? 'selected' : '' }}>
                        {{ $employee->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="attendance_date"
                value="{{ $attendance->attendance_date }}"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="present" {{ $attendance->status == 'present' ? 'selected' : '' }}>Present</option>
                <option value="absent" {{ $attendance->status == 'absent' ? 'selected' : '' }}>Absent</option>
                <option value="late" {{ $attendance->status == 'late' ? 'selected' : '' }}>Late</option>
                <option value="leave" {{ $attendance->status == 'leave' ? 'selected' : '' }}>Leave</option>
                <option value="permission" {{ $attendance->status == 'permission' ? 'selected' : '' }}>Permission</option>
                <option value="day_half" {{ $attendance->status == 'day_half' ? 'selected' : '' }}>Half Day</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Check In</label>
            <input type="time" name="check_in"
                value="{{ $attendance->check_in }}"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Check Out</label>
            <input type="time" name="check_out"
                value="{{ $attendance->check_out }}"
                class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">
            Update
        </button>
    </form>
</div>
@endsection