<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reserved_doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->foreignId('reserved_patient_id')->constrained('patients')->cascadeOnDelete();
            $table->string('symptoms');
            $table->dateTime('reservation_time');
            $table->string('reservation_symptoms');
            $table->boolean('urgent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
