
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {

            $table->foreignId('department_id')
                ->nullable()
                ->constrained('departments')
                ->nullOnDelete();

            $table->foreignId('position_id')
                ->nullable()
                ->constrained('positions')
                ->nullOnDelete();

            $table->text('requirements')->nullable();

            $table->integer('quota')->default(1);

            $table->date('closing_date')->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('vacancies', function (Blueprint $table) {

            $table->dropForeign(['department_id']);
            $table->dropForeign(['position_id']);
            $table->dropForeign(['created_by']);

            $table->dropColumn([
                'department_id',
                'position_id',
                'requirements',
                'quota',
                'closing_date',
                'created_by',
            ]);
        });
    }
};
