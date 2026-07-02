<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection du profil - Civic-Tech Niaguis</title>
    <!-- Chargement local de Bootstrap (Conformité Intranet NF-01) -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Segoe UI', system-ui, sans-serif; 
            min-height: 100vh; 
            margin: 0;
            padding-bottom: 60px; /* Évite la superposition avec la bannière jaune */
        }
        .navbar-custom { 
            background: #ffffff; 
            border-bottom: 1px solid #eef2f5; 
            padding: 12px 40px; 
        }
        .logo-box { 
            display: flex; 
            align-items: center; 
            gap: 12px; 
        }
        .logo-icon { 
            background: #0c4a26; 
            color: white; 
            padding: 8px 12px; 
            border-radius: 8px; 
            font-weight: bold; 
        }
        .main-wrapper {
            max-width: 1000px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        .profile-card { 
            background: #ffffff; 
            border: 2px solid transparent; 
            border-radius: 16px; 
            padding: 35px; 
            cursor: pointer; 
            transition: all 0.2s ease; 
            height: 100%; 
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.02); 
        }
        .profile-card:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.05); 
        }
        .profile-card.selected { 
            border-color: #2e7d32; 
            background-color: #fafffa; 
        }
        .profile-card.selected-officier { 
            border-color: #1565c0; 
            background-color: #fafcff; 
        }
        .icon-box { 
            width: 48px; 
            height: 48px; 
            border-radius: 12px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            font-size: 22px; 
            margin-bottom: 20px; 
        }
        .icon-relais { 
            background-color: #e8f5e9; 
            color: #2e7d32; 
        }
        .icon-officier { 
            background-color: #e3f2fd; 
            color: #1565c0; 
        }
        .badge-role { 
            font-size: 11px; 
            font-weight: 700; 
            padding: 4px 12px; 
            border-radius: 6px; 
            text-transform: uppercase; 
            display: inline-block; 
            margin-bottom: 20px; 
        }
        .badge-relais { 
            background-color: #e8f5e9; 
            color: #2e7d32; 
        }
        .badge-officier { 
            background-color: #e3f2fd; 
            color: #1565c0; 
        }
        .list-features { 
            list-style: none; 
            padding-left: 0; 
            margin-top: 25px; 
        }
        .list-features li { 
            font-size: 13.5px; 
            color: #4a5568; 
            margin-bottom: 12px; 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .action-link { 
            font-size: 14px; 
            font-weight: 600; 
            display: flex; 
            align-items: center; 
            justify-content: space-between; 
            margin-top: 30px; 
            padding-top: 15px; 
            border-top: 1px solid #f1f5f9; 
        }
        .btn-confirm { 
            background-color: #cbd5e1; 
            color: #ffffff; 
            border: none; 
            border-radius: 12px; 
            padding: 14px 30px; 
            font-size: 15px; 
            font-weight: 600; 
            transition: all 0.2s; 
            width: 100%; 
            max-width: 450px; /* Centre et ajuste la taille du bouton */
            margin-top: 20px;
        }
        .btn-confirm.active { 
            background-color: #2e7d32; 
            cursor: pointer; 
            box-shadow: 0 4px 12px rgba(46,125,50,0.2); 
        }
        .footer-banner { 
            background-color: #fff8e1; 
            border-top: 1px solid #ffe082; 
            color: #ff8f00; 
            font-size: 13px; 
            padding: 10px; 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            left: 0; 
            z-index: 1000;
        }
</style>

</head>
<body>

    <!-- Topbar Institutionnelle -->
    <nav class="navbar navbar-custom d-flex justify-content-between align-items-center">
        <div class="logo-box">
            <div class="logo-icon">🛡️</div>
            <div>
                <strong class="d-block text-dark" style="font-size: 15px; font-weight: 700;">Civic-Tech Niaguis</strong>
                <span class="text-muted" style="font-size: 11px;">Plateforme État-Civil</span>
            </div>
        </div>
        <div class="text-muted small">Pré-commande d'actes d'état civil &nbsp;›&nbsp; <strong class="text-dark">Sélection du profil</strong></div>
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-success p-2" style="font-size: 12px;">🟢 AU</span>
            <span class="small text-dark text-start d-inline-block"><strong>Aminata Sall</strong><br><span class="text-muted" style="font-size: 11px;">Connectée</span></span>
            <a href="#" class="btn btn-sm btn-outline-secondary ms-2" style="font-size: 12px;">➔ Se déconnecter</a>
        </div>
    </nav>

    <!-- Conteneur Principal -->
    <div class="main-wrapper">
    <div class="text-center mb-4 mt-2">
        <h1 class="h3 fw-bold text-dark mb-2">Sélectionnez votre profil utilisateur</h1>
        <p class="text-muted" style="font-size: 14.5px;">Choisissez le profil correspondant à vos responsabilités pour accéder à l'espace de travail approprié.</p>
    </div>


        <form action="{{ route('profil.select') }}" method="POST">
            @csrf
            <input type="hidden" name="chosen_role" id="chosen_role" value="">

            <div class="row g-4 mb-5">
                <!-- Profil Relais Communautaire -->
                <div class="col-md-6">
                    <div class="profile-card" id="card_relais" onclick="selectProfile('relais')">
                        <span class="badge-role badge-relais">Relais Communautaire</span>
                        <div class="icon-box icon-relais">👤</div>
                        <h3 class="h5 fw-bold text-dark mb-1">Relais Communautaire</h3>
                        <p class="text-muted small mb-3">Agent de proximité citoyenne</p>
                        <p class="text-secondary small">Accompagnez les citoyens dans le dépôt et le suivi de leurs demandes de documents d'état civil auprès de la mairie.</p>
                        <ul class="list-features">
                            <li>⚙️ Soumettre des demandes au nom d'un citoyen</li>
                            <li>⚙️ Suivre l'avancement des dossiers en temps réel</li>
                            <li>⚙️ Notifier les citoyens des mises à jour de statut</li>
                            <li>⚙️ Accéder à l'historique des demandes traitées</li>
                        </ul>
                        <div class="action-link text-success" id="link_relais">
                            <span>Accéder à l'espace Relais</span> <span>➔</span>
                        </div>
                    </div>
                </div>

                <!-- Profil Officier d'État Civil -->
                <div class="col-md-6">
                    <div class="profile-card" id="card_officier" onclick="selectProfile('agent')">
                        <span class="badge-role badge-officier">Officier d'État Civil</span>
                        <div class="icon-box icon-officier">🏢</div>
                        <h3 class="h5 fw-bold text-dark mb-1">Officier d'État Civil</h3>
                        <p class="text-muted small mb-3">Agent administratif municipal</p>
                        <p class="text-secondary small">Examinez, instruisez, validez et gérez les demandes de documents d'état civil soumises par les relais.</p>
                        <ul class="list-features">
                            <li>⚙️ Consulter et instruire les dossiers entrants</li>
                            <li>⚙️ Valider ou rejeter les demandes avec motif</li>
                            <li>⚙️ Générer et archiver les actes officiels</li>
                            <li>⚙️ Produire des rapports d'activité détaillés</li>
                        </ul>
                        <div class="action-link text-primary" id="link_officier">
                            <span>Accéder à l'espace Officier</span> <span>➔</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Validation unique -->
            <div class="text-center">
                <button type="submit" id="btn_submit" class="btn btn-confirm" disabled>Confirmer et accéder à mon espace ➔</button>
                <p class="text-muted small mt-2" id="hint_text">Veuillez sélectionner un profil pour continuer</p>
            </div>
        </form>
    </div>

    <!-- Bannière de Sécurité de Pied de Page -->
    <div class="footer-banner text-center">
        ⏳ Session active — votre profil peut être modifié à tout moment depuis le menu principal.
    </div>

    <!-- Script de sélection réactif local -->
        <!-- Script de sélection réactif local corrigé -->
    <script>
        function selectProfile(role) {
            // 1. Injecte la valeur dans le champ caché pour le contrôleur PHP
            document.getElementById('chosen_role').value = role;
            
            // 2. Réinitialise le style visuel des deux cartes
            document.getElementById('card_relais').classList.remove('selected');
            document.getElementById('card_officier').classList.remove('selected-officier');
            
            // 3. Active le bouton de soumission HTML
            const btnSubmit = document.getElementById('btn_submit');
            btnSubmit.removeAttribute('disabled');
            btnSubmit.classList.add('active');
            document.getElementById('hint_text').style.display = 'none';

            // 4. Applique le style de bordure verte ou bleue (classList.add obligatoire)
            if(role === 'relais') {
                document.getElementById('card_relais').classList.add('selected');
            } else {
                document.getElementById('card_officier').classList.add('selected-officier');
            }
        }
    </script>

