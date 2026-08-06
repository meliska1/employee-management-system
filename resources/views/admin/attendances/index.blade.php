@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Attendance List</h2>

    <a href="{{ route('attendances.create') }}" class="btn btn-primary mb-3">
        Add Attendance
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Employee</th>
                <th>Date</th>
                <th>Status</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->employee->full_name ?? '' }}</td>
                    <td>{{ $attendance->attendance_date }}</td>
                    <td>{{ $attendance->status }}</td>
                    <td>{{ $attendance->check_in }}</td>
                    <td>{{ $attendance->check_out }}</td>
                    <td>
                        <a href="{{ route('attendances.edit', $attendance->id) }}" class="btn btn-warning btn-sm">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection