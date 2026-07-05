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
        .main-content { flex-grow: 1; padding: 25px 30px; overflow-y: auto; }
        .topbar { background-color: #ffffff; border-radius: 12px; padding: 12px 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .search-input-box { background-color: #f1f5f9; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13px; width: 280px; }
        
        /* Compteurs Blancs */
        .kpi-card { background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.01); }
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

    <!-- SIDEBAR DARK NETTOYÉE ET CORRIGÉE -->
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
            <li class="sidebar-nav-item"><a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link active"><span>📂 Tableau de bord</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('admin.agents') }}" class="sidebar-nav-link"><span>👥 Gestion des agents</span><span class="badge bg-danger rounded-pill" style="font-size: 9px;">1</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('admin.statistiques') }}" class="sidebar-nav-link"><span>📊 Statistiques</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('admin.rapports') }}" class="sidebar-nav-link"><span>📄 Rapports</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('admin.configuration') }}" class="sidebar-nav-link"><span>⚙️ Configuration</span></a></li>
        </ul>

        <div class="sidebar-footer">
            <div style="font-size: 20px;">👤</div>
            <div>
                <strong class="d-block text-white" style="font-size: 12.5px;">Elhadji Touré</strong>
                <span style="font-size: 10.5px; color: #64748b;">Administrateur</span>
            </div>
        </div>
    </div>

    <!-- CONTENU DU MONITORING -->
    <div class="main-content">
        <!-- Topbar Haute Définition -->
        <div class="topbar">
            <input type="text" class="search-input-box" placeholder="🔍 Recherche globale...">
            <div class="d-flex align-items-center gap-4" style="font-size: 12px; font-weight: 600; color: #4b5563;">
                <span>🟢 Base de données : <span class="text-success">En ligne</span></span>
                <span>🔌 API : <span class="text-success">Stable</span></span>
                <span>⚡ Charge : <span class="text-warning">23 %</span></span>
                <a href="{{ route('login') }}" class="btn btn-sm btn-light border" style="font-size: 11px;">🚪 Déconnexion</a>
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

        <!-- COMPTEURS KPIS MUNICIPAUX -->
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-2 mb-4">
            <div class="col">
                <div class="kpi-card">
                    <span class="kpi-title">Utilisateurs 👥</span>
                    <div class="kpi-num my-1">{{ $total_utilisateurs }}</div>
                    <span class="kpi-sub text-success">📈 +1 ce mois</span>
                </div>
            </div>
            <div class="col">
                <div class="kpi-card">
                    <span class="kpi-title">Relais Actifs ⚡</span>
                    <div class="kpi-num my-1">{{ $nb_relais }}</div>
                    <span class="kpi-sub text-success">📈 +2 ce mois</span>
                </div>
            </div>
            <div class="col">
                <div class="kpi-card">
                    <span class="kpi-title">Officiers 👤</span>
                    <div class="kpi-num my-1">{{ $nb_officiers }}</div>
                    <span class="kpi-sub text-muted">➔ Stable</span>
                </div>
            </div>
            <div class="col">
                <div class="kpi-card">
                    <span class="kpi-title">Demandes Total 📄</span>
                    <div class="kpi-num my-1">{{ $total_demandes }}</div>
                    <span class="kpi-sub text-success">📈 +6 ce mois</span>
                </div>
            </div>
            <div class="col">
                <div class="kpi-card">
                    <span class="kpi-title">En attente 🕒</span>
                    <div class="kpi-num my-1" style="color: #b45309;">{{ $nb_en_attente }}</div>
                    <span class="kpi-sub text-danger">📉 -2 vs hier</span>
                </div>
            </div>
            <div class="col">
                <div class="kpi-card">
                    <span class="kpi-title">Traitées ✓</span>
                    <div class="kpi-num my-1" style="color: #15803d;">{{ $total_demandes - $nb_en_attente }}</div>
                    <span class="kpi-sub text-success">📈 +4 ce mois</span>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-9">
                <div class="row g-3">
                    <div class="col-md-7">
                        <div class="chart-card" style="height: 340px;">
                            <h6 class="fw-bold text-dark small mb-1">Demandes par mois</h6>
                            <span class="text-muted" style="font-size: 10px;">Soumises vs Traitées — 2026</span>
                            <div class="mt-3" style="height: 240px; background: url('data:image/svg+xml;utf8,<svg xmlns=\'http://w3.org\' viewBox=\'0 0 100 50\'><line x1=\'10\' y1=\'45\' x2=\'90\' y2=\'45\' stroke=\'%23e5e7eb\' stroke-width=\'0.5\'/><rect x=\'20\' y=\'25\' width=\'4\' height=\'20\' fill=\'%233b82f6\'/><rect x=\'25\' y=\'30\' width=\'4\' height=\'15\' fill=\'%2310b981\'/><rect x=\'40\' y=\'15\' width=\'4\' height=\'30\' fill=\'%233b82f6\'/><rect x=\'45\' y=\'22\' width=\'4\' height=\'23\' fill=\'%2310b981\'/><rect x=\'60\' y=\'10\' width=\'4\' height=\'35\' fill=\'%233b82f6\'/><rect x=\'65\' y=\'18\' width=\'4\' height=\'27\' fill=\'%2310b981\'/></svg>') center/contain no-repeat;"></div>
                        </div>
                    </div>
                    <div class="col-md-5">
                                                <div class="chart-card" style="height: 340px;">
                            <h6 class="fw-bold text-dark small mb-1">Types de documents</h6>
                            <span class="text-muted" style="font-size: 10px;">Répartition globale</span>
                            <div class="text-center mt-4">
                                <div style="width: 130px; height: 130px; border-radius: 50%; border: 25px solid #3b82f6; border-top-color: #10b981; border-right-color: #f59e0b; margin: 0 auto 20px auto;"></div>
                                <div class="d-flex justify-content-around text-start" style="font-size: 11px; font-weight: 600;">
                                    <div>🟢 Naissances: 54%</div>
                                    <div>🔵 Mariages: 28%</div>
                                    <div>🟠 Décès: 18%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- VOLET LATÉRAL DROIT : ACTIONS RAPIDES ET SANTÉ DU SYSTÈME -->
            <div class="col-lg-3">
                <div class="chart-card">
                    <h6 class="fw-bold text-dark small mb-3">Actions Rapides</h6>
                    <a href="{{ route('admin.agents') }}" class="action-btn-right"><span>➕ Créer un agent</span><span class="text-muted">➔</span></a>
                    <a href="{{ route('admin.agents') }}" class="action-btn-right"><span>🔑 Attribuer un rôle</span><span class="text-muted">➔</span></a>
                    <a href="{{ route('admin.rapports') }}" class="action-btn-right"><span>📋 Générer un rapport</span><span class="text-muted">➔</span></a>
                </div>

                <div class="chart-card" style="font-size: 12px;">
                    <h6 class="fw-bold text-dark small mb-3">Santé du Système</h6>
                    <div class="d-flex justify-content-between text-muted"><span>Base de données</span><strong class="text-dark">98 %</strong></div>
                    <div class="health-bar-container"><div class="health-fill" style="width: 98%; background-color: #10b981;"></div></div>
                    <div class="d-flex justify-content-between text-muted"><span>API Externe</span><strong class="text-dark">94 %</strong></div>
                    <div class="health-bar-container"><div class="health-fill" style="width: 94%; background-color: #3b82f6;"></div></div>
                    <div class="d-flex justify-content-between text-muted"><span>Serveur fichiers</span><strong class="text-dark">76 %</strong></div>
                    <div class="health-bar-container"><div class="health-fill" style="width: 76%; background-color: #f59e0b;"></div></div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

