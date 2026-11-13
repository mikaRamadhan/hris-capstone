
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pindahkan data departemen terlebih dahulu
        $departments = DB::table('departments')
            ->orderBy('id')
            ->get();

        $departmentMap = [];

        foreach ($departments as $department) {
            $newId = DB::table('organizational_units')->insertGetId([
                'name' => $department->department_name,
                'type' => 'department',
                'parent_id' => null,
                'description' => $department->description,
                'created_at' => $department->created_at,
                'updated_at' => $department->updated_at,
            ]);

            $departmentMap[$department->id] = $newId;
        }

        // Pindahkan data posisi dan hubungkan ke departemennya
        $positions = DB::table('positions')
            ->orderBy('id')
            ->get();

        foreach ($positions as $position) {
            DB::table('organizational_units')->insert([
                'name' => $position->position_name,
                'type' => 'position',
                'parent_id' => $departmentMap[$position->department_id] ?? null,
                'description' => $position->description,
                'created_at' => $position->created_at,
                'updated_at' => $position->updated_at,
            ]);
        }
    }

    public function down(): void
    {
        // Data lama tetap dipertahankan pada tabel departments dan positions.
        // Jangan menghapus data hasil pemindahan secara otomatis.
    }
};
