@extends('layouts.admin')

@section('title', 'الموظفون')

@section('content')

<h1>قائمة الموظفين</h1>

<a href="{{ route('employees.create') }}">
    إضافة موظف جديد
</a>

<br><br>

<a href="{{ route('employees.import.create') }}">
    استيراد الموظفين من Excel
</a>

<br><br>

<a href="{{ route('employees.export', request()->query()) }}">
    تصدير الموظفين إلى Excel
</a>

<br><br>

<form method="GET" action="{{ route('employees.index') }}">

    <div>
        <label>البحث بالاسم الكامل</label>

        <input
            type="text"
            name="full_name"
            value="{{ request('full_name') }}"
        >
    </div>

    <br>

    <div>
        <label>البحث بالسجل المدني</label>

        <input
            type="text"
            name="national_id"
            value="{{ request('national_id') }}"
        >
    </div>

    <br>

    <div>
        <label>البحث برقم الجوال</label>

        <input
            type="text"
            name="mobile"
            value="{{ request('mobile') }}"
        >
    </div>

    <br>

    <div>
        <label>البنك</label>

        <select name="bank_id">

            <option value="">
                جميع البنوك
            </option>

            @foreach($banks as $bank)

                <option
                    value="{{ $bank->id }}"
                    @selected(request('bank_id') == $bank->id)
                >
                    {{ $bank->name }}
                </option>

            @endforeach

        </select>
    </div>

    <br>

    <div>
        <label>المسمى الوظيفي</label>

        <select name="job_title_id">

            <option value="">
                جميع المسميات الوظيفية
            </option>

            @foreach($jobTitles as $jobTitle)

                <option
                    value="{{ $jobTitle->id }}"
                    @selected(request('job_title_id') == $jobTitle->id)
                >
                    {{ $jobTitle->name }}
                </option>

            @endforeach

        </select>
    </div>

    <br>

    <div>
        <label>الحالة الاجتماعية</label>

        <select name="marital_status_id">

            <option value="">
                جميع الحالات الاجتماعية
            </option>

            @foreach($maritalStatuses as $status)

                <option
                    value="{{ $status->id }}"
                    @selected(request('marital_status_id') == $status->id)
                >
                    {{ $status->name }}
                </option>

            @endforeach

        </select>
    </div>

    <br>

    <div>
        <label>جهة العمل</label>

        <input
            type="text"
            name="workplace"
            value="{{ request('workplace') }}"
        >
    </div>

    <br>

    <button type="submit">
        بحث وفلترة
    </button>

    <a href="{{ route('employees.index') }}">
        مسح الفلاتر
    </a>

</form>

<br>

<table>

    <thead>

        <tr>
            <th>#</th>
            <th>الاسم الكامل</th>
            <th>السجل المدني</th>
            <th>رقم الجوال</th>
            <th>جهة العمل</th>
            <th>البنك</th>
            <th>المسمى الوظيفي</th>
            <th>الحالة الاجتماعية</th>
            <th>الإجراءات</th>
        </tr>

    </thead>

    <tbody>

    @forelse($employees as $employee)

        <tr>

            <td>
                {{ $employee->id }}
            </td>

            <td>
                {{ $employee->full_name }}
            </td>

            <td>
                {{ $employee->national_id }}
            </td>

            <td>
                {{ $employee->mobile ?? '-' }}
            </td>

            <td>

                {{ $employee->workplace_1 ?? '-' }}

                @if($employee->workplace_2)

                    <br>

                    {{ $employee->workplace_2 }}

                @endif

            </td>

            <td>
                {{ $employee->bank?->name ?? '-' }}
            </td>

            <td>
                {{ $employee->jobTitle?->name ?? '-' }}
            </td>

            <td>
                {{ $employee->maritalStatus?->name ?? '-' }}
            </td>

            <td>

                <a href="{{ route('employees.show', $employee) }}">
                    عرض
                </a>

                |

                <a href="{{ route('employees.edit', $employee) }}">
                    تعديل
                </a>

                |

                <form
                    action="{{ route('employees.destroy', $employee) }}"
                    method="POST"
                    style="display:inline"
                    onsubmit="return confirm('هل أنت متأكد من حذف الموظف؟')"
                >

                    @csrf

                    @method('DELETE')

                    <button type="submit">
                        حذف
                    </button>

                </form>

            </td>

        </tr>

    @empty

        <tr>

            <td colspan="9">
                لا توجد نتائج مطابقة.
            </td>

        </tr>

    @endforelse

    </tbody>

</table>

<br>

{{ $employees->links() }}

@endsection