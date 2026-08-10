@extends('layouts.admin')

@section('title', 'إضافة موظف')

@section('content')

@if ($errors->any())

    @foreach ($errors->all() as $error)
        {{ $error }}
    @endforeach

@endif

<div>
    <label>الاسم الكامل</label><br>
    <input
        type="text"
        name="full_name"
        value="{{ old('full_name') }}"
    >
</div>

<br>

<div>
    <label>رقم السجل المدني</label><br>
    <input
        type="text"
        name="national_id"
        value="{{ old('national_id') }}"
    >
</div>

<br>

<div>
    <label>تاريخ الميلاد</label><br>
    <input
        type="date"
        name="birth_date"
        value="{{ old('birth_date') }}"
    >
</div>

<br>

<div>
    <label>الحالة الاجتماعية</label><br>
    <select name="marital_status_id">
        <option value="">اختر الحالة الاجتماعية</option>

        @foreach ($maritalStatuses as $status)
            <option
                value="{{ $status->id }}"
                @selected(old('marital_status_id') == $status->id)
            >
                {{ $status->name }}
            </option>
        @endforeach
    </select>
</div>

<br>

<div>
    <label>رقم الجوال</label><br>
    <input
        type="text"
        name="mobile"
        value="{{ old('mobile') }}"
    >
</div>

<br>

<div>
    <label>المؤهل العلمي</label><br>
    <input
        type="text"
        name="qualification"
        value="{{ old('qualification') }}"
    >
</div>

<br>

<div>
    <label>تاريخ المؤهل</label><br>
    <input
        type="date"
        name="qualification_date"
        value="{{ old('qualification_date') }}"
    >
</div>

<br>

<div>
    <label>رقم الآيبان</label><br>
    <input
        type="text"
        name="iban"
        value="{{ old('iban') }}"
    >
</div>

<br>

<div>
    <label>البنك</label><br>
    <select name="bank_id">
        <option value="">اختر البنك</option>

        @foreach ($banks as $bank)
            <option
                value="{{ $bank->id }}"
                @selected(old('bank_id') == $bank->id)
            >
                {{ $bank->name }}
            </option>
        @endforeach
    </select>
</div>

<br>

<div>
    <label>المسمى الوظيفي</label><br>
    <select name="job_title_id">
        <option value="">اختر المسمى الوظيفي</option>

        @foreach ($jobTitles as $jobTitle)
            <option
                value="{{ $jobTitle->id }}"
                @selected(old('job_title_id') == $jobTitle->id)
            >
                {{ $jobTitle->name }}
            </option>
        @endforeach
    </select>
</div>

<br>

<div>
    <label>تاريخ بداية العمل</label><br>
    <input
        type="date"
        name="start_work_date"
        value="{{ old('start_work_date') }}"
    >
</div>

<br>

<div>
    <label>اسم المدير المباشر</label><br>
    <input
        type="text"
        name="direct_manager_name"
        value="{{ old('direct_manager_name') }}"
    >
</div>

<br>

<div>
    <label>جهة العمل الأولى</label><br>
    <input
        type="text"
        name="workplace_1"
        value="{{ old('workplace_1') }}"
    >
</div>

<br>

<div>
    <label>جهة العمل الثانية</label><br>
    <input
        type="text"
        name="workplace_2"
        value="{{ old('workplace_2') }}"
    >
</div>

<br>

<button type="submit">
    حفظ الموظف
</button>

<a href="{{ route('employees.index') }}">
    رجوع
</a>

@endsection