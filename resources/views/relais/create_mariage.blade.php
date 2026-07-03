<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouveau Mariage - Civic-Tech Niaguis</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', sans-serif; min-height: 100vh; }
        .navbar-custom { background: #1e3a8a; color: white; padding: 15px 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .form-card { background: #ffffff; border: none; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.04); padding: 40px; margin-top: 30px; }
        .section-title { font-size: 13px; font-weight: 700; color: #1e3a8a; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px; margin-top: 25px; margin-bottom: 20px; text-transform: uppercase; }
        .form-label { font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        .form-control, .form-select { border-radius: 8px; padding: 12px; border: 1px solid #cbd5e1; font-size: 14px; background-color: #f8fafc; }
        .form-control:focus, .form-select:focus { background-color: #ffffff; border-color: #3b82f6; box-shadow: 0 0 0 4px rgba(59,130,246,0.1); }
        .btn-submit { background-color: #1e3a8a; border: none; color: white; padding: 14px; border-radius: 8px; font-size: 15px; font-weight: 600; transition: background 0.2s; }
        .btn-submit:hover { background-color: #1d4ed8; }
    </style>
</head>
<body>

    <!-- Topbar Institutionnelle -->
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('relais.choix_acte') }}" class="text-white text-decoration-none h4 mb-0">←</a>
            <div>
                <strong class="d-block" style="font-size: 16px;">Enregistrement d'Union Civile</strong>
                <span style="font-size: 11px; opacity: 0.8;">Mairie de Niaguis — Bureau des Mariages</span>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    
                    @if ($errors->any())
                        <div class="alert alert-danger border-0 rounded-3 mb-4">
                            ⚠️ {{ $errors->first() }}
                        </div>
                    @endif

                    <form action="{{ route('relais.store_mariage') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- CONJOINT 1 (ÉPOUX) -->
                        <div class="section-title" style="margin-top: 0;">Le Conjoint (Époux)</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom de l'époux</label>
                                <input type="text" class="form-control" name="prenom_c1" required placeholder="Ex: Lamine">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom de l'époux</label>
                                <input type="text" class="form-control" name="nom_c1" required placeholder="Ex: Diatta">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Numéro de CNI de l'époux</label>
                                <input type="text" class="form-control" name="cni_conjoint_1" required placeholder="Ex: 1 755 1988 00542">
                            </div>
                        </div>

                        <!-- CONJOINT 2 (ÉPOUSE) -->
                        <div class="section-title">La Conjointe (Épouse)</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom de l'épouse</label>
                                <input type="text" class="form-control" name="prenom_c2" required placeholder="Ex: Fatoumata">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom de l'épouse</label>
                                <input type="text" class="form-control" name="nom_c2" required placeholder="Ex: Sonko">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Numéro de CNI de l'épouse</label>
                                <input type="text" class="form-control" name="cni_conjoint_2" required placeholder="Ex: 2 755 1993 00125">
                            </div>
                        </div>

                        <!-- DÉTAILS UNION -->
                        <div class="section-title">Détails de la Célébration</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Date du mariage</label>
                                <input type="date" class="form-control" name="date_mariage" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Heure de la célébration</label>
                                <input type="time" class="form-control" name="heure_celebration" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Option / Régime matrimonial (Coutume)</label>
                                <select class="form-select" name="coutume_mariage" required>
                                    <option value="Monogamie - Communauté de biens">Monogamie — Communauté de biens</option>
                                    <option value="Monogamie - Séparation de biens">Monogamie — Séparation de biens</option>
                                    <option value="Polygamie - Séparation de biens">Polygamie — Séparation de biens</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Identité complète des Témoins (Prénoms, Noms, CNI)</label>
                                <textarea class="form-control" name="identite_temoins" rows="3" required placeholder="Ex: Témoin Époux: Alassane Diop (CNI...). Témoin Épouse: Khady Sané (CNI...)"></textarea>
                            </div>
                        </div>

                        <!-- PREUVE MATÉRIELLE -->
                        <div class="section-title">Pièce Justificative (Sécurisation)</div>
                        <div class="mb-4">
                            <label class="form-label">Scan ou Photo du Certificat de mariage religieux/coutumier ou attestation des témoins</label>
                            <input type="file" class="form-control" name="certificat_mariage" accept="image/*,.pdf" required>
                            <span class="text-muted d-block mt-1" style="font-size: 11px;">Formats valides : PDF, JPG, PNG. Maximum 5 Mo.</span>
                        </div>

                        <button type="submit" class="btn-submit w-100 mt-2">Enregistrer et transmettre l'union ➔</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>
</html>
