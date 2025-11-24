<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function etudiants()
    {
        return $this->hasMany(User::class);
    }

    public function delegues()
    {
        return $this->hasMany(User::class, 'salle_id')->where('is_delegue', true);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
}
