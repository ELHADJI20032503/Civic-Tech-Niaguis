<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle Naissance - Civic-Tech Niaguis</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', sans-serif; min-height: 100vh; }
        .navbar-custom { background: #0c4a26; color: white; padding: 15px 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .form-card { background: #ffffff; border: none; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.04); padding: 40px; margin-top: 30px; }
        .section-title { font-size: 13px; font-weight: 700; color: #047857; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px; margin-top: 25px; margin-bottom: 20px; text-transform: uppercase; }
        .form-label { font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        .form-control, .form-select { border-radius: 8px; padding: 12px; border: 1px solid #cbd5e1; font-size: 14px; background-color: #f8fafc; }
        .form-control:focus, .form-select:focus { background-color: #ffffff; border-color: #10b981; box-shadow: 0 0 0 4px rgba(16,185,129,0.1); }
        .btn-submit { background-color: #10b981; border: none; color: white; padding: 14px; border-radius: 8px; font-size: 15px; font-weight: 600; transition: background 0.2s; }
        .btn-submit:hover { background-color: #059669; }
    </style>
</head>
<body>

    <!-- Barre de Navigation Institutionnelle -->
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('relais.choix_acte') }}" class="text-white text-decoration-none h4 mb-0">←</a>
            <div>
                <strong class="d-block" style="font-size: 16px;">Enregistrement de Naissance</strong>
                <span style="font-size: 11px; opacity: 0.8;">Mairie de Niaguis — Espace Saisie Terrain</span>
            </div>
        </div>
    </nav>

    <!-- Formulaire Responsive -->
    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-4">
                            ⚠️ {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('relais.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- SECTION ENFANT -->
                        <div class="section-title" style="margin-top: 0;">L'Enfant</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom de l'enfant</label>
                                <input type="text" class="form-control" name="prenom" required placeholder="Ex: Ousmane">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom de l'enfant</label>
                                <input type="text" class="form-control" name="nom" required placeholder="Ex: Diatta">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Date de naissance</label>
                                <input type="date" class="form-control" name="date_naissance" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Heure de naissance</label>
                                <input type="time" class="form-control" name="heure_naissance" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Genre</label>
                                <select class="form-select" name="genre" required>
                                    <option value="M">Masculin</option>
                                    <option value="F">Féminin</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Structure Médicale ou Village de naissance</label>
                                <input type="text" class="form-control" name="lieu_naissance" required placeholder="Ex: Maternité du Poste de Santé de Niaguis">
                            </div>
                        </div>

                        <!-- SECTION FILIATION -->
                        <div class="section-title">Filiation (Parents)</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom du Père</label>
                                <input type="text" class="form-control" name="prenom_pere" placeholder="Nom de famille hérité automatiquement">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Prénom de la Mère</label>
                                <input type="text" class="form-control" name="prenom_mere" required placeholder="Ex: Aminata">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom de la Mère</label>
                                <input type="text" class="form-control" name="nom_mere" required placeholder="Ex: Sané">
                            </div>
                        </div>

                        <!-- SECTION PREUVE NUMÉRIQUE -->
                        <div class="section-title">Pièce Justificative (Sécurisation)</div>
                        <div class="mb-4">
                            <label class="form-label">Scan ou Photo du Certificat d'Accouchement (Hôpital/Poste de Santé)</label>
                            <input type="file" class="form-control" name="certificat_hopital" accept="image/*,.pdf" required>
                            <span class="text-muted d-block mt-1" style="font-size: 11px;">Formats acceptés : PDF, JPG, PNG. Maximum 5 Mo.</span>
                        </div>

                        <button type="submit" class="btn-submit w-100 mt-2">Enregistrer et transmettre le dossier ➔</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>
</html>
