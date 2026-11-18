
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('selection_results', function (Blueprint $table) {
            $table->foreignId('application_id')
                ->after('id')
                ->constrained('applications')
                ->cascadeOnDelete();

            $table->string('stage_name', 100)->after('application_id');

            $table->unsignedInteger('stage_order')
                ->default(1)
                ->after('stage_name');

            $table->string('result', 20)
                ->default('pending')
                ->after('stage_order');

            $table->text('notes')->nullable()->after('result');

            $table->timestamp('selected_at')
                ->nullable()
                ->after('notes');
        });
    }

    public function down(): void
    {
        Schema::table('selection_results', function (Blueprint $table) {
            $table->dropForeign(['application_id']);

            $table->dropColumn([
                'application_id',
                'stage_name',
                'stage_order',
                'result',
                'notes',
                'selected_at',
            ]);
        });
    }
};
