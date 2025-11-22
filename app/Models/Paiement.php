<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id', 'salle_id', 'montant', 'telephone', 'status', 'valide_le', 'valide_par'
    ];

    protected $casts = [
        'valide_le' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function etudiant()
    {
        return $this->belongsTo(User::class, 'etudiant_id');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function delegue()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }
}