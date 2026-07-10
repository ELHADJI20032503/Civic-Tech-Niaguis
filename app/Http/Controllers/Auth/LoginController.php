<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $credentials['login'];
        $passwordInput = $credentials['password'];

        // Recherche  de l'utilisateur
        $user = DB::table('utilisateurs')->where('login', $loginInput)->first();

        // Alias  pour l'admin
        if (!$user && in_array(strtolower($loginInput), ['admin', 'admin@niaguis.gouv'], true)) {
            $user = DB::table('utilisateurs')->where('role', 'admin')->first();
        }

        if (!$user) {
            return back()->withInput()->withErrors(['login' => 'Identifiant ou mot de passe incorrect.']);
        }

        // Vérification du mot de passe 
        $passwordValide = false;
        if (str_starts_with($user->password_hash, '$2y$') || str_starts_with($user->password_hash, '$2a$')) {
            try { $passwordValide = Hash::check($passwordInput, $user->password_hash); } catch (\Exception $e) { $passwordValide = false; }
        }
        if (!$passwordValide && $passwordInput === $user->password_hash) {
            $passwordValide = true;
        }

        if ($passwordValide) {
            if (isset($user->statut_compte) && $user->statut_compte !== 'actif') {
                return back()->withErrors(['login' => 'Ce compte a été suspendu.']);
            }

            // ENREGISTREMENT DU NOM EN SESSION POUR L'AFFICHAGE EN BARRE LATÉRALE
            session([
                'user_id'       => $user->id_user ?? $user->id,
                'user_fullname' => $user->prenom . ' ' . $user->nom,
                'user_role'     => strtolower($user->role ?? '')
            ]);

            $roleActuel = strtolower($user->role ?? '');

            // 1. Si Admin -> Redirection directe
            if ($roleActuel === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            // 2. Si Mairie ou Relais -> Redirection obligatoire vers le CHOIX DE PROFIL
            return redirect()->route('profil.view');
        }

        return back()->withInput()->withErrors(['login' => 'Identifiant ou mot de passe incorrect.']);
    }
     
   public function logout(): \Illuminate\Http\RedirectResponse
    {
        // Destruction propre et totale de toutes les variables de session communes
        session()->flush();
        
        return redirect()->route('login')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
 
