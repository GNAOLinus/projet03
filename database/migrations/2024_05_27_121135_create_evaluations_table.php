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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_memoire')->constrained('memoires');
            $table->foreignId('id_rapport1')->constrained('memoires');
            $table->foreignId('id_rapport2')->constrained('memoires');
            $table->foreignId('id_rapport3')->constrained('memoires');
            $table->foreignId('id_rapport4')->constrained('memoires');
            $table->foreignId('id_rapport5')->constrained('memoires');
            $table->integer('note_rapport1');
            $table->integer('note_rapport2');
            $table->integer('note_rapport3');
            $table->integer('note_rapport4');
            $table->integer('note_rapport5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
