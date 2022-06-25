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
        Schema::create('specialists', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('middleName');
            $table->string('lastName');
            $table->string('about')->unique();
            $table->string('speciality');
            $table->string('hospital');
            $table->string('gender');
            $table->integer('age');
            $table->integer('yearsOfExperience');
            $table->string('phoneNumber')->unique();
            $table->string('email')->unique();
            $table->string('region');
            $table->string('country');

            $table->integer('idCard')->unique();
            $table->string('password');
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
        Schema::dropIfExists('specialists');
    }
};
