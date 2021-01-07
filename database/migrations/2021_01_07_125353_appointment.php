<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointment', function (Blueprint $table) {
            $table->bigIncrements('idAppointment', 11);
            $table->datetime('appointmentDate');
            $table->string('appointmentAgent');
            $table->string('appointmentMotif');
            $table->integer('appointmentType', 11);
            $table->datetime('createdAt');
            $table->datetime('updatedAt')->nullable()->default(NULL);
            $table->datetime('deletedAt')->nullable()->default(NULL);
            $table->bigInteger('idUser', 11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointment');
    }
}
