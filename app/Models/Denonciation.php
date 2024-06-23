<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Denonciation extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'email',
        'name',
        'denonciation',
        'plainte',
        'titre_memoire',
        'preuve1',
        'preuve2',
        'preuve3',
        'statut',
    ];
}
