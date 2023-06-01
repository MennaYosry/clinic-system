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
        Schema::create('emrs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients')->cascadeOnDelete();
            $table->string('alergies');
            $table->boolean('tobacco_intake');
            $table->string('illegal_drugs');
            $table->string('current_drugs');
            $table->integer('alchol_intake');
            $table->string('patient_dcm_normal');
            $table->string('patient_dcm_diagnose');
            $table->string('blood_type');
            $table->string('history');
            $table->string('patient_symptoms');
            $table->text('doctor_report')->nullable();
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
        Schema::dropIfExists('emrs');
    }
};
