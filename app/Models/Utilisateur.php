<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Utilisateur extends Authenticatable
{
    use Notifiable;

    // Nom de ma table 
    protected $table = 'utilisateurs';

    // Nom de ma clé primaire
    protected $primaryKey = 'id_user';

    // Champs autorisés à être manipulés
    protected $fillable = [
        'login',
        'password_hash',
        'nom',
        'prenom',
        'role',
        'statut_compte',
    ];

    // J'Indique à Laravel que le mot de passe est stocké dans 'password_hash'
    public function getAuthPassword()
    {
        return $this->password_hash;
    }
}
