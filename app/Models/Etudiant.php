<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    public function binome()
    {
        return $this->belongsTo(Etudiant::class, 'id_binome');
    }
}
