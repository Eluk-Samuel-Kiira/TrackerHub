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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_name')->default('TrackHub');
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->string('app_email')->nullable();
            $table->string('app_contact')->nullable();
            $table->string('meta_keyword')->default('Best Project Management System')->nullable();
            $table->longText('meta_descrip')->nullable();
            $table->enum('mail_status', ['enabled', 'disabled'])->default('enabled')->nullable();
            $table->string('mail_mailer')->default('smtp')->nullable();
            $table->string('mail_host')->default('smtp.gmail.com')->nullable();
            $table->string('mail_port')->default('465')->nullable();
            $table->string('mail_username')->default('yorentos23@gmail.com')->nullable();
            $table->string('mail_password')->default('shxdoavekodckrnh')->nullable();
            $table->string('mail_encryption')->default('tls')->nullable();
            $table->string('mail_address')->default('yorentos23@gmail.com')->nullable();
            $table->string('mail_name')->default('no_reply')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
