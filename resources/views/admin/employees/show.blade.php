<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>بيانات الموظف</title>
</head>
<body>

<h1>بيانات الموظف</h1>

<p><strong>الاسم الكامل:</strong> {{ $employee->full_name }}</p>

<p><strong>رقم السجل المدني:</strong> {{ $employee->national_id }}</p>

<p><strong>تاريخ الميلاد:</strong> {{ optional($employee->birth_date)->format('Y-m-d') }}</p>

<p><strong>الحالة الاجتماعية:</strong> {{ $employee->maritalStatus->name }}</p>

<p><strong>رقم الجوال:</strong> {{ $employee->mobile }}</p>

<p><strong>المؤهل العلمي:</strong> {{ $employee->qualification }}</p>

<p><strong>تاريخ المؤهل:</strong>
    {{ optional($employee->qualification_date)->format('Y-m-d') }}
</p>

<p><strong>رقم الآيبان:</strong> {{ $employee->iban }}</p>

<p><strong>البنك:</strong> {{ $employee->bank->name }}</p>

<p><strong>المسمى الوظيفي:</strong> {{ $employee->jobTitle->name }}</p>

<p><strong>تاريخ بداية العمل:</strong>
    {{ optional($employee->start_work_date)->format('Y-m-d') }}
</p>

<p><strong>اسم المدير المباشر:</strong> {{ $employee->direct_manager_name }}</p>

<p><strong>جهة العمل الأولى:</strong> {{ $employee->workplace_1 }}</p>

<p><strong>جهة العمل الثانية:</strong> {{ $employee->workplace_2 }}</p>

<a href="{{ route('employees.index') }}">
    رجوع
</a>

@include('admin.attendances.employee_attendance_table')

</body>
</html>