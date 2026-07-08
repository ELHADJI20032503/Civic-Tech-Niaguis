<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function select(Request $request)
    {
        // 1. Validation du profil choisi sur l'interface graphique de Moutarou
        $request->validate([
            'chosen_role' => 'required|string|in:relais,agent,admin',
        ]);

        $roleChoisi = $request->input('chosen_role');
        
        // 2. Mémorisation du profil actif dans la session sécurisée
        session(['active_profile' => $roleChoisi]);

        // 3. AIGUILLAGE IMMÉDIAT ET FLUIDE SANS INTERROGATION DU TYPE ENUM MYSQL
        return match($roleChoisi) {
            'admin'  => redirect()->route('admin.dashboard'),
            'agent'  => redirect()->route('mairie.tableau_de_bord'),
            'relais' => redirect()->route('relais.dashboard'),
        };
    }
}
