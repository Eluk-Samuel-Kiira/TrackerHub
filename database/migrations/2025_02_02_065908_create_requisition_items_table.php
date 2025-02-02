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
        Schema::create('requisition_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisition_id');
            $table->string('title')->nullable();
            $table->string('receipt_no')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('uom_id');
            $table->integer('quantity');
            $table->decimal('unit_cost', 15, 2);
            $table->decimal('amount', 15, 2);
            $table->foreign('requisition_id')->references('id')->on('requistions')->onDelete('cascade');
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
        Schema::dropIfExists('requisition_items');
    }
};
