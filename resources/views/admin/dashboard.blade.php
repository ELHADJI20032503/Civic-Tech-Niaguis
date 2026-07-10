<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue d'ensemble - Administration Civic-Tech</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f3f4f6; font-family: 'Segoe UI', system-ui, sans-serif; min-height: 100vh; display: flex; margin: 0; }
        
        /* Sidebar Admin Sombre */
        .sidebar { width: 260px; background-color: #0f172a; color: #94a3b8; padding: 24px; flex-shrink: 0; min-height: 100vh; display: flex; flex-direction: column; }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; color: #ffffff; font-weight: 700; margin-bottom: 30px; }
        .nav-section-title { font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #475569; margin-bottom: 12px; text-transform: uppercase; }
        .sidebar-nav { list-style: none; padding-left: 0; margin-bottom: 30px; }
        .sidebar-nav-item { margin-bottom: 4px; }
        .sidebar-nav-link { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; color: #94a3b8; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; }
        .sidebar-nav-link:hover, .sidebar-nav-link.active { background-color: #1e293b; color: #ffffff; }
        .sidebar-nav-link.active { border-left: 4px solid #10b981; background-color: #1e293b; }
        .sidebar-footer { margin-top: auto; background-color: #1e293b; padding: 12px; border-radius: 12px; display: flex; align-items: center; gap: 12px; }

        /* Contenu Dashboard */
        .main-content { flex-grow: 1; padding: 25px 30px; overflow-y: auto; width: 100%; }
        .topbar { background-color: #ffffff; border-radius: 12px; padding: 12px 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .search-input-box { background-color: #f1f5f9; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px; width: 280px; }
        
        /* Compteurs Blancs */
        .kpi-card { background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.01); height: 100%; }
        .kpi-title { font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; }
        .kpi-num { font-size: 24px; font-weight: 700; color: #111827; }
        .kpi-sub { font-size: 11px; font-weight: 600; color: #6b7280; }

        /* Graphiques & Cartes */
        .chart-card { background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.01); margin-bottom: 20px; }
        .action-btn-right { background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; justify-content: space-between; text-decoration: none; color: #374151; font-size: 13.5px; font-weight: 600; margin-bottom: 10px; transition: background 0.2s; }
        .action-btn-right:hover { background-color: #f9fafb; border-color: #cbd5e1; }
        
        /* Barres de Santé */
        .health-bar-container { background-color: #e5e7eb; height: 6px; border-radius: 4px; overflow: hidden; margin-top: 6px; margin-bottom: 12px; }
        .health-fill { height: 100%; }
    </style>
</head>
<body>

    <!-- SIDEBAR STRUCTURÉE -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <span style="font-size: 22px;">🛡️</span>
            <div>
                <span class="d-block text-white" style="font-size: 14px; font-weight: 700;">Civic-Tech</span>
                <span class="d-block" style="font-size: 10px; color: #64748b;">NIAGUIS • ADMIN</span>
            </div>
        </div>

        <span class="nav-section-title">Panneau Administrateur</span>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link @if(Route::is('admin.dashboard')) active @endif">
                    <span>📂 Tableau de bord</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.agents') }}" class="sidebar-nav-link @if(Route::is('admin.agents')) active @endif">
                    <span>👥 Gestion des agents</span>
                    <!-- DYNAMISATION : Affichage de la bulle de notification synchronisée -->
                    <span class="badge bg-danger rounded-pill" style="font-size: 9px;">{{ $nb_en_attente ?? 0 }}</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.statistiques') }}" class="sidebar-nav-link @if(Route::is('admin.statistiques')) active @endif">
                    <span>📊 Statistiques</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.rapports') }}" class="sidebar-nav-link @if(Route::is('admin.rapports')) active @endif">
                    <span>📄 Rapports</span>
                </a>
            </li>
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.configuration') }}" class="sidebar-nav-link @if(Route::is('admin.configuration')) active @endif">
                    <span>⚙️ Configuration</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 12px; flex-shrink: 0;">
                {{ strtoupper(substr(session('user_fullname', 'AD'), 0, 2)) }}
            </div>
            <div>
                <strong class="d-block text-white" style="font-size: 12.5px;">{{ session('user_fullname', 'Utilisateur Connecté') }}</strong>
                <span style="font-size: 10.5px; color: #64748b;">Administrateur Système</span>
            </div>
        </div>
    </div>

    <!-- CONTENU DU MONITORING -->
    <div class="main-content">
        <!-- Topbar Haute Définition -->
        <div class="topbar">
            <input type="text" class="search-input-box" placeholder="🔍 Recherche globale...">
            <div class="d-flex align-items-center gap-4" style="font-size: 12px; font-weight: 600; color: #4b5563; gap: 20px;">
                <span>🟢 Base de données : <span class="text-success">En ligne</span></span>
                <span>🔌 API : <span class="text-success">Stable</span></span>
                <span>⚡ Charge : <span class="text-warning">23 %</span></span>
                <!-- RECTIFICATION : Liaison sur le controlleur universel de deconnexion -->
                <a href="{{ route('logout') }}" class="btn btn-sm btn-danger px-2 text-white" style="font-size: 11px; font-weight:700;">🚪 Déconnexion</a>
            </div>
        </div>

        <!-- En-tête -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h4 fw-bold text-dark mb-1">Vue d'ensemble — Administration</h1>
                <p class="text-muted small mb-0">Surveillez l'ensemble de la plateforme Civic-Tech Niaguis.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-white bg-white border" onclick="window.location.reload();">🔄 Actualiser</button>
                <button class="btn btn-sm btn-success px-3" style="background-color: #15803d; border: none;">📥 Exporter tout</button>
            </div>
        </div>

        <!-- COMPTEURS KPIS MUNICIPAUX DYNAMIQUES -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-4 col-lg-2">
                <div class="kpi-card">
                    <span class="kpi-title">Utilisateurs 👥</span>
                    <div class="kpi-num my-1">{{ $total_utilisateurs ?? 0 }}</div>
                    <span class="kpi-sub text-success">📈 +1 ce mois</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="kpi-card">
                    <span class="kpi-title">Relais Actifs ⚡</span>
                    <div class="kpi-num my-1">{{ $nb_relais ?? 0 }}</div>
                    <span class="kpi-sub text-success">📈 +2 ce mois</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="kpi-card">
                    <span class="kpi-title">Officiers 👤</span>
                    <div class="kpi-num my-1">{{ $nb_officiers ?? 0 }}</div>
                    <span class="kpi-sub text-muted">➔ Stable</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="kpi-card">
                    <span class="kpi-title">Demandes Total 📄</span>
                    <div class="kpi-num my-1">{{ $total_demandes ?? 0 }}</div>
                    <span class="kpi-sub text-success">📈 +6 ce mois</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="kpi-card">
                    <span class="kpi-title">En Attente ⌛</span>
                    <div class="kpi-num my-1 text-danger">{{ $nb_en_attente ?? 0 }}</div>
                    <span class="kpi-sub text-danger">⚠️ À traiter</span>
                </div>
            </div>
            <div class="col-6 col-md-4 col-lg-2">
                <div class="kpi-card">
                    <span class="kpi-title">Infrastructure 🔌</span>
                    <div class="kpi-num my-1 text-success">100%</div>
                    <span class="kpi-sub text-success">✔ Opérationnelle</span>
                </div>
            </div>
        </div>

        <!-- ZONE DES MONITORINGS AVANCÉS -->
        <div class="row">
                    <!-- ZONE DES MONITORINGS AVANCÉS -->
        <div class="row">
            <!-- 1. GRAPHIQUE D'ACTIVITÉ GLOBAL (FLUX ÉTAT CIVIL) -->
            <div class="col-lg-8 mb-4">
                <div class="chart-card">
                    <h5 class="fw-bold h6 text-dark mb-3">📈 Flux d'enregistrement de l'État Civil (Niaguis Centre)</h5>
                    <p class="text-muted small">Suivi macroscopique des naissances, mariages et décès synchronisés en base 3NF.</p>
                    
                    <!-- Simulation visuelle du monitoring de charge réseau -->
                    <div class="mt-4">
                        <div class="d-flex justify-content-between small fw-bold text-secondary mb-1">
                            <span>Traitement des Actes (Mairie)</span>
                            <span class="text-success">98% Synchro</span>
                        </div>
                        <div class="health-bar-container">
                            <div class="health-fill bg-success" style="width: 98%;"></div>
                        </div>

                        <div class="d-flex justify-content-between small fw-bold text-secondary mb-1">
                            <span>Saisie terrain décentralisée (Relais)</span>
                            <span class="text-info">87% Activité</span>
                        </div>
                        <div class="health-bar-container">
                            <div class="health-fill bg-info" style="width: 87%;"></div>
                        </div>

                        <div class="d-flex justify-content-between small fw-bold text-secondary mb-1">
                            <span>Plan de Continuité d'Activité (PCA Java 8)</span>
                            <span class="text-warning">Prêt en tâche de fond</span>
                        </div>
                        <div class="health-bar-container">
                            <div class="health-fill bg-warning" style="width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. PANNEAU DES RACCOURCIS ET ACTIONS STRATÉGIQUES -->
            <div class="col-lg-4 mb-4">
                <div class="chart-card">
                    <h5 class="fw-bold h6 text-dark mb-3">🛠️ Raccourcis Système ROOT</h5>
                    <p class="text-muted small mb-4">Accédez directement aux modules de configuration core.</p>
                    
                    <a href="{{ route('admin.agents') }}" class="action-btn-right">
                        <span>👥 Gérer les agents communaux</span>
                        <span class="text-success">➔</span>
                    </a>
                    
                    <a href="{{ route('admin.statistiques') }}" class="action-btn-right">
                        <span>📊 Rapports démographiques ANSD</span>
                        <span class="text-success">➔</span>
                    </a>
                    
                    <a href="{{ route('admin.configuration') }}" class="action-btn-right">
                        <span>⚙️ Configuration de l'infrastructure</span>
                        <span class="text-success">➔</span>
                    </a>
                </div>
            </div>
        </div> <!-- Fin de la row des monitorings -->

    </div> <!-- Fin de la main-content -->
</body>
</html>

