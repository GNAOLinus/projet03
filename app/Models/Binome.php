<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binome extends Model
{
    use HasFactory;
   
    protected $fillable = [
        'id_etudiant1',
        'id_etudiant2',
        'id_filiere',
    ];
    public function etudiant1()
    {
        return $this->belongsTo(User::class, 'id_etudiant1');
    }

    public function etudiant2()
    {
        return $this->belongsTo(User::class, 'id_etudiant2');
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
}
