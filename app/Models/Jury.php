<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jury extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_filiere',
        'id_enseignant1',
        'id_enseignant2',
        'id_enseignant3',
    ];
    public function enseignant1()
    {
        return $this->belongsTo(User::class, 'id_enseignant1');
    }
    
    public function enseignant2()
    {
        return $this->belongsTo(User::class, 'id_enseignant2');
    }
    public function enseignant3()
    {
        return $this->belongsTo(User::class, 'id_enseignant3');
    }
    
    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
} 
  
