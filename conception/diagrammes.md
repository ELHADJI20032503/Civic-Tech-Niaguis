# 📊 Modélisation UML Officielle : Civic-Tech Niaguis

Ce document regroupe les diagrammes UML mis à jour pour le projet **Civic-Tech Niaguis**. L'architecture intègre la gestion du **multi-actes** (Naissances, Mariages, Décès), l'aiguillage automatique sécurisé des rôles et le module de **facturation physique au guichet** de la mairie (NF-01).

---

## 👥 1. Diagramme de Cas d'Utilisation (Use Case)
*Ce diagramme définit la frontière de l'application Intranet et le cloisonnement strict des privilèges entre les acteurs (F-01).*

```mermaid
graph TD
    subgraph Acteurs du Système
        R[👤 Intermédiaire / Relais]
        A[🏢 Agent d'État Civil]
        Admin[⚙️ Administrateur Système]
    end

    subgraph Application Civic-Tech Niaguis INTRANET LOCAL
        UC_Login(F-01: S'authentifier sur l'index)
        UC_Routage(F-01: Aiguillage automatique par rôle)
        
        subgraph Portail Relais Communautaire
            UC_Saisie(F-02: Saisir une pré-demande multi-actes)
            UC_Tarif(F-02: Calculer et afficher automatiquement le tarif)
            UC_Suivi_R(F-03: Suivre le tableau de bord des dossiers)
            UC_Alerte(F-04: Recevoir une alerte de dossier rejeté)
        end

        subgraph Portail Agent Communal
            UC_File(F-05: Consulter la file d'attente triée par village/acte)
            UC_Statut(F-06: Commuter le statut du dossier)
            UC_Rejet(F-07: Rejeter la demande avec motif obligatoire)
            UC_PDF(F-08: Générer l'aperçu PDF de contrôle)
            UC_Caisse(F-09: Encaisser la taxe au guichet de caisse)
            UC_Facture(F-09: Générer et imprimer le reçu/facture PDF)
            UC_Index(F-10: Clôturer par indexation au registre physique)
        end

        subgraph Portail Administrateur
            UC_Droits(F-11: Gérer les comptes et les droits d'accès)
            UC_ModifTarif(F-11: Configurer la grille tarifaire de la mairie)
            UC_Backup(F-12: Exporter une sauvegarde MySQL à chaud)
        end

        UC_Login -.-> |include| UC_Routage
        UC_Saisie -.-> |include| UC_Tarif
        UC_Statut -.-> |include| UC_PDF
        UC_Caisse -.-> |include| UC_Facture
        UC_Caisse -.-> |include| UC_Index
        UC_Statut -.-> |extend si dossier invalide| UC_Rejet
    end

    R --> UC_Login
    R --> UC_Saisie
    R --> UC_Suivi_R
    R --> UC_Alerte

    A --> UC_Login
    A --> UC_File
    A --> UC_Statut
    A --> UC_Caisse

    Admin --> UC_Login
    Admin --> UC_Droits
    Admin --> UC_ModifTarif
    Admin --> UC_Backup
```

---

## 🗂️ 2. Diagramme de Classes (Données Statiques)
*Ce diagramme modélise l'architecture des classes PHP et des tables MySQL en appliquant le pattern d'héritage/spécialisation pour éliminer les valeurs NULL.*

```mermaid
classDiagram
    direction TB
    class Utilisateur {
        +int id_user
        +string login
        +string password_hash
        +string nom
        +string prenom
        +string role
        +string statut_compte
        +verifierConnexion() bool
    }
    class Relais_Communautaire {
        +string village_affectation
        +soumettreDemande() void
    }
    class Agent_Communal {
        +string matricule_mairie
        +commuterStatut() void
        +enregistrerRejet() void
        +encaisserTaxe() void
    }
    class Administrateur {
        +gererDroits() void
        +mettreAJourTarifs() void
        +genererSauvegarde() void
    }
    class Tarif {
        +int id_tarif
        +string type_acte
        +int montant_fcfa
        +datetime date_vigueur
    }
    class Demande {
        +int id_demande
        +string numero_suivi
        +string type_acte
        +datetime date_creation
        +string statut
        +string motif_rejet
        +string mode_paiement
        +boolean est_paye
        +string num_registre_physique
        +calculerTaxe() int
        +modifierStatut() void
    }
    class Citoyen {
        +int id_citoyen
        +string nom
        +string prenom
        +date date_naissance
        +string lieu_naissance
        +string genre
    }
    class DetailsNaissance {
        +int id_naissance
        +string prenom_pere
        +string nom_pere
        +string prenom_mere
        +string nom_mere
        +string village_origine
    }
    class DetailsMariage {
        +int id_mariage
        +int id_conjoint_1
        +int id_conjoint_2
        +string coutume_mariage
        +string identite_temoins
    }
    class DetailsDeces {
        +int id_deces
        +date date_deces
        +string lieu_deces
        +string identite_declarant
    }
    class JournalActivite {
        +int id_log
        +datetime date_action
        +string action_faite
        +string ip_adresse
        +registrarLog() void
    }

    Utilisateur <|-- Relais_Communautaire
    Utilisateur <|-- Agent_Communal
    Utilisateur <|-- Administrateur
    Demande <|-- DetailsNaissance
    Demande <|-- DetailsMariage
    Demande <|-- DetailsDeces

    Utilisateur "1" --> "0..*" Demande : Gere
    Demande "1" --> "1" Citoyen : Concerne
    Demande "0..*" --> "1" Tarif : Suit
    Utilisateur "1" --> "0..*" JournalActivite : Declenche
    Demande "0..1" --> "0..*" JournalActivite : Est trace
```

