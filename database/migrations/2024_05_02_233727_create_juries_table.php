<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJuriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('juries', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_enseignant1');
            $table->unsignedBigInteger('id_enseignant2');
            $table->unsignedBigInteger('id_enseignant3')->nullable();
            $table->unsignedBigInteger('id_filiere');
            
            $table->foreign('id_enseignant1')->references('id')->on('users');
            $table->foreign('id_enseignant2')->references('id')->on('users');
            $table->foreign('id_enseignant3')->references('id')->on('users');
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
        Schema::dropIfExists('juries');
    }
}

