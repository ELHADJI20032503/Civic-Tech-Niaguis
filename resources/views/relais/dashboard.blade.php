<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Relais - Civic-Tech Niaguis</title>
    <!-- Chargement local de Bootstrap (Conformité Intranet NF-01) -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #0f172a; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; justify-content: center; align-items: center; padding: 20px 0; }
        .phone-container { width: 390px; height: 844px; background-color: #f8fafc; border: 12px solid #1e293b; border-radius: 40px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); overflow-y: auto; position: relative; display: flex; flex-direction: column; }
        .phone-container::-webkit-scrollbar { display: none; }
        .header-app { background-color: #0c4a26; color: #ffffff; padding: 30px 20px 20px 20px; border-bottom-left-radius: 24px; border-bottom-right-radius: 24px; }
        .user-card { background: linear-gradient(135deg, #115e59, #0f766e); border-radius: 16px; padding: 15px; margin-top: 15px; display: flex; align-items: center; gap: 12px; }
        .stat-box { border-radius: 12px; padding: 12px; text-align: center; font-weight: bold; font-size: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); }
        .stat-pending { background-color: #fef3c7; color: #b45309; }
        .stat-approved { background-color: #dcfce7; color: #15803d; }
        .stat-collect { background-color: #f3e8ff; color: #6b21a8; }
        .action-card { background-color: #ffffff; border-radius: 16px; padding: 16px; margin-bottom: 12px; display: flex; align-items: center; justify-content: space-between; border: 1px solid #f1f5f9; cursor: pointer; transition: transform 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.01); }
        .action-card:hover { transform: translateY(-2px); }
        .icon-wrapper { width: 40px; height: 40px; border-radius: 10px; background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 18px; }
        .demand-item { background-color: #ffffff; border-radius: 14px; padding: 12px 16px; margin-bottom: 8px; display: flex; align-items: center; justify-content: space-between; border: 1px solid #f1f5f9; }
        .badge-status { font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; }
        .badge-pending { background-color: #fef3c7; color: #d97706; }
        .badge-approved { background-color: #dcfce7; color: #16a34a; }
        .badge-exam { background-color: #e0f2fe; color: #0284c7; }
        .nav-bottom { background-color: #ffffff; border-top: 1px solid #e2e8f0; padding: 10px 0; display: flex; justify-content: space-around; position: sticky; bottom: 0; width: 100%; margin-top: auto; }
        .nav-item { text-align: center; font-size: 11px; color: #64748b; text-decoration: none; font-weight: 500; }
        .nav-item.active { color: #16a34a; font-weight: 700; }
    </style>
</head>
<body>

    <div class="phone-container">
        <!-- Topbar Mobile App -->
        <div class="header-app">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="d-block fw-bold" style="font-size: 14px;">🛡️ Espace Relais</span>
                    <span style="font-size: 10px; opacity: 0.7;">Civic-Tech Niaguis</span>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span style="font-size: 18px; position: relative;">🔔<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 8px; padding: 3px 5px;">2</span></span>
                    <span style="font-size: 20px; margin-left: 10px;">👤</span>
                </div>
            </div>

            <!-- Carte Utilisateur Dynamique -->
            <div class="user-card">
                <div style="font-size: 24px;">👤</div>
                <div>
                    <span class="d-block small" style="opacity: 0.8;">Bonjour,</span>
                    <strong class="d-block" style="font-size: 15px;">{{ session('user_fullname', 'Aminata Sall') }}</strong>
                    <span style="font-size: 11px; opacity: 0.9;">Relais Communautaire • Niaguis</span>
                </div>
            </div>
        </div>

        <div class="p-3">
            <!-- Grille des Statistiques Dynamiques (Jalon 3 Backend) -->
            <div class="row g-2 mb-4">
                <div class="col-4">
                    <div class="stat-box stat-pending"><span class="d-block h4 fw-bold mb-0">{{ $nb_en_attente }}</span>En attente</div>
                </div>
                <div class="col-4">
                    <div class="stat-box stat-approved"><span class="d-block h4 fw-bold mb-0">{{ $nb_approuves }}</span>Approuvés</div>
                </div>
                <div class="col-4">
                    <div class="stat-box stat-collect"><span class="d-block h4 fw-bold mb-0">{{ $nb_en_cours }}</span>En cours</div>
                </div>
            </div>

            <!-- Actions Rapides -->
            <span class="text-muted fw-bold d-block mb-3" style="font-size: 11px; letter-spacing: 0.5px;">ACTIONS RAPIDES</span>
            
            

            <div class="action-card" onclick="location.href='{{ route('relais.choix_acte') }}'">

                <div class="d-flex align-items-center gap-3">
                    <div class="icon-wrapper text-success">📄</div>
                    <div>
                        <strong class="d-block text-dark" style="font-size: 14px;">Nouvelle demande</strong>
                        <span class="text-muted" style="font-size: 11px;">Enregistrer une demande de document</span>
                    </div>
                </div>
                <span class="text-muted small">➔</span>
            </div>

            <div class="action-card" onclick="location.href='#'">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-wrapper text-primary">📋</div>
                    <div>
                        <strong class="d-block text-dark" style="font-size: 14px;">Suivi des demandes</strong>
                        <span class="text-muted" style="font-size: 11px;">Consulter l'état des dossiers soumis</span>
                    </div>
                </div>
                <span class="text-muted small">➔</span>
            </div>

            <!-- Dernières Demandes SQL Extrayant de phpMyAdmin -->
            <span class="text-muted fw-bold d-block my-3" style="font-size: 11px; letter-spacing: 0.5px;">DERNIÈRES DEMANDES ENREGISTRÉES</span>

            @forelse($dernieres_demandes as $demande)
                <div class="demand-item">
                    <div class="d-flex align-items-center gap-3">
                        <div class="icon-wrapper">
                            @if($demande->type_acte === 'Naissance') 📄 @elseif($demande->type_acte === 'Mariage') 💍 @else 🪦 @endif
                        </div>
                        <div>
                            <strong class="d-block text-dark" style="font-size: 13px;">{{ $demande->prenom }} {{ $demande->nom }}</strong>
                            <span class="text-muted" style="font-size: 11px;">Acte de {{ $demande->type_acte }}</span>
                        </div>
                    </div>
                    
                    @if($demande->statut === 'Reçu')
                        <span class="badge-status badge-pending">🕒 Reçu</span>
                    @elseif($demande->statut === 'Signé & Archivé')
                        <span class="badge-status badge-approved">✓ Archivé</span>
                    @else
                        <span class="badge-status badge-exam">🔄 En cours</span>
                    @endif
                </div>
            @empty
                <div class="text-center p-4 bg-white rounded-3 border border-dashed text-secondary small">
                    Aucun dossier enregistré pour le moment dans la commune.
                </div>
            @endforelse
        </div>

        <!-- Navigation bar mobile basse -->
        <nav class="nav-bottom">
            <a href="#" class="nav-item active"><span class="d-block h5 mb-0">🏠</span>Accueil</a>
            <a href="{{ route('relais.create') }}" class="nav-item"><span class="d-block h5 mb-0">📄</span>Nouvelle</a>
            <a href="#" class="nav-item"><span class="d-block h5 mb-0">📋</span>Suivi</a>
            <a href="#" class="nav-item"><span class="d-block h5 mb-0">👤</span>Profil</a>
        </nav>
    </div>

</body>
</html>
