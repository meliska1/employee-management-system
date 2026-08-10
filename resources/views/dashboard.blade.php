
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>لوحة التحكم | نظام إدارة الموظفين</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        body {
            margin: 0;
            font-family: Tahoma, Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        * {
            box-sizing: border-box;
        }

        .navbar {
            background: linear-gradient(135deg, #123a63, #1d5d96);
            color: white;
            padding: 18px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 18px rgba(18, 58, 99, 0.22);
        }

        .navbar h1 {
            margin: 0;
            font-size: 25px;
        }

        .admin-box {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 14px;
        }

        .page {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 24px;
        }

        .welcome {
            background: white;
            border-radius: 18px;
            padding: 30px;
            box-shadow: 0 8px 24px rgba(30, 64, 175, 0.08);
            margin-bottom: 30px;
            border-right: 6px solid #1d5d96;
        }

        .welcome h2 {
            margin: 0 0 12px;
            font-size: 28px;
            color: #123a63;
        }

        .welcome p {
            margin: 0;
            color: #64748b;
            font-size: 16px;
            line-height: 1.8;
        }

        .section-title {
            font-size: 22px;
            color: #123a63;
            margin: 0 0 20px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .stat-card {
            background: white;
            border-radius: 18px;
            padding: 24px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            border-top: 5px solid #1d5d96;
        }

        .stat-title {
            color: #64748b;
            margin-bottom: 10px;
            font-size: 15px;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #123a63;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .card {
            background: white;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
            transition: 0.25s;
            border-top: 5px solid #1d5d96;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.14);
        }

        .card-icon {
            width: 58px;
            height: 58px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 29px;
            margin-bottom: 18px;
            background: #eaf3fb;
        }

        .card h3 {
            margin: 0 0 10px;
            font-size: 21px;
            color: #123a63;
        }

        .card p {
            margin: 0 0 22px;
            color: #64748b;
            line-height: 1.7;
            min-height: 54px;
        }

        .card a {
            display: inline-block;
            text-decoration: none;
            background: #1d5d96;
            color: white;
            padding: 10px 20px;
            border-radius: 9px;
            transition: 0.2s;
        }

        .card a:hover {
            background: #123a63;
        }

        .quick-access {
            background: white;
            margin-top: 30px;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
        }

        .quick-links {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .quick-links a {
            text-decoration: none;
            background: #eef5fb;
            color: #123a63;
            border: 1px solid #cbddee;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.2s;
        }

        .quick-links a:hover {
            background: #1d5d96;
            color: white;
        }

        footer {
            text-align: center;
            padding: 30px 15px;
            color: #64748b;
            font-size: 14px;
        }

        @media (max-width: 900px) {

            .stats,
            .cards {
                grid-template-columns: 1fr;
            }

            .navbar {
                padding: 18px 20px;
            }

            .navbar h1 {
                font-size: 20px;
            }
        }

    </style>

</head>


<body>

    {{-- شريط التنقل --}}

    <nav class="navbar">

        <h1>
            نظام إدارة الموظفين
        </h1>

        <div class="admin-box">
            المستخدم: مدير النظام
        </div>

    </nav>


    {{-- محتوى الصفحة --}}

    <main class="page">

        {{-- الترحيب --}}

        <section class="welcome">

            <h2>
                مرحبًا بك في لوحة التحكم
            </h2>

            <p>
                يمكنك من خلال هذه الصفحة إدارة بيانات الموظفين
                ومتابعة الحضور والانصراف والتقارير.
            </p>

        </section>


        {{-- الإحصائيات --}}

        <h2 class="section-title">
            إحصائيات اليوم
        </h2>


        <section class="stats">

            <div class="stat-card">

                <div class="stat-title">
                    إجمالي الموظفين
                </div>

                <div class="stat-number">
                    {{ $totalEmployees }}
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-title">
                    الحاضرون اليوم
                </div>

                <div class="stat-number">
                    {{ $todayPresent }}
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-title">
                    الغائبون اليوم
                </div>

                <div class="stat-number">
                    {{ $todayAbsent }}
                </div>

            </div>


            <div class="stat-card">

                <div class="stat-title">
                    المتأخرون اليوم
                </div>

                <div class="stat-number">
                    {{ $todayLate }}
                </div>

            </div>

        </section>


        {{-- أقسام النظام --}}

        <h2 class="section-title">
            أقسام النظام
        </h2>


        <section class="cards">

            {{-- الموظفين --}}

            <article class="card">

                <div class="card-icon">
                    👥
                </div>

                <h3>
                    إدارة الموظفين
                </h3>

                <p>
                    إضافة الموظفين وعرض بياناتهم وتعديلها وتنظيم ملفاتهم داخل النظام.
                </p>

                <a href="{{ route('employees.index') }}">
                    فتح القسم
                </a>

            </article>


            {{-- الحضور --}}

            <article class="card">

                <div class="card-icon">
                    📅
                </div>

                <h3>
                    الحضور والانصراف
                </h3>

                <p>
                    متابعة سجلات حضور الموظفين والغياب والتأخير والإجازات اليومية.
                </p>

                <a href="{{ route('employee-attendances.index') }}">
                    فتح القسم
                </a>

            </article>


            {{-- التقارير --}}

            <article class="card">

                <div class="card-icon">
                    📄
                </div>

                <h3>
                    تقارير الموظفين
                </h3>

                <p>
                    استعراض بيانات الموظفين وإمكانية تصدير البيانات حسب الحاجة.
                </p>

                <a href="{{ route('employees.index') }}">
                    فتح القسم
                </a>

            </article>

        </section>


        {{-- الوصول السريع --}}

        <section class="quick-access">

            <h2 class="section-title">
                الوصول السريع
            </h2>


            <div class="quick-links">

                <a href="{{ route('employees.create') }}">
                    إضافة موظف جديد
                </a>


                <a href="{{ route('employees.index') }}">
                    عرض قائمة الموظفين
                </a>


                <a href="{{ route('employee-attendances.create') }}">
                    تسجيل الحضور
                </a>


                <a href="{{ route('employee-attendances.index') }}">
                    عرض سجلات الحضور
                </a>

            </div>

        </section>

    </main>


    <footer>

        جميع الحقوق محفوظة © {{ date('Y') }}
        — نظام إدارة الموظفين

    </footer>

</body>

</html>

