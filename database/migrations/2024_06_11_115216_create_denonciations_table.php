<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDenonciationsTable extends Migration
{
    public function up()
    {
        Schema::create('denonciations', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name');
            $table->string('denonciation');
            $table->text('plainte');
            $table->string('titre_memoire')->nullable();
            $table->string('preuve1')->nullable();
            $table->string('preuve2')->nullable();
            $table->string('preuve3')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('denonciations');
    }
}
