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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();

            $table->string('full_name');
            $table->string('national_id')->unique();
            $table->date('birth_date')->nullable();

            $table->foreignId('marital_status_id')
                ->constrained('marital_statuses')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->string('mobile')->nullable();
            $table->string('qualification')->nullable();
            $table->date('qualification_date')->nullable();
            $table->string('iban')->nullable();

            $table->foreignId('bank_id')
                ->constrained('banks')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignId('job_title_id')
                ->constrained('job_titles')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->date('start_work_date')->nullable();
            $table->string('direct_manager_name')->nullable();
            $table->string('workplace_1')->nullable();
            $table->string('workplace_2')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};