<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluation extends Model
{
    protected $fillable = [
        'affectation_id',
        'encadreur_id',
        'evaluateur_user_id',
        'note',
        'commentaire',
        'criteres',
        'type',
    ];

    protected function casts(): array
    {
        return [
            'note' => 'decimal:2',
            'criteres' => 'array',
        ];
    }

    public function affectation(): BelongsTo
    {
        return $this->belongsTo(Affectation::class);
    }

    public function encadreur(): BelongsTo
    {
        return $this->belongsTo(Encadreur::class);
    }

    public function evaluateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'evaluateur_user_id');
    }
}
