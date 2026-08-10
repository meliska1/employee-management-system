```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->id();

            // الموظف
            $table->foreignId('employee_id')
                ->constrained('employees')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            // تاريخ الحضور
            $table->date('attendance_date');

            // وقت الحضور والانصراف
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();

            // حالة الحضور
            $table->enum('status', [
                'present',
                'absent',
                'late',
                'leave',
                'permission',
                'half_day',
            ]);

            // دقائق التأخير والانصراف المبكر
            $table->unsignedInteger('late_minutes')->default(0);
            $table->unsignedInteger('early_leave_minutes')->default(0);

            // ملاحظات
            $table->text('notes')->nullable();

            // المستخدم الذي أنشأ/عدّل السجل
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // التواريخ
            $table->timestamps();

            // الحذف الناعم
            $table->softDeletes();

            // منع تسجيل حضور نفس الموظف أكثر من مرة في نفس اليوم
            $table->unique([
                'employee_id',
                'attendance_date'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_attendances');
    }
};

