<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProperty extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->bigIncrements('idProperty', 11);
            $table->integer('propertyStatus', 11);
            $table->datetime('createdAt');
            $table->datetime('updatedAt')->nullable()->default(NULL);
            $table->datetime('deletedAt')->nullable()->default(NULL);
            $table->bigInteger('idUser', 11)->nullable()->default(NULL);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property');
    }
}
