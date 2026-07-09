<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapports Financiers - Administration Civic-Tech</title>
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
            <li class="sidebar-nav-item"><a href="{{ route('admin.rapports') }}" class="sidebar-nav-link active"><span>📄 Rapports</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('admin.configuration') }}" class="sidebar-nav-link"><span>⚙️ Configuration</span></a></li>
        </ul>
                <!-- AJOUT DU FOOTER DYNAMIQUE  -->
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

    <!-- ZONE DE TRAITEMENT DES COMPTES -->
    <div class="main-content">
        <div class="topbar">
            <h4 class="h5 fw-bold text-dark mb-0">📄 Bilans Financiers & Caisse Publique</h4>
            <span class="badge bg-danger px-3 py-2 fw-bold">AUDIT MODE</span>
        </div>

        <div class="content-card text-center py-5">
            <span class="text-muted small fw-bold text-uppercase d-block mb-2" style="letter-spacing: 0.5px;">Fonds Municipaux Collectés au Guichet</span>
            <h2 class="text-success fw-bold display-4 mb-3">{{ number_format($total_recettes, 0, ',', ' ') }} <span class="h2">FCFA</span></h2>
            <p class="text-muted small mx-auto mb-4" style="max-width: 550px;">Ce montant agrège l'ensemble des taxes d'instruction perçues par le régisseur de recettes lors de la délivrance physique des actes d'état civil signés et archivés (Barème : 1 000 FCFA par document).</p>
            <button class="btn btn-outline-success font-size-13 fw-bold px-4 py-2" onclick="window.print()">🖨️ Exporter l'état financier de la commune</button>
        </div>
    </div>

</body>
</html>
