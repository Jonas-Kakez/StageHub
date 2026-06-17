<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('affectation_id')->constrained('affectations')->cascadeOnDelete();
            $table->foreignId('encadreur_id')->nullable()->constrained('encadreurs')->nullOnDelete();
            $table->foreignId('evaluateur_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('note', 4, 2)->nullable();
            $table->text('commentaire')->nullable();
            $table->json('criteres')->nullable();
            $table->enum('type', ['entreprise', 'encadreur'])->default('entreprise');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
