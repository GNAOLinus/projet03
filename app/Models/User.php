<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
    protected $fillable = [
        'name',
        'email',
        'password',
        'id_role',
        'id_site',
        'id_filiere',
        'id_promotion',
        'phone',
    ];
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
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
