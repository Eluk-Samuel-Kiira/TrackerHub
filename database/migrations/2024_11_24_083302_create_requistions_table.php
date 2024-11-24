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
        Schema::create('requistions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->decimal('amount', 15, 2);
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->longText('description')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->integer('isActive')->enum('1', '0')->default(1);
            $table->enum('status', ['pending', 'approved', 'denied'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requistions');
    }
};
