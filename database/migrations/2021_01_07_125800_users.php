<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('idUser', 11);
            $table->string('userLastname');
            $table->string('userFirstname');
            $table->string('userEmail')->unique();
            $table->date('userDob');
            $table->string('userPassword');
            $table->string('userPhone', 13);
            $table->string('userAdr');
            $table->datetime('createdAt');
            $table->datetime('updatedAt')->nullable()->default(NULL);
            $table->datetime('deletedAt')->nullable()->default(NULL);
            $table->integer('idRole', 11);
            $table->integer('idAgency', 11)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
