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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('first_name');
            $table->string('last_name');
            $table->bigInteger('national_id')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone_number');
            $table->string('city');
            $table->boolean('gender');
            $table->dateTime('birth_date');
            $table->string('image_name');
            $table->longText('api_token')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patients');
    }
};
