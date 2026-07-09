<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des agents - Civic-Tech</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f3f4f6; font-family: 'Segoe UI', sans-serif; display: flex; margin: 0; }
        .sidebar { width: 260px; background-color: #0f172a; color: #94a3b8; padding: 24px; min-height: 100vh; display: flex; flex-direction: column; }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; color: #ffffff; font-weight: 700; margin-bottom: 30px; }
        .sidebar-nav { list-style: none; padding-left: 0; }
        .sidebar-nav-link { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; color: #94a3b8; text-decoration: none; border-radius: 8px; font-size: 14px; }
        .sidebar-nav-link:hover, .sidebar-nav-link.active { background-color: #1e293b; color: #ffffff; border-left: 4px solid #10b981; }
        .main-content { flex-grow: 1; padding: 30px; }
        .admin-card { background: white; border-radius: 12px; padding: 25px; border: 1px solid #e5e7eb; margin-bottom: 25px; }
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
            
            <!-- 5. CONFIGURATION  -->
            <li class="sidebar-nav-item">
                <a href="{{ route('admin.configuration') }}" class="sidebar-nav-link @if(Route::is('admin.configuration')) active @endif">
                    <span>⚙️ Configuration</span>
                </a>
            </li>
        </ul>
                <!-- AJOUT DU FOOTER  -->
        <div class="sidebar-footer" style="margin-top: auto; background-color: #1e293b; padding: 12px; border-radius: 12px; display: flex; align-items: center; gap: 12px;">
            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 12px; flex-shrink: 0;">
                {{ strtoupper(substr(session('user_fullname', 'AD'), 0, 2)) }}
            </div>
                        <div>
                <!-- Nettoyage de la valeur de secours  -->
                <strong class="d-block text-white" style="font-size: 12.5px;">
                    {{ session('user_fullname', 'Admin Local') }}
                </strong>
                <span style="font-size: 10.5px; color: #64748b;">Administrateur Système</span>
            </div>

        </div>

    </div>
    <div class="main-content">
        <h1 class="h4 fw-bold text-dark mb-4">👥 Gestion des Comptes Professionnels</h1>
        <div class="admin-card">
            <h5 class="fw-bold h6 mb-3 text-dark">Enregistrer un nouvel Agent de Mairie ou Relais</h5>
            <form action="{{ route('admin.agents.store') }}" method="POST" style="max-width: 500px;">
                @csrf
                <div class="mb-3"><label class="form-label small fw-bold">Prénom</label><input type="text" class="form-control" name="prenom" required placeholder="Ex: Fatou"></div>
                <div class="mb-3"><label class="form-label small fw-bold">Nom</label><input type="text" class="form-control" name="nom" required placeholder="Ex: Sarr"></div>
                <div class="mb-3"><label class="form-label small fw-bold">Adresse Email de connexion</label><input type="email" class="form-control" name="login" required placeholder="name@niaguis.sn"></div>
                <div class="mb-3"><label class="form-label small fw-bold">Rôle Applicatif</label><select class="form-select" name="role"><option value="relais">Relais Terrain (Aminata Sall...)</option><option value="mairie">Officier d'État Civil (Moussa Baldé...)</option></select></div>
                <div class="mb-3"><label class="form-label small fw-bold">Mot de passe temporaire</label><input type="password" class="form-control" name="password" required placeholder="Saisir un mot de passe sécurisé"></div>
                <button type="submit" class="btn btn-success w-100 fw-bold">💾 Activer le compte de l'agent</button>
            </form>
        </div>
    </div>
</body>
</html>
