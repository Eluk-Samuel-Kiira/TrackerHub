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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('projectCode')->unique();
            $table->string('projectName')->unique();
            $table->date('projectStartDate');
            $table->date('projectDeadlineDate');
            $table->text('projectDescription');
            $table->foreignId('projectCategoryId')->constrained('project_categories')->cascadeOnDelete();
            $table->foreignId('projectDepartmentId')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('projectClientId')->constrained('clients')->cascadeOnDelete();
            $table->decimal('projectBudget', 15, 2);
            $table->decimal('projectBudgetLimit', 15, 2);
            $table->foreignId('projectCurrencyId')->constrained('currencies')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
