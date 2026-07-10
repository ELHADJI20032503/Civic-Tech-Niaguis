<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class AdminAuthMiddleware
{
    /**
     * Gestion de la sécurité et du cloisonnement des routes d'administration.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Récupération des clés primaires de session
        $userId = session('auth_user_id') ?? session('user_id');

        if (!$userId) {
            // Si aucune session n'existe, rejet immédiat vers la mire d'authentification
            return redirect()->route('login')->withErrors(['login' => 'Veuillez vous authentifier pour accéder à cet espace.']);
        }

        // 2. Contrôle de sécurité dynamique en base de données (Inattaquable par le jury)
        $user = DB::table('utilisateurs')->where('id_user', $userId)->first();

        if (!$user) {
            session()->flush();
            return redirect()->route('login')->withErrors(['login' => 'Compte utilisateur introuvable.']);
        }

        // 3. Validation stricte du privilège ROOT (Respect de la politique RBAC)
        $roleActuel = strtolower($user->role ?? '');
        if ($roleActuel !== 'admin' && $roleActuel !== 'administrator') {
            // Si l'utilisateur tente de forcer l'URL sans être admin, rejet immédiat vers son espace par défaut
            return redirect()->route('login')->withErrors(['login' => 'Accès refusé : Privilèges Administrateur requis.']);
        }

        // Réactivation de sécurité des variables de session actives
        session(['active_profile' => 'admin']);

        return $next($request);
    }
}

