<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('etudiants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('departement_id')->nullable()->constrained('departements')->nullOnDelete();
            $table->string('numero_etudiant')->nullable();
            $table->string('niveau')->nullable();
            $table->string('domaine')->nullable();
            $table->text('competences')->nullable();
            $table->string('telephone')->nullable();
            $table->string('cv_path')->nullable();
            $table->string('lettre_motivation_path')->nullable();
            $table->enum('statut', ['en_recherche', 'en_stage', 'stage_termine'])->default('en_recherche');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('etudiants');
    }
};
