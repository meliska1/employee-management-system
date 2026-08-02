<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>استيراد الموظفين</title>
</head>
<body>

<h1>استيراد الموظفين من Excel</h1>

@if (session('success'))
    <div style="color: green;">
        <p>{{ session('success') }}</p>
        <p>عدد الصفوف التي تم استيرادها: {{ session('imported_count', 0) }}</p>
        <p>عدد الصفوف التي تحتوي على أخطاء: {{ session('failed_count', 0) }}</p>
    </div>
@endif

@if (session('error'))
    <div style="color: red;">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form
    action="{{ route('employees.import.store') }}"
    method="POST"
    enctype="multipart/form-data"
>
    @csrf

    <div>
        <label for="file">اختاري ملف Excel</label><br><br>

        <input
            type="file"
            id="file"
            name="file"
            accept=".xlsx,.xls,.csv"
            required
        >
    </div>

    <br>

    <button type="submit">
        بدء الاستيراد
    </button>

    <a href="{{ route('employees.index') }}">
        رجوع إلى قائمة الموظفين
    </a>
</form>

@if (session('import_errors') && count(session('import_errors')) > 0)
    <hr>

    <h2>تقرير أخطاء الاستيراد</h2>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>رقم الصف</th>
                <th>رقم السجل المدني</th>
                <th>سبب الخطأ</th>
            </tr>
        </thead>

        <tbody>
            @foreach (session('import_errors') as $importError)
                <tr>
                    <td>{{ $importError['row'] ?? '-' }}</td>
                    <td>{{ $importError['national_id'] ?? '-' }}</td>
                    <td>
                        <ul>
                            @foreach (($importError['errors'] ?? []) as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</body>
</html>