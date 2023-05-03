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
        Schema::create('audio', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string("obra");
            $table->integer("duracion");
            $table->string("interprete");
            $table->string("audio");
            $table->unsignedBigInteger("idPartitura");
            $table->foreign('idPartitura')->references('id')->on('partituras')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio');
    }
};
