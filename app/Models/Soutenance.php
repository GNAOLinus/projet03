<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soutenance extends Model
{
    use HasFactory;

    protected $fillable = [
            'id_filiere' ,
            'id_jury' ,
            'id_site' ,
            'date_soutenance' ,
            'heurs_soutenance', 
            'id_memoire',
    ];

    public function memoire()
    {
        return $this->belongsTo(Memoire::class, 'id_memoire');
    }

    public function site()
    {
        return $this->belongsTo(Site::class, 'id_site');
    }

    public function jury()
    {
        return $this->belongsTo(Jury::class, 'id_jury');
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
}
