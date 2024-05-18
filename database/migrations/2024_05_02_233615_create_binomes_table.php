<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binomes', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_etudiant1');
            $table->unsignedBigInteger('id_etudiant2');
            $table->unsignedBigInteger('id_filiere');
            
            $table->foreign('id_etudiant1')->references('id')->on('users');
            $table->foreign('id_etudiant2')->references('id')->on('users');
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
        Schema::dropIfExists('binomes');
    }
}
