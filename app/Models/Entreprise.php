<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entreprise extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'secteur',
        'description',
        'telephone',
        'site_web',
        'adresse',
        'ville',
        'province',
        'pays',
        'latitude',
        'longitude',
        'statut_validation',
        'motif_refus',
    ];

    protected function casts(): array
    {
        return [
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function offresStage(): HasMany
    {
        return $this->hasMany(OffreStage::class);
    }

    public function affectations(): HasMany
    {
        return $this->hasMany(Affectation::class);
    }

    public function isValidee(): bool
    {
        return $this->statut_validation === 'validee';
    }

    public function localisationComplete(): string
    {
        return collect([$this->adresse, $this->ville, $this->province, $this->pays])
            ->filter()
            ->implode(', ');
    }
}
