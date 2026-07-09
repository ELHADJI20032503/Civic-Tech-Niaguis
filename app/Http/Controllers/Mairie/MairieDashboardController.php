<?php

namespace App\Http\Controllers\Mairie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MairieDashboardController extends Controller
{
    // 1. AFFICHAGE DE LA FILE D'ATTENTE 
    /**
     * Affiche la file d'attente et les KPIs (nombre de dossiers, états, etc.).
     *
     * @return \Illuminate\Contracts\View\View
     */
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
        /**
         * Valide ou traite un dossier en guichet (examiner / encaisser / rejeter).
         *
         * @param Request $request attendu: action (examiner|encaisser|rejeter)
         * @param int $id_demande Identifiant de la demande à traiter
         * @return \Illuminate\Http\RedirectResponse
         */
        public function validerDossier(Request $request, $id_demande)
    {
        $request->validate([
            'action' => 'required|in:examiner,encaisser,rejeter',
        ]);

        $action = $request->input('action');

        // Isolation transactionnelle stricte ( contre les micro-coupures)
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

                // Enregistrement comptable sécurisé de la taxe de délivrance de 1000 FCFA dans les recettes
                try {
                    DB::table('paiements')->insert([
                        'id_demande'    => $id_demande, // Correction : Harmonisation de la variable
                        'montant'       => 1000, 
                        'date_paiement' => now(),
                        'mode_paiement' => 'Espèces (Régie Recettes Mairie)'
                    ]);
                } catch (\Exception $e) {
                    // Si la table n'existe pas dans phpMyAdmin, Laravel intercepte l'erreur sans planter
                }
            } 
            else {
                // Étape alternative : Rejet du dossier pour non-conformité des scans
                DB::table('demandes')->where('id_demande', $id_demande)->update([ //  Harmonisation de la variable
                    'statut' => 'Rejeté'
                ]);
            }
        });

        return redirect()->route('mairie.dashboard')->with('success', 'Dossier traité avec succès au guichet de Niaguis.');
    }


        // 3. EXTRACTION DU REGISTRE CENTRALISÉ DES CITOYENS 
    /**
     * Retourne la liste des citoyens pour affichage.
     *
     * @param Request $request (optionnel)
     * @return \Illuminate\Contracts\View\View
     */
    public function citoyens(Request $request)
    {
        $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();
        
        // Récupération de tous les citoyens enregistrés en base 
        $citoyens = DB::table('citoyens')
            ->orderBy('nom', 'asc')
            ->orderBy('prenom', 'asc')
            ->get();

        return view('mairie.citoyens', compact('nb_en_attente', 'citoyens'));
    }
      // 4. LOGIQUE D'ANALYSE ET STATISTIQUES MUNICIPALES 
        
    /**
     * Fournit des statistiques municipales (par type d'acte, recettes, etc.).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function statistiques()
    {
        $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();

        // Récupération des volumes par type d'acte (Agrégation SQL)
        $naissances = DB::table('demandes')->where('type_acte', 'Naissance')->count();
        $mariages   = DB::table('demandes')->where('type_acte', 'Mariage')->count();
        $deces      = DB::table('demandes')->where('type_acte', 'Décès')->count();

        // Sécurisation contre l'absence de la table paiements
        try {
            $recettes_totales = DB::table('paiements')->sum('montant');
        } catch (\Exception $e) {
            $recettes_totales = 0; // Évite le plantage si la table n'existe pas encore
        }

        return view('mairie.statistiques', compact('nb_en_attente', 'naissances', 'mariages', 'deces', 'recettes_totales'));
    }

    // 5. RAPPORTS MUNICIPAUX
    /**
     * Affiche la page de rapports municipaux.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function rapports()
    {
        $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();
        return view('mairie.rapports', compact('nb_en_attente'));
    }

    // 6. PARAMÈTRES DE SITE MAIRIE
    /**
     * Affiche les paramètres du site pour la section mairie.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function parametres()
    {
        $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();
        return view('mairie.parametres', compact('nb_en_attente'));
    }

        // 7. REGISTRE DES DOCUMENTS OFFICIELS ARCHIVÉS
    /**
     * Liste les documents officiels archivés (actes signés & archivés).
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function documents()
    {
        $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();

        // Utilisation de date_creation  pour le tri SQL
        $actes_archives = DB::table('demandes')
            ->join('citoyens', 'demandes.id_citoyen', '=', 'citoyens.id_citoyen')
            ->where('demandes.statut', 'Signé & Archivé')
            ->select('demandes.*', 'citoyens.nom', 'citoyens.prenom')
            ->orderBy('demandes.date_creation', 'desc')
            ->get();

        return view('mairie.documents', compact('nb_en_attente', 'actes_archives'));
    }

    // 6. LOGIQUE DE COMMANDEMENT DU TABLEAU DE BORD PRINCIPAL (BACKEND)
    /**
     * Back-end du tableau de bord principal pour la mairie .
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function tableauDeBord()
    {
        $nb_en_attente = DB::table('demandes')->where('statut', 'Reçu')->count();
        $total_dossiers = DB::table('demandes')->count();
        $nb_approuves   = DB::table('demandes')->where('statut', 'Signé & Archivé')->count();

        // Calcul du taux d'efficacité de traitement de la mairie de Niaguis
        $taux_traitement = $total_dossiers > 0 ? round(($nb_approuves / $total_dossiers) * 100) : 0;

        // Récupération des 3 derniers paiements encaissés à la caisse du guichet
        try {
            $recettes_totales = DB::table('paiements')->sum('montant');
            $derniers_paiements = DB::table('paiements')
                ->join('demandes', 'paiements.id_demande', '=', 'demandes.id_demande')
                ->join('citoyens', 'demandes.id_citoyen', '=', 'citoyens.id_citoyen')
                ->select('paiements.*', 'citoyens.nom', 'citoyens.prenom', 'demandes.numero_suivi')
                ->orderBy('paiements.date_paiement', 'desc')
                ->limit(3)
                ->get();
        } catch (\Exception $e) {
            $recettes_totales = 0;
            $derniers_paiements = [];
        }

        return view('mairie.tableau_de_bord', compact(
            'nb_en_attente', 'total_dossiers', 'nb_approuves', 'taux_traitement', 'recettes_totales', 'derniers_paiements'
        ));
    }


}
