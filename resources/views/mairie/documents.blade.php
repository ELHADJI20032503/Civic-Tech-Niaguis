<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registre des Actes Archivés - Civic-Tech Niaguis</title>
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
        .data-card { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
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
                <!-- BARRE LATÉRALE DYNAMIQUE  -->
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
            
            <!-- 5. RAPPORTS  -->
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


                <!-- FOOTER SIDEBAR DYNAMIQUE POUR L'OFFICIER CONNECTÉ -->
        <div class="sidebar-footer" style="margin-top: auto; display: flex; align-items: center; gap: 12px; background-color: #1e293b; padding: 12px; border-radius: 12px;">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 12px; flex-shrink: 0;">
                {{ strtoupper(substr(session('user_fullname', 'OF'), 0, 2)) }}
            </div>
            <div>
                <strong class="d-block text-white" style="font-size: 12.5px;">{{ session('user_fullname', 'Officier Municipal') }}</strong>
                <span style="font-size: 10.5px; color: #64748b;">Officier d'État Civil</span>
            </div>
        </div>

    </div>

    <!-- CONTENU PRINCIPAL -->
    <div class="main-content">
        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">Registre des Actes Civils Signés & Archivés</h1>
            <p class="text-muted small mb-0">Imprimez et consultez les actes officiels définitifs délivrés par la commune.</p>
        </div>

        <div class="data-card">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light" style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase;">
                        <tr>
                            <th>N° Numéro unique</th>
                            <th>Bénéficiaire</th>
                            <th>Type d'Acte</th>
                            <th>Statut Légal</th>
                            <th class="text-end">Impression</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 14px; color: #334155;">
                        @forelse($actes_archives as $acte)
                            <tr>
                                <td class="fw-bold text-success">{{ $acte->numero_suivi }}</td>
                                <td class="text-capitalize"><strong>{{ $acte->prenom }} {{ $acte->nom }}</strong></td>
                                <td><span class="badge bg-dark">Acte de {{ $acte->type_acte }}</span></td>
                                <td><span class="badge bg-success-subtle text-success fw-bold px-3 py-1">📜 Officié & Scellé</span></td>
                                <td class="text-end">
                                    <!-- SIMULATION D'IMPRESSION SYSTÈME  -->
                                    <button class="btn btn-sm btn-outline-success" onclick="window.print()">🖨️ Imprimer l'Acte Officiel</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center p-5 text-muted small">Aucun acte n'a encore été signé et archivé dans le registre de Niaguis.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>

