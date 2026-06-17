<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_ADMIN = 'admin';
    public const ROLE_ENTREPRISE = 'entreprise';
    public const ROLE_ETUDIANT = 'etudiant';
    public const ROLE_DEPARTEMENT = 'departement';
    public const ROLE_ENCADREUR = 'encadreur';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function entreprise()
    {
        return $this->hasOne(Entreprise::class);
    }

    public function etudiant()
    {
        return $this->hasOne(Etudiant::class);
    }

    public function encadreur()
    {
        return $this->hasOne(Encadreur::class);
    }

    public function traitements()
    {
        return $this->hasMany(Traitement::class);
    }

    public function appNotifications()
    {
        return $this->hasMany(AppNotification::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isEntreprise(): bool
    {
        return $this->role === self::ROLE_ENTREPRISE;
    }

    public function isEtudiant(): bool
    {
        return $this->role === self::ROLE_ETUDIANT;
    }

    public function isDepartement(): bool
    {
        return $this->role === self::ROLE_DEPARTEMENT;
    }

    public function isEncadreur(): bool
    {
        return $this->role === self::ROLE_ENCADREUR;
    }

    public function dashboardRoute(): string
    {
        return match ($this->role) {
            self::ROLE_ADMIN => route('admin.dashboard'),
            self::ROLE_ENTREPRISE => route('entreprise.dashboard'),
            self::ROLE_ETUDIANT => route('etudiant.dashboard'),
            self::ROLE_DEPARTEMENT => route('departement.dashboard'),
            self::ROLE_ENCADREUR => route('encadreur.dashboard'),
            default => route('home'),
        };
    }
}
