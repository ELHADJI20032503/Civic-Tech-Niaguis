<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Relais - Civic-Tech Niaguis</title>
    <!-- Chargement local (NF-01 Intranet Mairie) -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; min-height: 100vh; }
        .navbar-custom { background: #0c4a26; color: white; padding: 15px 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .welcome-card { background: linear-gradient(135deg, #115e59, #0c4a26); color: white; border: none; border-radius: 16px; padding: 25px; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(12,74,38,0.15); }
        .stat-box { background: white; border: 1px solid #e2e8f0; border-radius: 14px; padding: 20px; text-align: center; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); height: 100%; transition: transform 0.2s; }
        .stat-box:hover { transform: translateY(-2px); }
        .stat-number { font-size: 28px; font-weight: 700; display: block; margin-bottom: 4px; }
        .color-pending { color: #d97706; }
        .color-approved { color: #16a34a; }
        .color-progress { color: #0284c7; }
        .action-card { background: white; border: 1px solid #e2e8f0; border-radius: 16px; padding: 20px; margin-bottom: 16px; display: flex; align-items: center; justify-content: space-between; cursor: pointer; transition: all 0.2s; text-decoration: none; }
        .action-card:hover { transform: translateY(-2px); border-color: #10b981; box-shadow: 0 4px 12px rgba(0,0,0,0.04); }
        .icon-wrapper { width: 48px; height: 48px; border-radius: 12px; background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .demand-item { background: white; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; }
        .badge-status { font-size: 12px; font-weight: 600; padding: 6px 12px; border-radius: 20px; }
        .badge-pending { background-color: #fef3c7; color: #d97706; }
        .badge-approved { background-color: #dcfce7; color: #16a34a; }
        .badge-exam { background-color: #e0f2fe; color: #0284c7; }
        .badge-rejete { background-color: #fee2e2; color: #dc2626; }
    </style>
</head>
<body>

    <!-- Barre de Navigation Institutionnelle Fluide -->
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-2">
            <span style="font-size: 20px;">🛡️</span>
            <div>
                <strong class="d-block" style="font-size: 15px;">Espace Relais Communautaire</strong>
                <span style="font-size: 11px; opacity: 0.8;">Mairie de Niaguis — Plateforme Décentralisée</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-3">
            <span style="font-size: 20px; cursor: pointer; position: relative;">🔔<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 9px; padding: 3px 5px;">2</span></span>
            <span class="badge bg-white text-dark px-3 py-2 fw-bold" style="border-radius: 8px;">Terrain</span>
        </div>
    </nav>

    <!-- Conteneur Principal Flexible Grille Bootstrap -->
    <div class="container my-4 mb-5">
        <div class="row g-4">
            
            <!-- COLONNE GAUCHE : IDENTITÉ ET STATISTIQUES -->
            <div class="col-lg-4">
                <!-- Carte d'identité du Relais connecté -->
                <div class="welcome-card">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div style="font-size: 32px; background: rgba(255,255,255,0.2); padding: 8px 14px; border-radius: 50%;">👤</div>
                        <div>
                            <span class="d-block small" style="opacity: 0.8;">Session active,</span>
                            <h4 class="fw-bold mb-0" style="font-size: 18px;">{{ session('user_fullname', 'Aminata Sall') }}</h4>
                            <span style="font-size: 12px; opacity: 0.9;">Zone : Commune de Niaguis</span>
                        </div>
                    </div>
                </div>

                <!-- Grille Responsive des Compteurs Réels SQL -->
                <h5 class="text-muted fw-bold mb-3" style="font-size: 12px; letter-spacing: 0.5px;">VOS COMPTEURS EN TEMPS RÉEL</h5>
                <div class="row g-2 mb-4">
                    <div class="col-4 col-md-4 col-lg-10 col-xl-4 mx-lg-auto mb-lg-2">
                        <div class="stat-box">
                            <span class="stat-number color-pending">{{ $nb_en_attente }}</span>
                            <span class="text-muted fw-bold" style="font-size: 11px;">En attente</span>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-10 col-xl-4 mx-lg-auto mb-lg-2">
                        <div class="stat-box">
                            <span class="stat-number color-approved">{{ $nb_approuves }}</span>
                            <span class="text-muted fw-bold" style="font-size: 11px;">Approuvés</span>
                        </div>
                    </div>
                    <div class="col-4 col-md-4 col-lg-10 col-xl-4 mx-lg-auto">
                        <div class="stat-box">
                            <span class="stat-number color-progress">{{ $nb_en_cours }}</span>
                            <span class="text-muted fw-bold" style="font-size: 11px;">Prêts / En cours</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- COLONNE DROITE : ACTIONS ET HISTORIQUE -->
            <div class="col-lg-8">
                <!-- Actions Tactiles Grands Formulaires -->
                <h5 class="text-muted fw-bold mb-3" style="font-size: 12px; letter-spacing: 0.5px;">ACTIONS RAPIDES SUR LE TERRAIN</h5>
                
                <a href="{{ route('relais.choix_acte') }}" class="action-card">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper text-success" style="background-color: #dcfce7;">＋</div>
                        <div>
                            <strong class="d-block text-dark" style="font-size: 15px;">Nouvelle Déclaration Multi-Actes</strong>
                            <span class="text-muted small" style="font-size: 12px;">Déclarer une Naissance, un Mariage civil ou un Décès</span>
                        </div>
                    </div>
                    <span class="text-muted fw-bold">➔</span>
                </a>

                <!-- Liste Dynamique des Dernières Demandes Extrayant de MySQL -->
                <h5 class="text-muted fw-bold my-4" style="font-size: 12px; letter-spacing: 0.5px;">HISTORIQUE DES 5 DERNIÈRES DEMANDES SOUMISES</h5>

                @forelse($dernieres_demandes as $demande)
                    <div class="demand-item">
                        <div class="d-flex align-items-center gap-3">
                            <div class="icon-wrapper" style="background-color: #f8fafc;">
                                @if($demande->type_acte === 'Naissance') 📄 @elseif($demande->type_acte === 'Mariage') 💍 @else 🪦 @endif
                            </div>
                            <div>
                                <strong class="d-block text-dark" style="font-size: 14px;">{{ $demande->prenom }} {{ $demande->nom }}</strong>
                                <span class="text-muted" style="font-size: 12px;">Acte de {{ $demande->type_acte }} • {{ date('d/m/Y', strtotime($demande->date_creation)) }}</span>
                            </div>
                        </div>
                        
                        @if($demande->statut === 'Reçu')
                            <span class="badge-status badge-pending">🕒 Reçu</span>
                        @elseif($demande->statut === 'Prêt')
                            <span class="badge-status badge-exam">📦 Prêt pour retrait</span>
                        @elseif($demande->statut === 'Signé & Archivé')
                            <span class="badge-status badge-approved">✓ Archivé & Soldé</span>
                        | @else
                            <span class="badge-status badge-rejete">✕ Rejeté</span>
                        @endif
                    </div>
                @empty
                    <div class="text-center p-5 bg-white rounded-3 border border-dashed text-secondary small shadow-sm">
                        Aucun dossier n'a encore été soumis par votre compte relais.
                    </div>
                @endforelse
            </div>

        </div>
    </div>

</body>
</html>
