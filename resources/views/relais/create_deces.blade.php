<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Déclaration de Décès - Civic-Tech Niaguis</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f8fafc; font-family: 'Segoe UI', sans-serif; min-height: 100vh; }
        .navbar-custom { background: #7f1d1d; color: white; padding: 15px 40px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .form-card { background: #ffffff; border: none; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.04); padding: 40px; margin-top: 30px; }
        .section-title { font-size: 13px; font-weight: 700; color: #b91c1c; letter-spacing: 0.5px; border-bottom: 2px solid #e2e8f0; padding-bottom: 6px; margin-top: 25px; margin-bottom: 20px; text-transform: uppercase; }
        .form-label { font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 6px; }
        .form-control { border-radius: 8px; padding: 12px; border: 1px solid #cbd5e1; font-size: 14px; background-color: #f8fafc; }
        .form-control:focus { background-color: #ffffff; border-color: #ef4444; box-shadow: 0 0 0 4px rgba(239,68,68,0.1); }
        .btn-submit { background-color: #b91c1c; border: none; color: white; padding: 14px; border-radius: 8px; font-size: 15px; font-weight: 600; transition: background 0.2s; }
        .btn-submit:hover { background-color: #991b1b; }
    </style>
</head>
<body>

    <!-- Topbar Institutionnelle -->
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('relais.choix_acte') }}" class="text-white text-decoration-none h4 mb-0">←</a>
            <div>
                <strong class="d-block" style="font-size: 16px;">Déclaration de Décès</strong>
                <span style="font-size: 11px; opacity: 0.8;">Mairie de Niaguis — Bureau des Constatations</span>
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

                    <form action="{{ route('relais.store_deces') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- SECTION DÉFUNT -->
                        <div class="section-title" style="margin-top: 0;">Le Défunt</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom du défunt</label>
                                <input type="text" class="form-control" name="prenom" required placeholder="Ex: Ibrahima">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom du défunt</label>
                                <input type="text" class="form-control" name="nom" required placeholder="Ex: Sané">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Profession du défunt</label>
                                <input type="text" class="form-control" name="profession_defunt" placeholder="Ex: Agriculteur, Commerçant">
                            </div>
                            
<div class="col-md-4">
    <label class="form-label">Date du décès</label>
    <input type="date" class="form-control" name="date_deces" required>
</div>
<div class="col-md-4">
    <label class="form-label">Heure du décès</label>
    <input type="time" class="form-control" name="heure_deces" required>
</div>

                            <div class="col-12">
                                <label class="form-label">Lieu du décès</label>
                                <input type="text" class="form-control" name="lieu_deces" required placeholder="Ex: Structure sanitaire ou Quartier de Niaguis">
                            </div>
                        </div>

                        <!-- SECTION DÉCLARANT -->
                        <div class="section-title">Le Déclarant (Témoin d'État Civil)</div>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Prénom du déclarant</label>
                                <input type="text" class="form-control" name="prenom_declarant" required placeholder="Ex: Souleymane">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nom du déclarant</label>
                                <input type="text" class="form-control" name="nom_declarant" required placeholder="Ex: Diatta">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Numéro de CNI du déclarant</label>
                                <input type="text" class="form-control" name="cni_declarant" required placeholder="Ex: 1 755 1992 00431">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Profession du déclarant</label>
                                <input type="text" class="form-control" name="profession_declarant" required placeholder="Ex: Enseignant">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Adresse / Domicile du déclarant</label>
                                <input type="text" class="form-control" name="adresse_declarant" required placeholder="Ex: Quartier Mairie, Niaguis">
                            </div>
                        </div>

                        <!-- SECTION PREUVE MÉDICALE -->
                        <div class="section-title">Preuve Matérielle</div>
                        <div class="mb-4">
                            <label class="form-label">Scan ou Photo du Certificat aux fins d'inhumation (Certificat de Décès Médical)</label>
                            <input type="file" class="form-control" name="certificat_deces" accept="image/*,.pdf" required>
                            <span class="text-muted d-block mt-1" style="font-size: 11px;">Formats valides : PDF, JPG, PNG. Maximum 5 Mo.</span>
                        </div>

                        <button type="submit" class="btn-submit w-100 mt-2">Enregistrer et transmettre le constat ➔</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>
</html>
