<?php

namespace App\Http\Controllers\Mairie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MairieDashboardController extends Controller
{
    // 1. AFFICHAGE DE LA FILE D'ATTENTE AVEC KPIS DYNAMIQUES
    public function index()
    {
        $total_dossiers = DB::table('demandes')->count();
        $nb_en_attente  = DB::table('demandes')->where('statut', 'Reçu')->count();
        $nb_approuves   = DB::table('demandes')->where('statut', 'Signé & Archivé')->count();
        $nb_rejetes     = DB::table('demandes')->where('statut', 'Rejeté')->count();
        $nb_prets       = DB::table('demandes')->where('statut', 'Prêt')->count();

        // Remplacement par des LEFT JOIN pour ne perdre aucun dossier à l'affichage
        $demandes = DB::table('demandes')
            ->leftJoin('citoyens', 'demandes.id_citoyen', '=', 'citoyens.id_citoyen')
            ->leftJoin('utilisateurs', 'demandes.id_relais', '=', 'utilisateurs.id_user')
            ->select('demandes.*', 'citoyens.nom', 'citoyens.prenom', 'utilisateurs.nom as nom_relais')
            ->orderBy('demandes.date_creation', 'desc')
            ->get();

        foreach ($demandes as $demande) {
            $demande->nom_relais = $demande->nom_relais ?? 'Relais A. Sall';
            $demande->prenom = $demande->prenom ?? 'Citoyen';
            $demande->nom = $demande->nom ?? 'Inconnu';
            $demande->priorite = match($demande->type_acte) {
                'Décès' => 'Haute',
                'Mariage' => 'Normale',
                default => 'Basse'
            };
        }

        return view('mairie.dashboard', compact(
            'total_dossiers', 'nb_en_attente', 'nb_approuves', 'nb_rejetes', 'nb_prets', 'demandes'
        ));
    }

    
        // 2. LOGIQUE D'INSTRUCTION ET D'ENCAISSEMENT AU GUICHET CONFORME AUX COLONNES SQL
    public function validerDossier(Request $request, $id_demande)
    {
        $request->validate([
            'action' => 'required|in:examiner,encaisser,rejeter',
        ]);

        $action = $request->input('action');

        // Isolation transactionnelle stricte (Sécurité NF-02 contre les micro-coupures)
        DB::transaction(function () use ($action, $id_demande) {
            if ($action === 'examiner') {
                // Étape 1 : L'officier approuve la pièce justificative. L'acte passe au statut "Prêt"
                DB::table('demandes')->where('id_demande', $id_demande)->update([
                    'statut' => 'Prêt'
                ]);
            } 
            elseif ($action === 'encaisser') {
                // Étape 2 : Le citoyen paie au guichet, l'acte passe au statut final "Signé & Archivé"
                DB::table('demandes')->where('id_demande', $id_demande)->update([
                    'statut' => 'Signé & Archivé'
                ]);

                // Enregistrement comptable de la taxe de délivrance de 1000 FCFA dans les recettes
                DB::table('paiements')->insert([
                    'id_demande' => $id_demande,
                    'montant' => 1000, 
                    'date_paiement' => now(),
                    'mode_paiement' => 'Espèces (Régie Recettes Mairie)'
                ]);
            } 
            else {
                // Étape alternative : Rejet du dossier pour non-conformité des scans
                DB::table('demandes')->where('id_demande', $id_demande)->update([
                    'statut' => 'Rejeté'
                ]);
            }
        });

        return redirect()->route('mairie.dashboard');
    }

}
