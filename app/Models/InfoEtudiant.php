<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoEtudiant extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'matricule', 'id_filiere', 'id_site'];

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }
}
