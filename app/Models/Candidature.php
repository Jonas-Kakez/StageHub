<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Candidature extends Model
{
    protected $fillable = [
        'etudiant_id',
        'offre_stage_id',
        'cv_path',
        'lettre_motivation_path',
        'statut',
        'motif_refus',
    ];

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function offreStage(): BelongsTo
    {
        return $this->belongsTo(OffreStage::class);
    }

    public function traitements(): HasMany
    {
        return $this->hasMany(Traitement::class);
    }

    public function affectation(): HasOne
    {
        return $this->hasOne(Affectation::class);
    }
}
