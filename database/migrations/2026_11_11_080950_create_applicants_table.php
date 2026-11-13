
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->string('full_name');
            $table->string('phone_number', 20)->nullable();
            $table->text('address')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender', 20)->nullable();
            $table->string('education')->nullable();
            $table->string('university')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
