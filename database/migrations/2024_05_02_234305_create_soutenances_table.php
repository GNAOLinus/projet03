<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoutenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('soutenances', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_memoire');
            $table->unsignedBigInteger('id_site');
            $table->date('date_soutenance');
            $table->unsignedBigInteger('id_binome');
            $table->unsignedBigInteger('id_filiere');
            $table->time('heurs_soutenace');
            $table->foreign('id_site')->references('id')->on('sites');    
            $table->timestamps();

            
            

            $table->foreign('id_memoire')->references('id')->on('memoires');
            $table->foreign('id_binome')->references('id')->on('binomes');
            $table->foreign('id_filiere')->references('id')->on('filieres');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('soutenances');
    }
}
