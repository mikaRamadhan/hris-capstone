
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organizational_units', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            // department atau position
            $table->string('type', 20);

            // Menghubungkan posisi dengan departemen
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('organizational_units')
                ->restrictOnDelete();

            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organizational_units');
    }
};
