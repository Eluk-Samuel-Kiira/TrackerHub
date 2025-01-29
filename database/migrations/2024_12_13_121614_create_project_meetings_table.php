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
        Schema::create('project_meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->dateTime('meetingDate')->nullable();
            $table->text('description')->nullable();
            $table->string('meetingLocation')->default('online');
            $table->integer('meetingType')->enum(['online', 'physical'])->default('online');
            $table->integer('status')->enum(['0', '1'])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_meetings');
    }
};
