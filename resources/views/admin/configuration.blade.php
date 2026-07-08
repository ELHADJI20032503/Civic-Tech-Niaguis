<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration Système - Administration Civic-Tech</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f3f4f6; font-family: 'Segoe UI', system-ui, sans-serif; min-height: 100vh; display: flex; margin: 0; }
        .sidebar { width: 260px; background-color: #0f172a; color: #94a3b8; padding: 24px; flex-shrink: 0; min-height: 100vh; display: flex; flex-direction: column; }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; color: #ffffff; font-weight: 700; margin-bottom: 30px; }
        .nav-section-title { font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #475569; margin-bottom: 12px; text-transform: uppercase; }
        .sidebar-nav { list-style: none; padding-left: 0; margin-bottom: 30px; }
        .sidebar-nav-item { margin-bottom: 4px; }
        .sidebar-nav-link { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; color: #94a3b8; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; }
        .sidebar-nav-link:hover, .sidebar-nav-link.active { background-color: #1e293b; color: #ffffff; border-left: 4px solid #10b981; }
        .main-content { flex-grow: 1; padding: 25px 30px; }
        .topbar { background-color: #ffffff; border-radius: 12px; padding: 12px 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; }
        .content-card { background-color: #ffffff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 35px; box-shadow: 0 1px 3px rgba(0,0,0,0.01); }
    </style>
</head>
<body>

    <!-- BARRE LATÉRALE ADMINISTRATEUR -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <span style="font-size: 22px;">🛡️</span>
            <div><span class="d-block text-white" style="font-size: 14px; font-weight: 700;">Civic-Tech</span><span class="d-block" style="font-size: 10px; color: #64748b;">NIAGUIS • ADMIN</span></div>
        </div>
        <span class="nav-section-title">Panneau Administrateur</span>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item"><a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link"><span>📂 Tableau de bord</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('admin.agents') }}" class="sidebar-nav-link"><span>👥 Gestion des agents</span><span class="badge bg-danger rounded-pill" style="font-size: 9px;">1</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('admin.statistiques') }}" class="sidebar-nav-link"><span>📊 Statistiques</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('admin.rapports') }}" class="sidebar-nav-link"><span>📄 Rapports</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('admin.configuration') }}" class="sidebar-nav-link active"><span>⚙️ Configuration</span></a></li>
        </ul>
                <!-- AJOUT DU FOOTER DYNAMIQUE MANQUANT -->
        <div class="sidebar-footer" style="margin-top: auto; background-color: #1e293b; padding: 12px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 12px; flex-shrink: 0;">
                {{ strtoupper(substr(session('user_fullname', 'AD'), 0, 2)) }}
            </div>
                        <div>
                <!-- Nettoyage de la valeur de secours pour éliminer toute trace fixe -->
                <strong class="d-block text-white" style="font-size: 12.5px;">
                    {{ session('user_fullname', 'Admin Local') }}
                </strong>
                <span style="font-size: 10.5px; color: #64748b;">Administrateur Système</span>
            </div>

        </div>

    </div>

    <!-- ZONE CONTENU -->
    <div class="main-content">
        <div class="topbar">
            <h4 class="h5 fw-bold text-dark mb-0">⚙️ Constantes Système & Sécurité</h4>
            <span class="badge bg-danger px-3 py-2 fw-bold">SYSTEM ROOT</span>
        </div>

        <div class="content-card">
            <h5 class="fw-bold text-dark h6 mb-4">Variables d'Infrastructure (Monitoring Intranet)</h5>
            <div class="p-3 bg-light rounded-3 mb-3 border">🔒 Algorithme d'authentification : <span class="text-success fw-bold">BCRYPT Sécurisé Activé</span></div>
            <div class="p-3 bg-light rounded-3 mb-3 border">🔌 Passerelle API État Civil : <span class="text-success fw-bold">Disponible & Synchrone</span></div>
            <div class="p-3 bg-light rounded-3 mb-3 border">🗄️ Normalisation SGBD MySQL : <span class="text-primary fw-bold">Modèle Relationnel Strict 3NF</span></div>
            <div class="p-3 bg-light rounded-3 border">🔋 Système de fichiers Preuves : <span class="text-dark fw-bold">Laravel Public Storage Linked</span></div>
        </div>
    </div>

</body>
</html>
