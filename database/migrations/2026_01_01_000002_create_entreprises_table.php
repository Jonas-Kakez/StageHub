<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('entreprises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nom');
            $table->string('secteur')->nullable();
            $table->text('description')->nullable();
            $table->string('telephone')->nullable();
            $table->string('site_web')->nullable();
            $table->string('adresse')->nullable();
            $table->string('ville')->nullable();
            $table->string('province')->nullable();
            $table->string('pays')->default('RDC');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->enum('statut_validation', ['en_attente', 'validee', 'refusee'])->default('en_attente');
            $table->text('motif_refus')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entreprises');
    }
};
