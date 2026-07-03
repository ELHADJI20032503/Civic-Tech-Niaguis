<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choisir l'acte - Civic-Tech</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #0f172a; font-family: 'Segoe UI', sans-serif; min-height: 100vh; display: flex; justify-content: center; align-items: center; }
        .phone-container { width: 390px; height: 844px; background-color: #f8fafc; border: 12px solid #1e293b; border-radius: 40px; box-shadow: 0 25px 50px -12 rgba(0,0,0,0.5); display: flex; flex-direction: column; }
        .header-app { background-color: #0c4a26; color: #ffffff; padding: 30px 20px 20px 20px; }
        .menu-card { background: white; border-radius: 16px; padding: 20px; margin-bottom: 15px; border: 1px solid #e2e8f0; cursor: pointer; transition: transform 0.2s; text-decoration: none; display: block; }
        .menu-card:hover { transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="phone-container">
        <div class="header-app d-flex align-items-center gap-3">
            <a href="{{ route('relais.dashboard') }}" style="color: white; text-decoration: none;">➔</a>
            <div><strong style="font-size: 14px;">Nouvelle Déclaration</strong><br><span style="font-size: 10px; opacity: 0.8;">Sélectionnez le type d'acte</span></div>
        </div>
        <div class="p-3">
            <a href="{{ route('relais.create') }}" class="menu-card">
                <h5 class="fw-bold text-success mb-1">📄 Acte de Naissance</h5>
                <p class="text-muted small mb-0">Déclarer un nouveau-né dans la commune.</p>
            </a>
            <a href="{{ route('relais.create_mariage') }}" class="menu-card">
                <h5 class="fw-bold text-primary mb-1">💍 Acte de Mariage</h5>
                <p class="text-muted small mb-0">Enregistrer une union civile municipale.</p>
            </a>
            <a href="{{ route('relais.create_deces') }}" class="menu-card">
                <h5 class="fw-bold text-danger mb-1">🪦 Acte de Décès</h5>
                <p class="text-muted small mb-0">Déclarer un décès survenu dans le quartier.</p>
            </a>
        </div>
    </div>
</body>
</html>

