<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RapportStage extends Model
{
    protected $fillable = [
        'affectation_id',
        'etudiant_id',
        'titre',
        'fichier_path',
        'statut',
        'commentaire_encadreur',
    ];

    public function affectation(): BelongsTo
    {
        return $this->belongsTo(Affectation::class);
    }

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }
}
