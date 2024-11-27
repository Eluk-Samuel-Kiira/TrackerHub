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
        Schema::create('project_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->string('amount');
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();
            $table->integer('isPaid')->enum(['1','0'])->default(0);
            $table->string('reference_number')->nullable()->unique();//may change to recieptId and upload images
            $table->foreignId('createdBy')->constrained('users')->cascadeOnUpdate();
            $table->foreignId('paidBy')->constrained('users')->cascadeOnUpdate();
            $table->integer('isActive')->enum(['1','0'])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_invoices');
    }
};
