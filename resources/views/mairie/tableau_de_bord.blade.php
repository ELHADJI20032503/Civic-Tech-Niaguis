<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Mairie - Civic-Tech Niaguis</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f3f4f6; font-family: 'Segoe UI', system-ui, sans-serif; min-height: 100vh; display: flex; margin: 0; }
        .sidebar { width: 260px; background-color: #1e293b; color: #94a3b8; padding: 24px; flex-shrink: 0; min-height: 100vh; display: flex; flex-direction: column; }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; color: #ffffff; font-weight: 700; margin-bottom: 40px; }
        .sidebar-brand-icon { background-color: #059669; padding: 6px 10px; border-radius: 8px; font-size: 18px; }
        .nav-section-title { font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b; margin-bottom: 12px; text-transform: uppercase; }
        .sidebar-nav { list-style: none; padding-left: 0; margin-bottom: 30px; }
        .sidebar-nav-item { margin-bottom: 4px; }
        .sidebar-nav-link { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; color: #94a3b8; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; }
        .sidebar-nav-link:hover, .sidebar-nav-link.active { background-color: #334155; color: #ffffff; }
        .sidebar-footer { margin-top: auto; background-color: #0f172a; padding: 12px; border-radius: 12px; display: flex; align-items: center; gap: 12px; }
        .main-content { flex-grow: 1; padding: 30px 40px; }
        .dashboard-card { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.01); height: 100%; }
        .progress-circle { width: 100px; height: 100px; border-radius: 50%; background: radial-gradient(closest-side, white 79%, transparent 80% 100%), conic-gradient(#059669 var(--progress), #e2e8f0 0); display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto; }
    </style>
</head>
<body>

    <!-- SIDEBAR CORRIGÉE SANS LE DOUBLON "NAVIGATION" -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">🛡️</div>
            <div>
                <span class="d-block" style="font-size: 14px; font-weight: 700;">Civic-Tech</span>
                <span class="d-block" style="font-size: 10px; opacity: 0.6;">Niaguis</span>
            </div>
        </div>
        
        <span class="nav-section-title">Navigation</span>
        <ul class="sidebar-nav">
            <!-- RECTIFICATION DE L'ONGLET ACTIF POUR CETTE PAGE -->
            <li class="sidebar-nav-item"><a href="{{ route('mairie.tableau_de_bord') }}" class="sidebar-nav-link active"><span>📊 Tableau de bord</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link"><span>📂 File d'attente</span><span class="badge bg-danger rounded-pill" style="font-size: 10px; margin-left: 5px;">{{ $nb_en_attente }}</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.documents') }}" class="sidebar-nav-link"><span>📄 Documents civils</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.citoyens') }}" class="sidebar-nav-link"><span>👥 Citoyens</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.tableau_de_bord') }}" class="sidebar-nav-link"><span>📈 Rapports</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.statistiques') }}" class="sidebar-nav-link"><span>📊 Statistiques</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.tableau_de_bord') }}" class="sidebar-nav-link"><span>⚙️ Paramètres</span></a></li>
        </ul>
        <div class="sidebar-footer">
            <div style="font-size: 20px;">👤</div>
            <div>
                <strong class="d-block text-white" style="font-size: 12.5px;">Moussa Baldé</strong>
                <span style="font-size: 10.5px; opacity: 0.6;">Officier d'État Civil</span>
            </div>
        </div>
    </div>

    <!-- CONTENU PRINCIPAL DE TA MAQUETTE -->
    <div class="main-content">
        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">Aperçu Général de l'Activité</h1>
            <p class="text-muted small mb-0">Suivez l'efficacité globale du bureau municipal d'état civil de Niaguis.</p>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="dashboard-card text-center">
                    <span class="text-muted small fw-bold text-uppercase d-block mb-3">⚡ Efficacité d'Instruction</span>
                    <div class="progress-circle" style="--progress: {{ $taux_traitement }}%;">
                        <strong class="h3 mb-0 text-dark">{{ $taux_traitement }}%</strong>
                    </div>
                    <span class="text-muted small d-block">Des dossiers soumis ont été instruits, signés et archivés par la régie [2.2].</span>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card">
                    <span class="text-muted small fw-bold text-uppercase d-block mb-3">📈 Activité Globale</span>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2 font-size-14">
                        <span class="text-secondary">Dossiers reçus (Total)</span>
                        <strong class="text-dark">{{ $total_dossiers }}</strong>
                    </div>
                    <div class="d-flex justify-content-between border-bottom pb-2 mb-2 font-size-14">
                        <span class="text-secondary">En attente d'évaluation</span>
                        <strong class="text-warning">{{ $nb_en_attente }}</strong>
                    </div>
                    <div class="d-flex justify-content-between font-size-14">
                        <span class="text-secondary">Dossiers approuvés</span>
                        <strong class="text-success">{{ $nb_approuves }}</strong>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="dashboard-card border-success">
                    <span class="text-muted small fw-bold text-uppercase d-block mb-2">💰 Solde de la Caisse</span>
                    <h2 class="h2 fw-bold text-success mb-2">{{ number_format($recettes_totales, 0, ',', ' ') }} FCFA</h2>
                    <span class="text-muted small d-block">Fonds collectés physiquement au guichet pour la délivrance des actes.</span>
                </div>
            </div>
        </div>

        <div class="dashboard-card">
            <h5 class="fw-bold text-dark mb-3">Dernières transactions au Guichet</h5>
            <div class="table-responsive">
                <table class="table align-middle table-hover mb-0">
                    <thead class="table-light" style="font-size: 11px; text-transform: uppercase;">
                        <tr>
                            <th>N° Dossier</th>
                            <th>Citoyen</th>
                            <th>Montant perçu</th>
                            <th>Date paiement</th>
                            <th class="text-end">Régie</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13.5px; color: #334155;">
                        @forelse($derniers_paiements as $paiement)
                            <tr>
                                <td class="fw-bold text-secondary">#{{ $paiement->numero_suivi }}</td>
                                <td><strong>{{ $paiement->prenom }} {{ $paiement->nom }}</strong></td>
                                <td class="text-success fw-bold">+{{ number_format($paiement->montant, 0, ',', ' ') }} F</td>
                                <td class="text-muted">{{ date('d/m/Y H:i', strtotime($paiement->date_paiement)) }}</td>
                                <td class="text-end"><span class="badge bg-success-subtle text-success px-3 py-1">Encaissé</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center p-4 text-muted small">Aucun encaissement enregistré aujourd'hui.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>
