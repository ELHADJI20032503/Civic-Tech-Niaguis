<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Utilisateur;

class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        // 1. Validation stricte des données du formulaire 
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $credentials['login'];
        $passwordInput = $credentials['password'];

        // 2. Recherche stricte de l'utilisateur par login.
        $user = DB::table('utilisateurs')->where('login', $loginInput)->first();

        //  autoriser l'alias admin si le login exact n'existe pas.
        if (!$user && in_array(strtolower($loginInput), ['admin', 'admin@niaguis.gouv'], true)) {
            $user = DB::table('utilisateurs')->where('role', 'admin')->first();
        }

        if (!$user) {
            return back()->withInput()->withErrors([
                'login' => 'Identifiant ou mot de passe incorrect.',
            ]);
        }

        $passwordValide = $user && Hash::check($passwordInput, $user->password_hash);

        if ($passwordValide) {
            if (isset($user->statut_compte) && $user->statut_compte !== 'actif') {
                return back()->withErrors(['login' => 'Ce compte a été suspendu par l\'administrateur.']);
            }

            $userId = $user->id_user ?? $user->id;
            session(['auth_user_id' => $userId]);
            session(['user_fullname' => $user->prenom . ' ' . $user->nom]);
            session(['user_id' => $userId]);

            $roleActuel = strtolower($user->role ?? '');
            if ($roleActuel === 'admin') {
                session(['active_profile' => 'admin']);
                return redirect()->route('admin.dashboard');
            }

            if ($roleActuel === 'mairie' || $roleActuel === 'agent') {
                return redirect()->route('mairie.tableau_de_bord');
            }

            return redirect()->route('relais.dashboard');
        }

        return back()->withInput()->withErrors([
            'login' => 'Identifiant ou mot de passe incorrect.',
        ]);
    }
}
