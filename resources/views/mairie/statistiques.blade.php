<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports & Statistiques - Civic-Tech Niaguis</title>
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
        .stat-card { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.01); height: 100%; }
        .progress-bar-custom { height: 12px; border-radius: 6px; background-color: #e2e8f0; overflow: hidden; margin-top: 10px; }
        .progress-fill { height: 100%; background-color: #059669; }
    </style>
</head>
<body>

    <!-- BARRE LATÉRALE MUNICIPALE -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">🛡️</div>
            <div>
                <span class="d-block" style="font-size: 14px; font-weight: 700;">Civic-Tech</span>
                <span class="d-block" style="font-size: 10px; opacity: 0.6;">Niaguis</span>
            </div>
        </div>

        <span class="nav-section-title">Navigation</span>
                <span class="nav-section-title">Navigation</span>
                <!-- BARRE LATÉRALE DYNAMIQUE INTELLIGENTE (ZÉRO ERREUR) -->
        <span class="nav-section-title">Navigation</span>
        <ul class="sidebar-nav">
            <!-- 1. TABLEAU DE BORD -->
            <li class="sidebar-nav-item">
                <a href="{{ route('mairie.tableau_de_bord') }}" class="sidebar-nav-link @if(Route::is('mairie.tableau_de_bord')) active @endif">
                    <span>📊 Tableau de bord</span>
                </a>
            </li>
            
            <!-- 2. FILE D'ATTENTE -->
            <li class="sidebar-nav-item">
                <a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link @if(Route::is('mairie.dashboard')) active @endif">
                    <span>📂 File d'attente</span>
                    <span class="badge bg-danger rounded-pill" style="font-size: 10px;">{{ $nb_en_attente }}</span>
                </a>
            </li>
            
            <!-- 3. DOCUMENTS CIVILS -->
            <li class="sidebar-nav-item">
                <a href="{{ route('mairie.documents') }}" class="sidebar-nav-link @if(Route::is('mairie.documents')) active @endif">
                    <span>📄 Documents civils</span>
                </a>
            </li>
            
            <!-- 4. CITOYENS -->
            <li class="sidebar-nav-item">
                <a href="{{ route('mairie.citoyens') }}" class="sidebar-nav-link @if(Route::is('mairie.citoyens')) active @endif">
                    <span>👥 Citoyens</span>
                </a>
            </li>
            
            <!-- 5. RAPPORTS (Lien propre distinct ou temporaire) -->
            <li class="sidebar-nav-item">
                <a href="{{ route('mairie.rapports') }}" class="sidebar-nav-link @if(Route::is('mairie.rapports')) active @endif">
                    <span>📈 Rapports</span>
                </a>
            </li>
            
            <!-- 6. STATISTIQUES -->
            <li class="sidebar-nav-item">
                <a href="{{ route('mairie.statistiques') }}" class="sidebar-nav-link @if(Route::is('mairie.statistiques')) active @endif">
                    <span>📊 Statistiques</span>
                </a>
            </li>
            
            <!-- 7. PARAMÈTRES -->
            <li class="sidebar-nav-item">
                <a href="{{ route('mairie.parametres') }}" class="sidebar-nav-link @if(Route::is('mairie.parametres')) active @endif">
                    <span>⚙️ Paramètres</span>
                </a>
            </li>
        </ul>


        <div class="sidebar-footer">
            <div style="font-size: 20px;">👤</div>
            <div>
                <strong class="d-block text-white" style="font-size: 12.5px;">Moussa Baldé</strong>
                <span style="font-size: 10.5px; opacity: 0.6;">Officier d'État Civil</span>
            </div>
        </div>
    </div>

    <!-- CONTENU PRINCIPAL DES STATISTIQUES -->
    <div class="main-content">
        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">Analyses & Statistiques Démographiques</h1>
            <p class="text-muted small mb-0">Suivez les indicateurs de performance d'enregistrement et la comptabilité de la régie de recettes de Niaguis.</p>
        </div>

        <div class="row g-4 mb-4">
            <!-- COMPTEUR DE CAISSE FINANCIÈRE MUNICIPALE -->
            <div class="col-md-6 col-lg-4">
                <div class="stat-card border-success">
                    <span class="text-muted small fw-bold text-uppercase d-block mb-2">💰 Recettes Régie Mairie</span>
                    <h2 class="h1 fw-bold text-success mb-2">{{ number_format($recettes_totales, 0, ',', ' ') }} <span class="h4">FCFA</span></h2>
                    <p class="text-muted small mb-0">Somme perçue au guichet physique lors du retrait des actes (1 000 FCFA par délivrance).</p>
                </div>
            </div>

            <!-- EXAMEN DE LA RÉPARTITION DES COMPOSANTES -->
            <div class="col-md-6 col-lg-8">
                <div class="stat-card">
                    <h5 class="fw-bold text-dark mb-4">Volume d'Actes Enregistrés par Catégorie</h5>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between font-size-14 font-weight-500">
                            <span>📄 Actes de Naissance</span>
                            <strong class="text-dark">{{ $naissances }} dossiers</strong>
                        </div>
                        <div class="progress-bar-custom"><div class="progress-fill" style="width: @if($naissances > 0) {{ ($naissances / ($naissances + $mariages + $deces + 0.1)) * 100 }}% @else 0% @endif; background-color: #10b981;"></div></div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex justify-content-between font-size-14 font-weight-500">
                            <span>💍 Actes de Mariage</span>
                            <strong class="text-dark">{{ $mariages }} dossiers</strong>
                        </div>
                        <div class="progress-bar-custom"><div class="progress-fill" style="width: @if($mariages > 0) {{ ($mariages / ($naissances + $mariages + $deces + 0.1)) * 100 }}% @else 0% @endif; background-color: #3b82f6;"></div></div>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between font-size-14 font-weight-500">
                            <span>🪦 Actes de Décès</span>
                            <strong class="text-dark">{{ $deces }} dossiers</strong>
                        </div>
                        <div class="progress-bar-custom"><div class="progress-fill" style="width: @if($deces > 0) {{ ($deces / ($naissances + $mariages + $deces + 0.1)) * 100 }}% @else 0% @endif; background-color: #ef4444;"></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

