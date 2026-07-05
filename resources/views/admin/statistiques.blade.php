<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><title>Statistiques - Admin</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f3f4f6; font-family: 'Segoe UI', sans-serif; display: flex; margin: 0; }
        .sidebar { width: 260px; background-color: #0f172a; color: #94a3b8; padding: 24px; min-height: 100vh; display: flex; flex-direction: column; }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; color: #ffffff; font-weight: 700; margin-bottom: 30px; }
        .sidebar-nav { list-style: none; padding-left: 0; }
        .sidebar-nav-link { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; color: #94a3b8; text-decoration: none; border-radius: 8px; font-size: 14px; }
        .sidebar-nav-link:hover, .sidebar-nav-link.active { background-color: #1e293b; color: #ffffff; border-left: 4px solid #10b981; }
        .main-content { flex-grow: 1; padding: 30px; }
        .stat-card { background: white; border-radius: 12px; padding: 25px; border: 1px solid #e5e7eb; }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-brand"><span>🛡️</span><div><span class="fw-bold">Civic-Tech</span><br><span style="font-size:10px;">ADMIN</span></div></div>
                <!-- BARRE LATÉRALE SUPER-ADMINISTRATEUR ALIGNÉE SUR LES ROUTES RÉELLES -->
        <span class="nav-section-title">Panneau Administrateur</span>
        <ul class="sidebar-nav">
            <!-- 1. TABLEAU DE BORD (VUE D'ENSEMBLE) -->
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-link @if(Route::is('admin.dashboard')) active @endif">
                    <span>📂 Tableau de bord</span>
                </a>
            </li>
            
            <!-- 2. GESTION DES AGENTS -->
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.agents') }}" class="sidebar-nav-link @if(Route::is('admin.agents')) active @endif">
                    <span>👥 Gestion des agents</span>
                    <span class="badge bg-danger rounded-pill" style="font-size: 9px;">1</span>
                </a>
            </li>
            
            <!-- 3. STATISTIQUES INFRASTRUCTURE -->
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.statistiques') }}" class="sidebar-nav-link @if(Route::is('admin.statistiques')) active @endif">
                    <span>📊 Statistiques</span>
                </a>
            </li>
            
            <!-- 4. RAPPORTS GÉNÉRAUX -->
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.rapports') }}" class="sidebar-nav-link @if(Route::is('admin.rapports')) active @endif">
                    <span>📄 Rapports</span>
                </a>
            </li>
            
            <!-- 5. CONFIGURATION CORE SYSTEM -->
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.configuration') }}" class="sidebar-nav-link @if(Route::is('admin.configuration')) active @endif">
                    <span>⚙️ Configuration</span>
                </a>
            </li>
        </ul>

    </div>
    <div class="main-content">
        <h1 class="h4 fw-bold text-dark mb-4">📊 Volumes Globaux de Données d'État Civil</h1>
        <div class="stat-card" style="max-width: 600px;">
            <h5 class="fw-bold text-dark mb-4" style="font-size: 14px;">État des registres 3NF de Niaguis</h5>
            <div class="alert alert-success border-0 mb-2">👶 <strong>Naissances comptabilisées :</strong> {{ $naissances }} dossiers</div>
            <div class="alert alert-primary border-0 mb-2">💍 <strong>Mariages transcrits :</strong> {{ $mariages }} dossiers</div>
            <div class="alert alert-danger border-0">🪦 <strong>Décès enregistrés :</strong> {{ $deces }} dossiers</div>
        </div>
    </div>
</body>
</html>
