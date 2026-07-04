<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File d'Attente Mairie - Civic-Tech Niaguis</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <style>
        body { background-color: #f3f4f6; font-family: 'Segoe UI', system-ui, sans-serif; min-height: 100vh; display: flex; margin: 0; }
        .sidebar { width: 260px; background-color: #1e293b; color: #94a3b8; padding: 24px; flex-shrink: 0; min-height: 100vh; display: flex; flex-direction: column; }
        .sidebar-brand { display: flex; align-items: center; gap: 12px; color: #ffffff; font-weight: 700; margin-bottom: 40px; }
        .sidebar-brand-icon { background-color: #059669; padding: 6px 10px; border-radius: 8px; font-size: 18px; }
        .nav-section-title { font-size: 11px; font-weight: 700; letter-spacing: 0.5px; color: #64748b; margin-bottom: 12px; text-transform: uppercase; }
        .sidebar-nav { list-style: none; padding-left: 0; margin-bottom: 30px; }
        .sidebar-nav-item { margin-bottom: 4px; }
        .sidebar-nav-link { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; color: #94a3b8; text-decoration: none; border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s; }
        .sidebar-nav-link:hover, .sidebar-nav-link.active { background-color: #334155; color: #ffffff; }
        .sidebar-footer { margin-top: auto; background-color: #0f172a; padding: 12px; border-radius: 12px; display: flex; align-items: center; gap: 12px; }
        .main-content { flex-grow: 1; padding: 30px 40px; }
        .topbar { background-color: #ffffff; border-radius: 16px; padding: 16px 30px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.01); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        .search-input-box { background-color: #f1f5f9; border: none; border-radius: 8px; padding: 8px 16px; font-size: 13.5px; width: 320px; }
        .kpi-card { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.01); height: 100%; }
        .kpi-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }
        .kpi-title { font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; }
        .kpi-icon { width: 36px; height: 36px; border-radius: 10px; background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; font-size: 16px; }
        .kpi-trend { font-size: 12px; font-weight: 500; color: #64748b; margin-top: 8px; display: flex; align-items: center; gap: 6px; }
        .data-card { background-color: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.02); }
        .filter-select { background-color: #ffffff; border: 1px solid #cbd5e1; border-radius: 8px; padding: 8px 16px; font-size: 13px; font-weight: 500; color: #334155; }
        .badge-maquette { font-size: 12px; font-weight: 600; padding: 4px 12px; border-radius: 20px; display: inline-block; }
        .status-attente { background-color: #fef3c7; color: #d97706; }
        .status-examen { background-color: #e0f2fe; color: #0284c7; }
        .status-approuve { background-color: #dcfce7; color: #16a34a; }
        .status-pret { background-color: #f3e8ff; color: #7c3aed; }
        .status-rejete { background-color: #fee2e2; color: #dc2626; }
    </style>
</head>
<body>

    <!-- BARRE LATÉRALE UNIQUE AVEC ACCÈS ROUTÉS -->
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">🛡️</div>
            <div>
                <span class="d-block" style="font-size: 14px; font-weight: 700;">Civic-Tech</span>
                <span class="d-block" style="font-size: 10px; opacity: 0.6;">Niaguis</span>
            </div>
        </div>

        <span class="nav-section-title">Navigation</span>
        <ul class="sidebar-nav">
            <li class="sidebar-nav-item"><a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link"><span>📊 Tableau de bord</span></a></li>
            <li class="sidebar-nav-item">
                <a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link active">
                    <span>📂 File d'attente</span>
                    <span class="badge bg-danger rounded-pill" style="font-size: 10px;">{{ $nb_en_attente }}</span>
                </a>
            </li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link"><span>📄 Documents civils</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link"><span>👥 Citoyens</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link"><span>📈 Rapports</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link"><span>📊 Statistiques</span></a></li>
            <li class="sidebar-nav-item"><a href="{{ route('mairie.dashboard') }}" class="sidebar-nav-link"><span>⚙️ Paramètres</span></a></li>
        </ul>

        <div class="sidebar-footer">
            <div style="font-size: 20px;">👤</div>
            <div>
                <strong class="d-block text-white" style="font-size: 12.5px;">Moussa Baldé</strong>
                <span style="font-size: 10.5px; opacity: 0.6;">Officier d'État Civil</span>
            </div>
        </div>
    </div>

    <!-- ZONE PRINCIPALE -->
    <div class="main-content">
        <div class="topbar">
            <input type="text" class="search-input-box" placeholder="🔍 Rechercher une demande...">
            <div class="d-flex align-items-center gap-3">
                <span style="font-size: 18px; cursor: pointer;">🔔</span>
                <div class="badge bg-dark p-2" style="font-size: 12px; border-radius: 8px;">MB &nbsp;▼</div>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold text-dark mb-1">File d'Attente — Mairie</h1>
                <p class="text-muted small mb-0">Gérez et traitez les demandes d'actes d'état civil soumises par les relais.</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-secondary btn-sm px-3 bg-white" style="border-radius: 8px;">📥 Exporter</button>
                <button class="btn btn-success btn-sm px-3" style="border-radius: 8px; background-color: #15803d; border: none;">＋ Nouvelle demande</button>
            </div>
        </div>

        <!-- COMPTEURS KPIS -->
        <div class="row g-3 mb-4">
            <div class="col">
                <div class="kpi-card">
                    <div class="kpi-header"><span class="kpi-title">TOTAL</span><div class="kpi-icon text-secondary">📄</div></div>
                    <h2 class="h2 fw-bold text-dark mb-0">{{ $total_dossiers }}</h2>
                    <div class="kpi-trend text-success">📈 +3 aujourd'hui</div>
                </div>
            </div>
            <div class="col">
                <div class="kpi-card">
                    <div class="kpi-header"><span class="kpi-title">EN ATTENTE</span><div class="kpi-icon text-warning">🕒</div></div>
                    <h2 class="h2 fw-bold text-dark mb-0">{{ $nb_en_attente }}</h2>
                    <div class="kpi-trend text-muted">➔ Stable</div>
                </div>
            </div>
            <div class="col">
                <div class="kpi-card">
                    <div class="kpi-header"><span class="kpi-title">APPROUVÉS</span><div class="kpi-icon text-success">✓</div></div>
                    <h2 class="h2 fw-bold text-dark mb-0">{{ $nb_approuves }}</h2>
                    <div class="kpi-trend text-success">📈 +3 aujourd'hui</div>
                </div>
            </div>
            <div class="col">
                <div class="kpi-card">
                    <div class="kpi-header"><span class="kpi-title">REJETÉS</span><div class="kpi-icon text-danger">✕</div></div>
                    <h2 class="h2 fw-bold text-dark mb-0">{{ $nb_rejetes }}</h2>
                    <div class="kpi-trend text-danger">📉 -1 hier</div>
                </div>
            </div>
            <div class="col">
                <div class="kpi-card">
                    <div class="kpi-header"><span class="kpi-title">PRÊTS</span><div class="kpi-icon text-purple">📦</div></div>
                    <h2 class="h2 fw-bold text-dark mb-0">{{ $nb_prets }}</h2>
                    <div class="kpi-trend text-muted">➔ Stable</div>
                </div>
            </div>
        </div>

        <!-- TABLEAU CENTRAL -->
        <div class="data-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <input type="text" class="form-control btn-sm bg-light" style="max-width: 240px; border-radius: 8px; font-size: 13px;" placeholder="🔍 Nom ou N° de dossier...">
                <div class="d-flex gap-2">
                    <select class="filter-select"><option>Tous les statuts</option></select>
                    <select class="filter-select"><option>Tous les documents</option></select>
                    <span class="text-muted align-self-center small fw-bold ms-2">{{ count($demandes) }} résultats</span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-light" style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px;">
                        <tr>
                            <th>N° Dossier</th>
                                                        <th>Citoyen</th>
                            <th>Soumis par</th>
                            <th>Type de Document</th>
                            <th>Date</th>
                            <th>Statut</th>
                            <th>Pièce Justificative</th>
                            <th class="text-end">Actions / Caisse</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 13.5px; color: #334155; font-weight: 500;">
                        @forelse($demandes as $demande)
                            <tr>
                                <!-- Numéro de dossier -->
                                <td class="fw-bold text-secondary" style="font-size: 12.5px;">{{ $demande->numero_suivi }}</td>
                                
                                <!-- Citoyen avec initiales en cercle noir -->
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="badge bg-dark rounded-circle p-2" style="font-size: 10px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center;">
                                            {{ strtoupper(substr($demande->prenom, 0, 1) . substr($demande->nom, 0, 1)) }}
                                        </div>
                                        <strong>{{ $demande->prenom }} {{ $demande->nom }}</strong>
                                    </div>
                                </td>
                                
                                <!-- Agent relais terrain -->
                                <td class="text-muted">{{ $demande->nom_relais }}</td>
                                
                                <!-- Type d'acte -->
                                <td>📄 Acte de {{ $demande->type_acte }}</td>
                                
                                <!-- Date de soumission -->
                                <td class="text-muted">{{ date('d/m/Y', strtotime($demande->date_creation)) }}</td>
                                
                                <!-- Couleur des badges selon le statut -->
                                <td>
                                    @if($demande->statut === 'Reçu')
                                        <span class="badge-maquette status-attente">En attente</span>
                                    @elseif($demande->statut === 'Prêt')
                                        <span class="badge-maquette status-pret">Prêt à collecter</span>
                                    @elseif($demande->statut === 'Signé & Archivé')
                                        <span class="badge-maquette status-approuve">Approuvé</span>
                                    @else
                                        <span class="badge-maquette status-rejete">Rejeté</span>
                                    @endif
                                </td>
                                
                                <!-- Consultation des certificats médicaux ou d'accouchement -->
                                <td>
                                    @if($demande->type_acte === 'Naissance' && !empty($demande->certificat_hopital_path))
                                        <a href="{{ asset('storage/' . $demande->certificat_hopital_path) }}" target="_blank" class="btn btn-sm btn-outline-dark" style="font-size: 12px; border-radius: 6px;">🔍 Consulter</a>
                                    @elseif($demande->type_acte === 'Décès' && !empty($demande->certificat_deces_path))
                                        <a href="{{ asset('storage/' . $demande->certificat_deces_path) }}" target="_blank" class="btn btn-sm btn-outline-dark" style="font-size: 12px; border-radius: 6px;">🔍 Consulter</a>
                                    @elseif($demande->type_acte === 'Mariage' && !empty($demande->certificat_mariage_path))
                                        <a href="{{ asset('storage/' . $demande->certificat_mariage_path) }}" target="_blank" class="btn btn-sm btn-outline-dark" style="font-size: 12px; border-radius: 6px;">🔍 Consulter</a>
                                    @else
                                        <span class="text-muted small">Aucun scan</span>
                                    @endif
                                </td>
                                
                                <!-- Formulaires d'actions et de caisse guichet -->
                                <td class="text-end">
                                    @if($demande->statut === 'Reçu')
                                        <form action="{{ route('mairie.traiter', $demande->id_demande) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="examiner">
                                            <button type="submit" class="btn btn-sm btn-primary py-1 px-2" style="font-size: 12px; border-radius: 6px;">Approuver l'acte</button>
                                        </form>
                                        <form action="{{ route('mairie.traiter', $demande->id_demande) }}" method="POST" class="d-inline ms-1">
                                            @csrf
                                            <input type="hidden" name="action" value="rejeter">
                                            <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" style="font-size: 12px; border-radius: 6px;">Rejeter</button>
                                        </form>
                                    @elseif($demande->statut === 'Prêt')
                                        <form action="{{ route('mairie.traiter', $demande->id_demande) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="action" value="encaisser">
                                            <button type="submit" class="btn btn-sm btn-success fw-bold py-1 px-2" style="font-size: 12px; border-radius: 6px; background-color: #16a34a; border: none;">💰 Encaisser 1000 F</button>
                                        </form>
                                    @elseif($demande->statut === 'Signé & Archivé')
                                        <span class="text-success small fw-bold">✓ Acte délivré & soldé</span>
                                    @else
                                        <span class="text-danger small">Rejeté</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="8" class="text-center p-5 text-muted small">Aucun dossier en attente d'instruction.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>

