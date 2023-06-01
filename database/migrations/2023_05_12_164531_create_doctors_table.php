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
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique;
            $table->string('password');
            $table->foreignId('department_id')->constrained('departments');
            $table->string('categories');
            $table->string('image_name');
            $table->bigInteger('national_id')->unique();
            $table->string('reservation_phone_number');
            $table->longText('api_token')->nullable();
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
        Schema::dropIfExists('doctors');
    }
};
