<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Affectation extends Model
{
    protected $fillable = [
        'candidature_id',
        'etudiant_id',
        'entreprise_id',
        'offre_stage_id',
        'encadreur_id',
        'date_debut',
        'date_fin',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date_debut' => 'date',
            'date_fin' => 'date',
        ];
    }

    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }

    public function etudiant(): BelongsTo
    {
        return $this->belongsTo(Etudiant::class);
    }

    public function entreprise(): BelongsTo
    {
        return $this->belongsTo(Entreprise::class);
    }

    public function offreStage(): BelongsTo
    {
        return $this->belongsTo(OffreStage::class);
    }

    public function encadreur(): BelongsTo
    {
        return $this->belongsTo(Encadreur::class);
    }

    public function rapportStage(): HasOne
    {
        return $this->hasOne(RapportStage::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function progression(): int
    {
        if (! $this->date_debut || ! $this->date_fin) {
            return 0;
        }

        $debut = Carbon::parse($this->date_debut);
        $fin = Carbon::parse($this->date_fin);
        $now = Carbon::now();

        if ($now->lt($debut)) {
            return 0;
        }

        if ($now->gte($fin)) {
            return 100;
        }

        $total = $debut->diffInDays($fin);

        if ($total === 0) {
            return 100;
        }

        return (int) round(($debut->diffInDays($now) / $total) * 100);
    }
}
