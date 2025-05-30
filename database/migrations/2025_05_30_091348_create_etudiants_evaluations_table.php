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
        Schema::create('etudiants_evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('etudiant_id')->constrained;
            $table->foreignId('evaluation_id')->constrained;
            $table->float('note'); 
            $table->timestamps();
            //$table->foreign('etudiant_id')->references('id')->on('etudiants')->onDelete('cascade');
            //$table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etudiants_evaluations');
    }
};
