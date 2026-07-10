<?php

namespace App\Http\Controllers\Mairie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MairieDashboardController extends Controller
{
    // Métriques partagées pour alimenter toutes les vues de la Mairie et éviter les variables indéfinies
    private function getMairieMetrics(): array
    {
        return [
            'nb_en_attente' => DB::table('demandes')->where('statut', 'Reçu')->count(),
            'nb_en_cours'   => DB::table('demandes')->where('statut', 'Prêt')->count(),
            'nb_approuves'  => DB::table('demandes')->where('statut', 'Signé & Archivé')->count(),
            'total_recettes'=> DB::table('demandes')->where('statut', 'Signé & Archivé')->count() * 1000,
        ];
    }

    // Route : /mairie/dashboard
    public function index()
    {
        $metrics = $this->getMairieMetrics();
        $demandes = DB::table('demandes')->orderBy('id_demande', 'desc')->get();
        
        return view('mairie.dashboard', array_merge($metrics, ['demandes' => $demandes]));
    }

    // Route : /mairie/tableau-de-bord
    public function tableauDeBord()
    {
        $metrics = $this->getMairieMetrics();
        $demandes = DB::table('demandes')->where('statut', 'Reçu')->orderBy('id_demande', 'asc')->get();
        
        return view('mairie.tableau_de_bord', array_merge($metrics, ['demandes' => $demandes]));
    }

    // Route : /mairie/citoyens
    public function citizens()
    {
        $metrics = $this->getMairieMetrics();
        $citoyens = DB::table('citoyens')->orderBy('nom', 'asc')->get();
        
        return view('mairie.citoyens', array_merge($metrics, ['citoyens' => $citoyens]));
    }

    // Doublon de sécurité au cas où ta route s'appelle citoyens ou citizens
    public function citoyens()
    {
        return $this->citizens();
    }

    // Route : /mairie/statistiques
    public function statistiques()
    {
        $metrics = $this->getMairieMetrics();
        $naissances = DB::table('demandes')->where('type_acte', 'Naissance')->count();
        $mariages   = DB::table('demandes')->where('type_acte', 'Mariage')->count();
        $deces      = DB::table('demandes')->where('type_acte', 'Décès')->count();
        
        return view('mairie.statistiques', array_merge($metrics, [
            'naissances' => $naissances,
            'mariages'   => $mariages,
            'deces'      => $deces
        ]));
    }

    // Route : /mairie/documents-officiels
    public function documents()
    {
        $metrics = $this->getMairieMetrics();
        return view('mairie.documents', $metrics);
    }

    // Traitement POST pour l'instruction et la caisse (taxe de 1 000 FCFA)
    public function validerDossier(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:examiner,encaisser,rejeter',
        ]);

        $action = $request->input('action');

        // Isolation transactionnelle stricte pour sécuriser la régie municipale
        DB::transaction(function () use ($action, $id) {
            if ($action === 'examiner') {
                DB::table('demandes')->where('id_demande', $id)->update(['statut' => 'Prêt']);
            } 
            elseif ($action === 'encaisser') {
                DB::table('demandes')->where('id_demande', $id)->update(['statut' => 'Signé & Archivé']);

                // Insertion de la ligne comptable physique à 1 000 FCFA
                DB::table('paiements')->insert([
                    'id_demande'    => $id,
                    'montant'       => 1000, 
                    'date_payment'  => now(),
                    'mode_paiement' => 'Espèces'
                ]);
            } 
            else {
                DB::table('demandes')->where('id_demande', $id)->update(['statut' => 'Rejeté']);
            }
        });

        return redirect()->route('mairie.dashboard')->with('success', 'Opération effectuée avec succès.');
    }
}
