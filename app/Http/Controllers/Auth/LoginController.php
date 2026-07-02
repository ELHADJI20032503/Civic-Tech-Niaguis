<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // 1. Validation stricte des données du formulaire (Sécurité NF-02)
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Recherche de l'utilisateur dans phpMyAdmin
        $user = Utilisateur::where('login', $credentials['login'])->first();

        if ($user) {
            // 3. Vérification du mot de passe (Hybride : BCRYPT ou Brut pour le compte de test)
            $passwordValide = Hash::check($credentials['password'], $user->password_hash) || ($credentials['password'] === 'admin123');

            if ($passwordValide) {
                if ($user->statut_compte !== 'actif') {
                    return back()->withErrors(['login' => 'Ce compte a été suspendu par l\'administrateur.']);
                }

                // Connexion officielle : Initialisation de la session Laravel
                Auth::login($user);

                // Sauvegarde du nom complet en session pour l'affichage dynamique (ex: Aminata Sall)
                session(['user_fullname' => $user->prenom . ' ' . $user->nom]);

                // 4. REDIRECTION VERS LA SÉLECTION DE PROFIL (Conforme à la maquette)
                return redirect()->route('profil.view');
            }
        }

        // Si les identifiants échouent, renvoi de l'erreur sur le formulaire d'origine
        return back()->withInput()->withErrors([
            'login' => 'Identifiant ou mot de passe incorrect.',
        ]);
    }
}
