<?php

namespace App\Http\Controllers\Mairie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MairieDashboardController extends Controller
{
        
    private function getMairieMetrics(): array
    {
        $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();
        $nb_en_cours   = DB::table('demandes')->where('statut', 'Prêt')->count();
        $nb_approuves  = DB::table('demandes')->where('statut', 'Signé & Archivé')->count();
        $nb_rejetes    = DB::table('demandes')->where('statut', 'Rejeté')->count();
        
        $total = $nb_en_attente + $nb_en_cours + $nb_approuves + $nb_rejetes;
        
        // Calcul dynamique  du taux de traitement
        $taux_traitement = ($total > 0) ? round(($nb_approuves / $total) * 100) : 0;

        return [
            'nb_en_attente'    => $nb_en_attente,
            'nb_en_cours'      => $nb_en_cours,
            'nb_prets'         => $nb_en_cours, 
            'nb_approuves'     => $nb_approuves,
            'nb_rejetes'       => $nb_rejetes,
            'taux_traitement'  => $taux_traitement,
            'total'            => $total,
            'total_dossiers'   => $total,
            'total_recettes'   => $nb_approuves * 1000,
            'recettes_totales' => $nb_approuves * 1000,
        ];
    }

    public function index()
    {
        $metrics = $this->getMairieMetrics();
        
        // Extraction  des demandes de l'État Civil de Niaguis
        $demandesBrutes = DB::table('demandes')
            ->join('citoyens', 'demandes.id_citoyen', '=', 'citoyens.id_citoyen')
            ->join('utilisateurs', 'demandes.id_relais', '=', 'utilisateurs.id_user')
            ->select(
                'demandes.*', 
                'citoyens.prenom', 
                'citoyens.nom', 
                'utilisateurs.prenom as relais_prenom', 
                'utilisateurs.nom as relais_nom'
            )
            ->orderBy('demandes.id_demande', 'desc')
            ->get();

        //  Récupération des chemins de fichiers selon le type d'acte 
        $demandes = $demandesBrutes->map(function ($demande) {
            $demande->nom_relais = $demande->relais_prenom . ' ' . $demande->relais_nom;
            
            // Initialisation par défaut à vide pour éviter les erreurs d'affichage
            $demande->certificat_hopital_path = null;
            $demande->certificat_mariage_path = null;
            $demande->certificat_deces_path = null;

            if ($demande->type_acte === 'Naissance') {
                $acte = DB::table('details_naissances')->where('id_demande', $demande->id_demande)->first();
                
                $demande->certificat_hopital_path = $acte->certificat_hopital ?? 'certificats/demo_officielle.pdf';
            } 
            elseif ($demande->type_acte === 'Mariage') {
                $acte = DB::table('details_mariages')->where('id_demande', $demande->id_demande)->first();
                $demande->certificat_mariage_path = $acte->certificat_mariage ?? 'certificats_mariages/demo_officielle.pdf';
            } 
            elseif ($demande->type_acte === 'Décès') {
                $acte = DB::table('details_deces')->where('id_demande', $demande->id_demande)->first();
                $demande->certificat_deces_path = $acte->certificat_deces ?? 'certificats_deces/demo_officielle.pdf';
            }

            return $demande;
        });
        
        return view('mairie.dashboard', array_merge($metrics, ['demandes' => $demandes]));
    }





    
    
            // Route : /mairie/tableau-de-bord (ÉCRAN PRINCIPAL DE VALIDATION ET CAISSE INTERCONNECTÉE)
    public function tableauDeBord()
    {
        $metrics = $this->getMairieMetrics();
        
        // 1. File d'attente des demandes reçues (Jointure Citoyens)
        $demandes = DB::table('demandes')
            ->join('citoyens', 'demandes.id_citoyen', '=', 'citoyens.id_citoyen')
            ->select('demandes.*', 'citoyens.prenom', 'citoyens.nom')
            ->where('demandes.statut', 'Reçu')
            ->orderBy('demandes.id_demande', 'asc')
            ->get();

        //  Triple jointure pour ajouter prenom et nom au livre de caisse
        $derniers_paiements = DB::table('paiements')
            ->join('demandes', 'paiements.id_demande', '=', 'demandes.id_demande')
            ->join('citoyens', 'demandes.id_citoyen', '=', 'citoyens.id_citoyen')
            ->select(
                'paiements.*', 
                'demandes.numero_suivi', 
                'demandes.type_acte', 
                'citoyens.prenom', 
                'citoyens.nom'
            )
            ->orderBy('id_paiement', 'desc')
            ->limit(10)
            ->get();
        
        return view('mairie.tableau_de_bord', array_merge($metrics, [
            'demandes' => $demandes,
            'derniers_paiements' => $derniers_paiements
        ]));
    }


    // Route : /mairie/citoyens
    public function citizens()
    {
        $metrics = $this->getMairieMetrics();
        $citoyens = DB::table('citoyens')->orderBy('nom', 'asc')->get();
        
        return view('mairie.citoyens', array_merge($metrics, ['citoyens' => $citoyens]));
    }

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

    
        // Route : /mairie/documents-officiels (REGISTRE DES ACTES SIGNÉS ET ARCHIVÉS)
    public function documents()
    {
        $metrics = $this->getMairieMetrics();

        //  Extraction des actes validés 
        $actes_archives = DB::table('demandes')
            ->join('citoyens', 'demandes.id_citoyen', '=', 'citoyens.id_citoyen')
            ->select('demandes.*', 'citoyens.prenom', 'citoyens.nom')
            ->where('demandes.statut', 'Signé & Archivé')
            ->orderBy('demandes.id_demande', 'desc')
            ->get();

        
        return view('mairie.documents', array_merge($metrics, [
            'actes_archives' => $actes_archives 
        ]));
    }


        // Traitement POST pour l'instruction et la caisse 
    public function validerDossier(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:examiner,encaisser,rejeter',
        ]);

        $action = $request->input('action');

        DB::transaction(function () use ($action, $id) {
            if ($action === 'examiner') {
                DB::table('demandes')->where('id_demande', $id)->update(['statut' => 'Prêt']);
            } 
            elseif ($action === 'encaisser') {
                DB::table('demandes')->where('id_demande', $id)->update(['statut' => 'Signé & Archivé']);

                try {
                    
                    DB::table('paiements')->insert([
                        'id_demande'    => $id,
                        'montant'       => 1000, 
                        'date_paiement' => now(),
                        'mode_paiement' => 'Espèces'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    //  Si la colonne n'existe pas non plus, on laisse MySQL gérer le TIMESTAMP par défaut
                    DB::table('paiements')->insert([
                        'id_demande'    => $id,
                        'montant'       => 1000, 
                        'mode_paiement' => 'Espèces'
                    ]);
                }
            } 
            else {
                DB::table('demandes')->where('id_demande', $id)->update(['statut' => 'Rejeté']);
            }
        });

        //  Rediriger l'officier vers le tableau de bord de traitement actuel pour voir le résultat immédiat
        return redirect()->route('mairie.tableau_de_bord')->with('success', 'Opération de régie effectuée avec succès.');
    }

}
