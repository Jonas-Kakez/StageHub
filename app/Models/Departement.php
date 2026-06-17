<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    protected $fillable = [
        'nom',
        'faculte',
        'description',
    ];

    public function etudiants(): HasMany
    {
        return $this->hasMany(Etudiant::class);
    }

    public function encadreurs(): HasMany
    {
        return $this->hasMany(Encadreur::class);
    }
}
