
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Lepaskan foreign key lama pada tabel employees
        Schema::table('employees', function (Blueprint $table) {
            $table->dropForeign('employees_department_id_foreign');
            $table->dropForeign('employees_position_id_foreign');
        });

        // 2. Lepaskan foreign key lama pada tabel vacancies
        Schema::table('vacancies', function (Blueprint $table) {
            $table->dropForeign('vacancies_department_id_foreign');
            $table->dropForeign('vacancies_position_id_foreign');
        });

        // 3. Pindahkan relasi departemen berdasarkan nama
        $departments = DB::table('departments')->get();

        foreach ($departments as $department) {

            $newDepartment = DB::table('organizational_units')
                ->where('type', 'department')
                ->where('name', $department->department_name)
                ->first();

            if ($newDepartment) {

                DB::table('employees')
                    ->where('department_id', $department->id)
                    ->update([
                        'department_id' => $newDepartment->id
                    ]);

                DB::table('vacancies')
                    ->where('department_id', $department->id)
                    ->update([
                        'department_id' => $newDepartment->id
                    ]);
            }
        }

        // 4. Pindahkan relasi posisi berdasarkan nama posisi
        $positions = DB::table('positions')->get();

        foreach ($positions as $position) {

            $newPosition = DB::table('organizational_units')
                ->where('type', 'position')
                ->where('name', $position->position_name)
                ->first();

            if ($newPosition) {

                DB::table('employees')
                    ->where('position_id', $position->id)
                    ->update([
                        'position_id' => $newPosition->id
                    ]);

                DB::table('vacancies')
                    ->where('position_id', $position->id)
                    ->update([
                        'position_id' => $newPosition->id
                    ]);
            }
        }

        // 5. Buat foreign key baru pada employees
        Schema::table('employees', function (Blueprint $table) {
            $table->foreign('department_id')
                ->references('id')
                ->on('organizational_units')
                ->nullOnDelete();

            $table->foreign('position_id')
                ->references('id')
                ->on('organizational_units')
                ->nullOnDelete();
        });

        // 6. Buat foreign key baru pada vacancies
        Schema::table('vacancies', function (Blueprint $table) {
            $table->foreign('department_id')
                ->references('id')
                ->on('organizational_units')
                ->nullOnDelete();

            $table->foreign('position_id')
                ->references('id')
                ->on('organizational_units')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Relasi tidak dikembalikan otomatis karena ID
        // departemen dan posisi sudah dimigrasikan.
    }
};
