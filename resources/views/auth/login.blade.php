<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification - Civic-Tech Niaguis</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f4f6f8; font-family: 'Segoe UI', sans-serif; height: 100vh; }
        .login-card { background: #ffffff; border: none; border-radius: 16px; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05); padding: 40px; max-width: 450px; width: 100%; }
        .icon-badge { background-color: #2e7d32; color: #ffffff; width: 56px; height: 56px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; font-size: 26px; }
        .tag-commune { background-color: #e8f5e9; color: #2e7d32; font-size: 11px; font-weight: 700; letter-spacing: 1px; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 15px; }
        .form-label { font-size: 14px; font-weight: 600; color: #333333; margin-bottom: 8px; }
        .form-control { background-color: #fafafa; border: 1px solid #e0e0e0; border-radius: 8px; padding: 12px 16px; font-size: 14px; color: #495057; }
        .btn-submit { background-color: #2e7d32; border: none; border-radius: 8px; padding: 12px; font-size: 15px; font-weight: 600; color: #ffffff; width: 100%; }
        .btn-submit:hover { background-color: #1b5e20; }
    </style>
</head>
<body class="d-flex align-items-center justify-content-center">
    <div class="login-card text-center">
        <div class="icon-badge">🔒</div>
        <span class="tag-commune">CIVIC-TECH NIAGUIS</span>
        <h2 class="h4 fw-bold mb-1 text-dark">Authentification</h2>
        <p class="text-muted small mb-4">Connectez-vous à votre espace de travail</p>

        <!-- Affichage dynamique des erreurs d'authentification ou de compte suspendu -->
        @if ($errors->any())
            <div class="alert alert-danger text-start p-2 mb-3 small" style="border-radius: 8px;">
                <ul class="mb-0 list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- CORRECTIF DE SÉCURITÉ : Forcer l'URL physique absolue pour écraser le bug de cache 404 -->
        <form action="/login-action" method="POST" class="text-start">
            @csrf
            <div class="mb-3">
                <label class="form-label">Identifiant / Login</label>
                <input type="text" class="form-control" name="login" value="{{ old('login') }}" placeholder="nom.prenom@niaguis.gouv" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <input type="password" class="form-control" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-submit">Se connecter</button>
        </form>
    </div>
</body>
</html>
