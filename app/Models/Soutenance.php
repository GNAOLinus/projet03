<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soutenance extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_memoire',
        'id_site',
        'date_soutenance',
        'heurs_soutenace',
    ];
}
