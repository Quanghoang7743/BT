<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->timestamps();

            $table->unique(['appointment_date', 'appointment_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
