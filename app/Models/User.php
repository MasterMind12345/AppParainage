<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'salle_id', 'is_delegue'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_delegue' => 'boolean',
    ];

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class, 'etudiant_id');
    }

    public function validations()
    {
        return $this->hasMany(Paiement::class, 'valide_par');
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isDelegue()
    {
        return $this->is_delegue === true;
    }
}