@extends('layouts.admin')

@section('title', 'استيراد الموظفين')

@section('content')

<h1>استيراد الموظفين من Excel</h1>

@if (session('success'))
    <div class="success">
        {{ session('success') }}

        <br>

        عدد الصفوف التي تم استيرادها:
        {{ session('imported_count', 0) }}

        <br>

        عدد الصفوف التي تحتوي على أخطاء:
        {{ session('failed_count', 0) }}
    </div>
@endif

@if (session('error'))
    <div class="error">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="error">
        <ul>
            @foreach ($errors->all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>
@endif

<form
    method="POST"
    action="{{ route('employees.import.store') }}"
    enctype="multipart/form-data"
>

    @csrf

    <div>
        <label for="file">
            اختاري ملف Excel
        </label>

        <br><br>

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

    <br>

    <h2>
        تقرير أخطاء الاستيراد
    </h2>

    <table>

        <thead>
            <tr>
                <th>رقم الصف</th>
                <th>اسم الحقل</th>
                <th>سبب الخطأ</th>
            </tr>
        </thead>

        <tbody>

            @foreach (session('import_errors') as $importError)

                @php
                    $errorMessages = $importError['errors'] ?? [];
                @endphp

                @forelse ($errorMessages as $field => $messages)

                    @php
                        $messages = is_array($messages)
                            ? $messages
                            : [$messages];
                    @endphp

                    @foreach ($messages as $message)

                        <tr>
                            <td>
                                {{ $importError['row'] ?? '-' }}
                            </td>

                            <td>
                                {{ $field }}
                            </td>

                            <td>
                                {{ $message }}
                            </td>
                        </tr>

                    @endforeach

                @empty

                    <tr>
                        <td>
                            {{ $importError['row'] ?? '-' }}
                        </td>

                        <td>
                            -
                        </td>

                        <td>
                            لا يوجد وصف للخطأ.
                        </td>
                    </tr>

                @endforelse

            @endforeach

        </tbody>

    </table>

@endif

@endsection