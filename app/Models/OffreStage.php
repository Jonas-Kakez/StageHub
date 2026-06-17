<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OffreStage extends Model
{
    protected $fillable = [
        'entreprise_id',
        'titre',
        'departement_entreprise',
        'duree',
        'localisation',
        'type_stage',
        'domaine',
        'description',
        'competences_requises',
        'statut',
        'moderee',
        'motif_refus',
        'publie_le',
    ];

    protected function casts(): array
    {
        return [
            'moderee' => 'boolean',
            'publie_le' => 'datetime',
        ];
    }

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function candidatures(): HasMany
    {
        return $this->hasMany(Candidature::class);
    }

    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class);
    }

    public function isActive(): bool
    {
        return $this->statut === 'active';
    }
}
