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
        'quota_stagiaires',
        'statut',
        'moderee',
        'publiee_par_institution',
        'motif_refus',
        'publie_le',
    ];

    protected function casts(): array
    {
        return [
            'moderee' => 'boolean',
            'publiee_par_institution' => 'boolean',
            'publie_le' => 'datetime',
            'quota_stagiaires' => 'integer',
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

    public function placesOccupees(): int
    {
        return $this->candidatures()->where('statut', 'acceptee')->count()
            + $this->affectations()->where('statut', 'active')->count();
    }

    public function quotaAtteint(): bool
    {
        return $this->placesOccupees() >= $this->quota_stagiaires;
    }

    public function placesRestantes(): int
    {
        return max(0, $this->quota_stagiaires - $this->placesOccupees());
    }
}