---

## ⏱️ 3. Diagramme de Séquence (Flux Chronologique)
*Ce diagramme détaille les requêtes asynchrones AJAX locales pour les tarifs (Étapes 6 à 8) et la sécurisation indissociable du traitement de caisse à la mairie.*

```mermaid
sequenceDiagram
    autonumber
    actor R as 👤 Relais Communautaire
    actor A as 🏢 Agent d'État Civil
    with local_system as 💻 Système (PHP/JS)
    with database_mysql as 🗄️ Base de Données (MySQL)

    Note over R, database_mysql: PHASE 1 : AUTHENTIFICATION & ROUTAGE PAR RÔLE
    R->+local_system: Saisir login / password_hash (index.php)
    local_system->+database_mysql: SELECT role, statut FROM Utilisateur WHERE login = :login
    database_mysql-->>-local_system: Retourne (role: 'relais', statut: 'actif')
    local_system->local_system: Initialiser \$_SESSION['role'] = 'relais'
    local_system-->>-R: Redirection automatique (portail_relais.php)

    Note over R, database_mysql: PHASE 2 : SAISIE MULTI-ACTES & REÇU CITOYEN
    R->+local_system: Sélectionner type d'acte (Ex: 'Naissance')
    local_system->+database_mysql: SELECT montant_fcfa FROM Tarif WHERE type_acte = 'Naissance'
    database_mysql-->>-local_system: Retourne 1000 FCFA
    local_system-->>R: Affichage JavaScript dynamique du prix à l'écran (1000 FCFA)
    R->local_system: Renseigner les champs du formulaire et valider
    local_system->+database_mysql: INSERT INTO Demande + DetailsNaissance (statut='Reçu', est_paye=0)
    database_mysql-->>-local_system: Confirmation insertion SQL
    local_system-->>-R: Génération et impression du reçu de suivi physique
    Note over R: Le Relais remet le reçu au Citoyen.<br/>Le Citoyen sait qu'il doit préparer 1000 FCFA.

    Note over A, database_mysql: PHASE 3 : INSTRUCTION, CAISSE ET CLÔTURE À LA MAIRIE
    A->+local_system: S'authentifier (role: 'agent') -> Accès portail_mairie.php
    local_system->+database_mysql: SELECT * FROM Demande WHERE statut = 'Reçu' ORDER BY date_creation
    database_mysql-->>-local_system: Retourne la file d'attente triée par village
    A->local_system: Cliquer sur le dossier et vérifier les pièces physiques du citoyen
    
    alt Dossier conforme : Passage au guichet de caisse
        A->local_system: Cliquer sur "Encaisser la taxe municipale"
        local_system->+database_mysql: UPDATE Demande SET est_paye = 1 WHERE id_demande = :id
        database_mysql-->>-local_system: Confirmation SQL
        local_system->local_system: Déclencher bibliothèque locale (FPDF/DomPDF)
        local_system-->>A: Génération et impression immédiate du reçu/facture PDF de caisse
        A->local_system: Saisir le numéro de registre physique annuel (Indexation)
        local_system->+database_mysql: UPDATE Demande SET statut = 'Signé & Archivé', num_registre = :num
        database_mysql-->>-local_system: Confirmation SQL
        local_system->+database_mysql: INSERT INTO JournalActivite (action='Encaissement + Clôture', id_user, ip)
        database_mysql-->>-local_system: Log d'audit comptable sécurisé (NF-03)
        local_system-->>A: Affichage "Dossier clôturé avec succès"
    else Dossier non conforme / invalide
        A->local_system: Saisir textuellement la cause juridique du refus
        local_system->+database_mysql: UPDATE Demande SET statut = 'Rejeté', motif_rejet = :motif
        database_mysql-->>-local_system: Confirmation SQL
        local_system-->>A: Dossier renvoyé au relais terrain
    end
    -A
```
