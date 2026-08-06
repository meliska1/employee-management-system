@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Attendance</h2>

    <form action="{{ route('attendances.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Employee</label>
            <select name="employee_id" class="form-control">
                @foreach ($employees as $employee)
                    <option value="{{ $employee->id }}">
                        {{ $employee->full_name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="attendance_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="present">Present</option>
                <option value="absent">Absent</option>
                <option value="late">Late</option>
                <option value="leave">Leave</option>
                <option value="permission">Permission</option>
                <option value="day_half">Half Day</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Check In</label>
            <input type="time" name="check_in" class="form-control">
        </div>

        <div class="mb-3">
            <label>Check Out</label>
            <input type="time" name="check_out" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">
            Save
        </button>
    </form>
</div>
@endsection