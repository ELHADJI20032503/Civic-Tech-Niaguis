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
        +int id_user
        +string login
        +string password_hash
        +string role
    }
    class Demande {
        +int id_demande
        +string numero_suivi
        +string type_acte
        +string statut
        +boolean est_paye
    }
    class Citoyen {
        +int id_citoyen
        +string nom
        +string prenom
    }
    class DetailsNaissance {
        +id_demande
        +string prenom_pere
        +string prenom_mere
    }

    Demande <|-- DetailsNaissance
    Utilisateur "1" --> "0..*" Demande : Gere
    Demande "1" --> "1" Citoyen : Concerne
```
