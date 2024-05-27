<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('info_etudiants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('matricule');
            $table->unsignedBigInteger('id_filiere');
            $table->unsignedBigInteger('id_site');
            
            $table->foreign('id_filiere')->references('id')->on('filieres');
            $table->foreign('id_site')->references('id')->on('sites');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_etudiants');
    }
};
