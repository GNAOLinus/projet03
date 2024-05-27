<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memoire extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'resume',
        'fichier',
        'statut',
        'id_binome',
        'id_filiere',
        'encadreur',
        'note',
        'appreciation',
        'id_promotion',
    ];

    /**
     * Get the binome associated with the memoire.
     */
    public function binome()
    {
        return $this->belongsTo(Binome::class, 'id_binome');
    }

    /**
     * Get the filiere associated with the memoire.
     */
    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
    
}
