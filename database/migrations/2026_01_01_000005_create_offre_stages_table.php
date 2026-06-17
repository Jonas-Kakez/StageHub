<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offre_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entreprise_id')->constrained('entreprises')->cascadeOnDelete();
            $table->string('titre');
            $table->string('departement_entreprise')->nullable();
            $table->string('duree')->nullable();
            $table->string('localisation')->nullable();
            $table->string('type_stage')->nullable();
            $table->string('domaine')->nullable();
            $table->text('description')->nullable();
            $table->text('competences_requises')->nullable();
            $table->enum('statut', ['brouillon', 'en_attente', 'active', 'inactive', 'refusee'])->default('en_attente');
            $table->boolean('moderee')->default(false);
            $table->text('motif_refus')->nullable();
            $table->timestamp('publie_le')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offre_stages');
    }
};
