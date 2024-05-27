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
            $table->id();
            $table->foreignId('id_memoire')->constrained('memoires');
            $table->foreignId('id_filiere')->constrained('filieres');
            $table->foreignId('id_site')->constrained('sites');
            $table->foreignId('id_jury')->constrained('juries');
            $table->date('date_soutenance');
            $table->time('heurs_soutenace');
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
        Schema::dropIfExists('soutenances');
    }
}
