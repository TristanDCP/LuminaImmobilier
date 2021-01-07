<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment', function ($table) {
            $table->foreign('idUser')->references('idUser')->on('users');
        });

        Schema::table('documents', function ($table) {
            $table->foreign('idUser')->references('idUser')->on('users');
        });

        Schema::table('favorite', function ($table) {
            $table->foreign('idProperty')->references('idProperty')->on('property');
        });

        Schema::table('hasParameter', function ($table) {
            $table->foreign('idProperty')->references('idProperty')->on('property');
        });

        Schema::table('hasPicture', function ($table) {
            $table->foreign('idProperty')->references('idProperty')->on('property');
        });

        Schema::table('piece', function ($table) {
            $table->foreign('idProperty')->references('idProperty')->on('property');
        });

        Schema::table('property', function ($table) {
            $table->foreign('idUser')->references('idUser')->on('users');
        });

        Schema::table('users', function ($table) {
            $table->foreign('idRole')->references('idRole')->on('role');
            $table->foreign('idAgency')->references('idAgency')->on('agency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
