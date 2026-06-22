<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('offre_stages', function (Blueprint $table) {
            $table->unsignedInteger('quota_stagiaires')->default(1)->after('competences_requises');
            $table->boolean('publiee_par_institution')->default(false)->after('moderee');
        });

        DB::statement("ALTER TABLE candidatures MODIFY statut ENUM('en_attente', 'transmise', 'acceptee', 'refusee') NOT NULL DEFAULT 'en_attente'");

        Schema::table('evaluations', function (Blueprint $table) {
            $table->boolean('validee_institution')->default(false)->after('type');
        });

        Schema::table('affectations', function (Blueprint $table) {
            $table->foreignId('departement_entreprise_id')->nullable()->after('encadreur_id');
        });
    }

    public function down(): void
    {
        Schema::table('offre_stages', function (Blueprint $table) {
            $table->dropColumn(['quota_stagiaires', 'publiee_par_institution']);
        });

        DB::statement("ALTER TABLE candidatures MODIFY statut ENUM('en_attente', 'acceptee', 'refusee') NOT NULL DEFAULT 'en_attente'");

        Schema::table('evaluations', function (Blueprint $table) {
            $table->dropColumn('validee_institution');
        });

        Schema::table('affectations', function (Blueprint $table) {
            $table->dropColumn('departement_entreprise_id');
        });
    }
};
