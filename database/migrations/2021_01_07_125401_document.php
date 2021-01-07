<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocument extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document', function (Blueprint $table) {
            $table->bigIncrements('idDocument', 11);
            $table->string('documentType');
            $table->string('documentURL');
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
        Schema::dropIfExists('document');
    }
}
