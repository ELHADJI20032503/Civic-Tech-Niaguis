. 
# 📊 Modélisation UML Officielle : Civic-Tech Niaguis

Ce document regroupe les diagrammes UML mis à jour pour le projet **Civic-Tech Niaguis**.

---

## 👥 1. Diagramme de Cas d'Utilisation (Use Case)

```mermaid
graph TD
    R[Relais Communautaire]
    A[Agent Etat Civil]
    Admin[Administrateur Systeme]

    subgraph Intranet Civic-Tech Niaguis
        F01[F-01: Authentification et Aiguillage]
        F02[F-02: Formulaire Dynamique Multi-Actes]
        F03[F-03: Tableau de Bord Suivi]
        F05[F-05: File d Attente Ordonnancee]
        F07[F-07: Motif de Rejet Obligatoire]
        F09[F-09: Guichet de Caisse et Facture PDF]
        F10[F-10: Cloture par Indexation Physique]
        F12[F-12: Sauvegarde MySQL a Chaud]
    end

    R --> F01
    R --> F02
    R --> F03

    A --> F01
    A --> F05
    A --> F07
    A --> F09
    A --> F10

    Admin --> F01
    Admin --> F12
```

---

## 🗂️ 2. Diagramme de Classes (Données Statiques)

```mermaid
classDiagram
    direction TB
    class Utilisateur {
        +int idUser
        +string login
        +string passwordHash
        +string role
    }
    class Demande {
        +int idDemande
        +string numeroSuivi
        +string typeActe
        +string statut
        +boolean estPaye
    }
    class Citoyen {
        +int idCitoyen
        +string nom
        +string prenom
    }

    Utilisateur --> Demande : Gere
    Demande --> Citoyen : Concerne
```

---

## ⏱️ 3. Diagramme de Séquence (Flux Chronologique)

```mermaid
sequenceDiagram
    autonumber
    actor R as Relais Communautaire
    actor A as Agent Etat Civil
    participant Sys as Systeme PHP et JS
    participant BDD as Base de Donnees MySQL

    Note over R, BDD: PHASE 1 : AUTHENTIFICATION ET ROUTAGE
    R->+Sys: Saisir login et password
    Sys->+BDD: SELECT role FROM Utilisateur
    BDD-->>-Sys: Retourne le role
    Sys->Sys: Initialiser session
    Sys-->>-R: Redirection portail

    Note over R, BDD: PHASE 2 : SAISIE MULTI-ACTES
    R->+Sys: Selectionner type acte
    Sys->+BDD: SELECT montant FROM Tarif
    BDD-->>-Sys: Retourne le prix
    Sys-->>R: Affichage du tarif dynamique
    R->Sys: Soumettre le formulaire
    Sys->+BDD: INSERT INTO Demande
    BDD-->>-Sys: Confirmation SQL
    Sys-->>-R: Impression du recu

    Note over A, BDD: PHASE 3 : GUICHET DE CAISSE ET CLOTURE
    A->+Sys: Encaisser la taxe municipale
    Sys->+BDD: UPDATE Demande SET est_paye = 1
    BDD-->>-Sys: Confirmation SQL
    Sys->Sys: Generer le recu PDF local
    A->Sys: Saisir numero de registre physique
    Sys->+BDD: UPDATE Demande SET statut = Archive
    BDD-->>-Sys: Confirmation SQL
    Sys->+BDD: INSERT INTO JournalActivite
    BDD-->>-Sys: Log d audit enregistre
    Sys-->>-A: Dossier cloture avec succes
```
