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
        Schema::table('users', function (Blueprint $table) {
             $table->unsignedBigInteger('id_role');
             $table->unsignedBigInteger('id_site')->nullable();
             $table->unsignedBigInteger('id_filiere')->nullable();
            $table->foreign('id_role')->references('id')->on('roles');
            $table->foreign('id_site')->references('id')->on('sites');
            $table->foreign('id_filiere')->references('id')->on('filieres');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_role']);
            $table->dropColumn('id_role');
        });
    }
};
