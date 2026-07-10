<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres Mairie - Civic-Tech Niaguis</title>
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
        .topbar { background-color: #ffffff; border-radius: 16px; padding: 16px 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .config-card { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.01); margin-bottom: 24px; }
        .section-title { font-size: 14px; font-weight: 700; color: #1e293b; border-bottom: 2px solid #f1f5f9; padding-bottom: 8px; margin-bottom: 20px; text-transform: uppercase; letter-spacing: 0.5px; }
        .form-label { font-size: 13px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .form-control, .form-select { border-radius: 8px; padding: 10px 14px; font-size: 14px; border: 1px solid #cbd5e1; background-color: #f8fafc; }
        .form-check-input:checked { background-color: #059669; border-color: #059669; }
        .btn-save { background-color: #1e293b; color: white; border: none; padding: 12px 24px; border-radius: 8px; font-size: 14px; font-weight: 600; transition: background 0.2s; }
        .btn-save:hover { background-color: #0f172a; }
    </style>
</head>
<body>

    <!-- BARRE LATÉRALE MUNICIPALE  -->
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
            <li class="sidebar-nav-item"><a href="{{ route('mairie.tableau_de_bord') }}" class="sidebar-nav-link @if(Route::is('mairie.tableau_de_bord')) active @endif"><span>📊 Tableau de bord</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link @if(Route::is('mairie.dashboard')) active @endif"><span>📂 File d'attente</span><span class="badge bg-danger rounded-pill" style="font-size: 10px; margin-left: 5px;">{{ $nb_en_attente }}</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.documents') }}" class="sidebar-nav-link @if(Route::is('mairie.documents')) active @endif"><span>📄 Documents civils</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.citoyens') }}" class="sidebar-nav-link @if(Route::is('mairie.citoyens')) active @endif"><span>👥 Citoyens</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.rapports') }}" class="sidebar-nav-link @if(Route::is('mairie.rapports')) active @endif"><span>📈 Rapports</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.statistiques') }}" class="sidebar-nav-link @if(Route::is('mairie.statistiques')) active @endif"><span>📊 Statistiques</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.parametres') }}" class="sidebar-nav-link @if(Route::is('mairie.parametres')) active @endif"><span>⚙️ Paramètres</span></a></li>
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

    <!-- ZONE CONFIGURATION DES PARAMÈTRES -->
    <div class="main-content">
        <div class="topbar">
            <input type="text" class="search-input-box" placeholder="🔍 Rechercher un paramètre...">
            <div class="d-flex align-items-center gap-3">
                <span style="font-size: 18px; cursor: pointer;">🔔</span>
                <div class="badge bg-dark p-2" style="font-size: 12px; border-radius: 8px;">MB &nbsp;▼</div>
            </div>
        </div>

        <div class="mb-4">
            <h1 class="h3 fw-bold text-dark mb-1">Configuration Générale de la Mairie</h1>
            <p class="text-muted small mb-0"> On Ajuste les règles métiers, les alertes citoyens et les tarifs d'état civil de la commune.</p>
        </div>

        <!-- FORMULAIRE TECHNIQUE  -->
        <form onsubmit="alert('Paramètres municipaux sauvegardés avec succès !'); return false;">
            
            <!-- REGLES FINANCIERES -->
            <div class="config-card">
                <div class="section-title">💰 Tarification de la Régie de Recettes</div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Taxe Acte de Naissance (FCFA)</label>
                        <input type="number" class="form-control" value="1000" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Taxe Acte de Mariage (FCFA)</label>
                        <input type="number" class="form-control" value="2000" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Taxe Acte de Décès (FCFA)</label>
                        <input type="number" class="form-control" value="1000" required>
                    </div>
                </div>
            </div>

            <!-- ALERTES ET NOTIFICATIONS -->
            <div class="config-card">
                <div class="section-title">🔔 Alertes & Communications Citoyennes</div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" id="smsCheck" checked>
                    <label class="form-check-label fw-bold text-dark font-size-14" for="smsCheck">Notifier le citoyen par SMS (Via API Orange/Expresso)</label>
                    <span class="text-muted d-block small">Envoie un SMS automatique avec le N° de suivi dès que l'acte est « Prêt à collecter » [2.2].</span>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="emailCheck">
                    <label class="form-check-label fw-bold text-dark font-size-14" for="emailCheck">Activer les rapports par email hebdomadaires</label>
                    <span class="text-muted d-block small">Transmet automatiquement le bilan comptable de la caisse au Secrétaire Général de la mairie.</span>
                </div>
            </div>

            <!-- PERIMETRE DES RELAIS -->
            <div class="config-card">
                <div class="section-title">📍 Gestion administrative du réseau terrain</div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Délai d'instruction maximum accordé (Heures)</label>
                        <select class="form-select">
                            <option value="24">24 Heures (Traitement express)</option>
                            <option value="48" selected>48 Heures (Délai réglementaire)</option>
                            <option value="72">72 Heures</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Zone de couverture par défaut</label>
                        <input type="text" class="form-control" value="Arrondissement de Niaguis — Ziguinchor" readonly>
                    </div>
                </div>
            </div>

            <!-- BOUTON DE ACTION -->
            <div class="text-end mb-5">
                <button type="submit" class="btn-save shadow-sm">💾 Enregistrer les préférences municipales</button>
            </div>
        </form>
    </div>

</body>
</html>
