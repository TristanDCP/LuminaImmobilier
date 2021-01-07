<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment', function ($table) {
            $table->bigInteger('idUser')->unsigned();
            $table->foreign('idUser')
                    ->references('idUser')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::table('document', function ($table) {
            $table->bigInteger('idUser')->unsigned();
            $table->foreign('idUser')
                    ->references('idUser')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('favorite', function (Blueprint $table) {
            $table->bigInteger('idUser')->unsigned();
            $table->foreign('idUser')
                    ->references('idUser')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->bigInteger('idProperty')->unsigned();
            $table->foreign('idProperty')
                    ->references('idProperty')
                    ->on('property')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('hasParameter', function (Blueprint $table) {
            $table->bigInteger('idParameter')->unsigned();
            $table->foreign('idParameter')
                    ->references('idParameter')
                    ->on('propertyparameters')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->bigInteger('idProperty')->unsigned();
            $table->foreign('idProperty')
                    ->references('idProperty')
                    ->on('property')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::create('hasPicture', function (Blueprint $table) {
            $table->bigInteger('idPicture')->unsigned();
            $table->foreign('idPicture')
                    ->references('idPicture')
                    ->on('picture')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->bigInteger('idProperty')->unsigned();
            $table->foreign('idProperty')
                    ->references('idProperty')
                    ->on('property')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::table('piece', function ($table) {
            $table->bigInteger('idProperty')->unsigned();
            $table->foreign('idProperty')
                    ->references('idProperty')
                    ->on('property')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::table('property', function ($table) {
            $table->bigInteger('idUser')->unsigned()->nullable()->default(NULL);
            $table->foreign('idUser')
                    ->references('idUser')
                    ->on('users')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
        });

        Schema::table('users', function ($table) {
            $table->bigInteger('idRole')->unsigned();
            $table->foreign('idRole')
                    ->references('idRole')
                    ->on('role')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
            $table->bigInteger('idAgency')->unsigned();
            $table->foreign('idAgency')
                    ->references('idAgency')
                    ->on('agency')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
