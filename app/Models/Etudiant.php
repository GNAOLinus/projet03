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
    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
    public function promotion()
    {
        return $this->belongsTo(promotion::class, 'id_promotion');
    }
    public function site()
    {
        return $this->belongsTo(site::class, 'id_site');
    }
}
