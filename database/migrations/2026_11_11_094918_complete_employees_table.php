<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employees', function (Blueprint $table) {

            if (!Schema::hasColumn('employees', 'employee_number')) {
                $table->string('employee_number')->nullable()->unique();
            }

            if (!Schema::hasColumn('employees', 'applicant_id')) {
                $table->foreignId('applicant_id')
                    ->nullable()
                    ->unique()
                    ->constrained('applicants')
                    ->restrictOnDelete();
            }

            if (!Schema::hasColumn('employees', 'user_id')) {
                $table->foreignId('user_id')
                    ->nullable()
                    ->unique()
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('employees', 'department_id')) {
                $table->foreignId('department_id')
                    ->nullable()
                    ->constrained('departments')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('employees', 'position_id')) {
                $table->foreignId('position_id')
                    ->nullable()
                    ->constrained('positions')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('employees', 'join_date')) {
                $table->date('join_date')->nullable();
            }

            if (!Schema::hasColumn('employees', 'employment_status')) {
                $table->string('employment_status')
                    ->default('active');
            }
        });
    }

    public function down(): void
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropConstrainedForeignId('position_id');
            $table->dropConstrainedForeignId('department_id');
            $table->dropConstrainedForeignId('user_id');
            $table->dropConstrainedForeignId('applicant_id');

            $table->dropUnique(['employee_number']);
            $table->dropColumn([
                'employee_number',
                'join_date',
                'employment_status',
            ]);
        });
    }
};