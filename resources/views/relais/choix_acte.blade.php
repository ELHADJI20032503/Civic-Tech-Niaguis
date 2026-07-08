<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir le type d'acte - Civic-Tech Niaguis</title>
    <!-- Chargement local de Bootstrap (Conformité NF-01) -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', system-ui, sans-serif; min-height: 100vh; }
        .navbar-custom { background: #0c4a26; color: white; padding: 15px 30px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .menu-card { background: white; border-radius: 16px; padding: 30px; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.25s; text-decoration: none; display: flex; flex-direction: column; height: 100%; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01); }
        .menu-card:hover { transform: translateY(-4px); box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05); text-decoration: none; }
        .card-naissance:hover { border-color: #10b981; }
        .card-mariage:hover { border-color: #3b82f6; }
        .card-deces:hover { border-color: #ef4444; }
        .icon-circle { width: 56px; height: 56px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 20px; }
        .bg-naissance { background-color: #dcfce7; color: #10b981; }
        .bg-mariage { background-color: #dbeafe; color: #3b82f6; }
        .bg-deces { background-color: #fee2e2; color: #ef4444; }
    </style>
</head>
<body>

    <!-- Barre de Navigation Institutionnelle Responsive -->
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('relais.dashboard') }}" class="text-white text-decoration-none h4 mb-0">←</a>
            <div>
                <strong class="d-block" style="font-size: 16px;">Nouvelle Déclaration d'État Civil</strong>
                <span style="font-size: 11px; opacity: 0.8;">Mairie de Niaguis — Sélection du Formulaire Officiel</span>
            </div>
        </div>
        <span class="badge bg-white text-success px-3 py-2 fw-bold">Espace Saisie</span>
    </nav>

    <!-- Grille de Sélection Responsive en 3 Colonnes Équilibrées -->
    <div class="container my-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-dark h4 mb-2">Quel type d'acte souhaitez-vous enregistrer ?</h2>
            <p class="text-muted small">Sélectionnez le registre approprié pour ouvrir le formulaire d'audit correspondant.</p>
        </div>

        <div class="row g-4 justify-content-center">
            
            <!-- COLONNE 1 : NAISSANCE -->
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('relais.create') }}" class="menu-card card-naissance">
                    <div class="icon-circle bg-naissance">📄</div>
                    <h3 class="h5 fw-bold text-dark mb-2">Acte de Naissance</h3>
                    <p class="text-muted small mb-0 flex-grow-1">Enregistrer un nouveau-né dans la commune. Requiert l'heure de naissance et le certificat médical d'accouchement de l'hôpital.</p>
                </a>
            </div>

            <!-- COLONNE 2 : MARIAGE -->
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('relais.create_mariage') }}" class="menu-card card-mariage">
                    <div class="icon-circle bg-mariage">💍</div>
                    <h3 class="h5 fw-bold text-dark mb-2">Acte de Mariage</h3>
                    <p class="text-muted small mb-0 flex-grow-1">Enregistrer une union civile municipale. Requiert les CNI des époux, l'identité complète des témoins et le certificat coutumier.</p>
                </a>
            </div>

            <!-- COLONNE 3 : DÉCÈS -->
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('relais.create_deces') }}" class="menu-card card-deces">
                    <div class="icon-circle bg-deces">🪦</div>
                    <h3 class="h5 fw-bold text-dark mb-2">Acte de Décès</h3>
                    <p class="text-muted small mb-0 flex-grow-1">Enregistrer un constat de décès survenu dans le quartier. Requiert l'identité complète du déclarant et le certificat aux fins d'inhumation.</p>
                </a>
            </div>

        </div>
    </div>

</body>
</html>
