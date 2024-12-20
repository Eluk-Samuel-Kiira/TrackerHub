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
            $table->decimal('projectCost', 15, 2);
            $table->integer('isPaidOff')->enum(['1', '0'])->default(0);
            $table->decimal('projectBudget', 15, 2);
            $table->decimal('projectBudgetLimit', 15, 2);
            $table->enum('txn_status', ['pending','paid','incomplete'])->default('pending'); 
            $table->foreignId('projectCurrencyId')->constrained('currencies')->cascadeOnDelete();
            $table->integer('completionStatus')->enum(['0', '1'])->default(0);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('paid_by')->constrained('users')->cascadeOnDelete();
            $table->integer('isActive')->enum(['1', '0'])->default(1);
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
