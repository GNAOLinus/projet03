<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoiresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('memoires', function (Blueprint $table) {
            $table->id('id');
            $table->string('titre');
            $table->text('resume');
            $table->string('fichier');
            $table->string('statut');
            $table->string('appreciation');
            $table->string('note');
            $table->string('promotion');
            $table->unsignedBigInteger('id_filiere');
            $table->unsignedBigInteger('id_binome');

            $table->foreign('id_binome')->references('id')->on('binomes');
            $table->foreign('id_filiere')->references('id')->on('filieres');
            
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
        Schema::dropIfExists('memoires');
    }
}
