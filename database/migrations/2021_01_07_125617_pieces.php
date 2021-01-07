<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePieces extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piece', function (Blueprint $table) {
            $table->bigIncrements('idPiece', 11);
            $table->string('pieceName');
            $table->integer('pieceSurface', 11);
            $table->string('pieceExposure')->nullable()->default(NULL);
            $table->datetime('createdAt');
            $table->datetime('updatedAt')->nullable()->default(NULL);
            $table->datetime('deletedAt')->nullable()->default(NULL);
            $table->bigInteger('idProperty', 11);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('piece');
    }
}
