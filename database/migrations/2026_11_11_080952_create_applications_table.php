
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('applicant_id')
                ->constrained('applicants')
                ->cascadeOnDelete();

            $table->foreignId('vacancy_id')
                ->constrained('vacancies')
                ->restrictOnDelete();

            $table->string('status')->default('submitted');
            $table->timestamp('applied_at')->useCurrent();

            $table->timestamps();

            $table->unique(['applicant_id', 'vacancy_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
