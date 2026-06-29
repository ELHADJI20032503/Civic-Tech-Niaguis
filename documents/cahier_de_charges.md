# 📑 CAHIER DES CHARGES OFFICIEL : PROJET CIVIC-TECH NIAGUIS

## 1. Présentation Générale du Projet
*   **Nom du projet** : Civic-Tech Niaguis.
*   **Nature du projet** : Application Web Intranet de gestion, de centralisation et de suivi décentralisé des pré-demandes d’actes d’état civil (Naissances, Mariages, Décès).
*   **Bénéficiaire** : Commune de Niaguis (Département de Ziguinchor, Région de Ziguinchor, Sénégal).
*   **Maîtrise d’œuvre** : Équipe projet de Licence 3 en Informatique (5 membres).

---

## 2. Contextualisation et Problématique

### 2.1. Contexte du terrain et impact social
La commune rurale de Niaguis s'étend sur une vaste superficie où les villages sont fortement dispersés. L'éloignement géographique combiné au coût élevé des transports pénalise fortement l'enregistrement des faits d'état civil (naissances, mariages et décès) dans les délais légaux requis par l'État sénégalais. 

*   **Le drame de la déperdition scolaire** : Le constat sur le terrain est alarmant. L'absence d'extrait de naissance bloque administrativement l'inscription et la scolarisation des enfants, les empêchant surtout de se présenter aux examens officiels du système éducatif national (CFEE, BFEM).
*   **Conséquence directe** : Face à l'impossibilité de régulariser les dossiers à temps à cause de l'enclavement, de nombreux élèves se retrouvent exclus des salles de classe. Cela engendre un taux d'abandon scolaire précoce et de déperdition d'effectifs dramatique au sein de la commune, privant la jeunesse rurale de ses droits les plus fondamentaux à la citoyenneté et à l'éducation.

L'instabilité chronique du réseau Internet mondial (3G/4G/Filaire) dans cette zone rurale exclut d'office l'usage d'une solution Cloud classique pour les agents de terrain et les relais.

### 2.2. Objectifs Visés
*   **Lutte contre l'abandon scolaire et inclusion** : Assurer que chaque nouveau-né ou enfant de la commune puisse être répertorié rapidement et à proximité afin d'obtenir son extrait de naissance à temps pour sa scolarisation et ses examens.
*   **Réduction des délais et des coûts** : Éviter aux citoyens ruraux des déplacements longs, répétés et coûteux à la mairie si l'acte n'est pas encore examiné ou finalisé.
*   **Fiabilité et Archivage** : Créer une base de données locale sécurisée pour pallier la dégradation et la perte des registres physiques de la commune.
*   **Transparence Financière** : Centraliser, informer à l'avance et sécuriser l'encaissement des taxes municipales liées à la délivrance des actes officiels au guichet.

---

## 3. Section 1 : Les Acteurs du Système
Cette section certifie le périmètre d'interaction humain autour du logiciel, en parfait accord avec les directives de décentralisation de l'ANEC (Agence Nationale de l'État Civil du Sénégal).

### 3.1. Liste Officielle des Acteurs
*   **Intermédiaire (Relais Communautaire)** : Acteur de terrain (chef de village, délégué de quartier, badienou gokh) responsable de la collecte de proximité et de la saisie décentralisée des pré-demandes d'actes.
*   **Agent d'État Civil** : Personnel communal basé à la mairie centrale de Niaguis, chargé de l'instruction juridique, de la validation, de l'encaissement physique de la taxe et de l'impression finale.
*   **Administrateur Système** : Profil technique de l'équipe informatique, garant du bon fonctionnement du réseau local, de la sécurité, de la gestion stricte des privilèges d'accès et des sauvegardes MySQL à chaud.
*   **Citoyen (Physique)** : Exclu du système applicatif direct afin d'éviter le blocage lié à la fracture numérique. Le citoyen interagit physiquement avec le relais communautaire pour initier la demande, et se déplace une seule fois à la mairie pour le paiement et le retrait de son acte.

### 3.2. Matrice de Validation des Acteurs

| Acteur | Rôle Fonctionnel Principal | Justification Terrain & Légale | Statut |
| :--- | :--- | :--- | :--- |
| **Intermédiaire** | Saisir les données initiales de l'événement civil (Naissance, Mariage, Décès). | Compense l'enclavement des villages de Niaguis et la fracture numérique. | **Validé** |
| **Agent d'État Civil** | Vérifier, encaisser la taxe, valider et archiver les pré-demandes. | Seul habilité par la loi sénégalaise à inscrire un fait au registre d'état civil. | **Validé** |
| **Administrateur** | Gérer les comptes, les privilèges, tarifer les actes et sauvegarder la base MySQL. | Garantit l'étanchéité des accès et la protection des données (Conformité CDP). | **Validé** |
| **Citoyen** | Fournir les pièces justificatives physiques au relais local. | Ne se connecte pas à l'Intranet pour éliminer le problème d'analphabétisme numérique. | **Exclu** |

---

## 4. Section 2 : Spécifications et Fonctionnalités Applicatives

### 4.1. Module Authentification & Aiguillage par Rôle
*   **F-01 : Page de Connexion Unique & Redirection vers les Portails (Après Authentification)** : L'accès à l'application s'effectue via une page de connexion unique (`index.php`). L'utilisateur saisit son identifiant et son mot de passe. Après validation par la base de données, le système vérifie le rôle de l'utilisateur et l'oriente automatiquement vers son espace dédié :
    *   Si le rôle est "relais", l'utilisateur accède au **Portail Relais Communautaire**.
    *   Si le rôle est "agent", l'utilisateur accède au **Portail Agent Communal**.
    *   *Sécurité* : Les sessions PHP interdisent formellement à un relais d'accéder aux URL du portail de la mairie sous peine d'un blocage immédiat.

### 4.2. Module Portail Relais Communautaire (Acteur Terrain)
*   **F-02 : Formulaire Dynamique Multi-Actes & Affichage Automatique des Tarifs** : Écran unique intégrant un écouteur d'événement JavaScript. Selon le choix de l'acte par le relais, le formulaire affiche dynamiquement les champs indispensables :
    *   *Volet Naissance* : Nom, prénom, date/heure de naissance, lieu précis, identités complètes et distinctes du père et de la mère, village d'origine.
    *   *Volet Mariage* : Identités complètes, dates/lieux de naissance et professions des deux conjoints, identités complètes des témoins, régime matrimonial choisi.
    *   *Volet Décès* : Identité du défunt, date/heure/lieu du décès, cause (si requise), identité et lien de parenté du déclarant officiel.
    *   *Calculateur Automatique de Taxe* : Le formulaire est lié à la table locale des tarifs. Dès que l'acte est choisi, le système affiche instantanément à l'écran le montant officiel de la taxe à payer à la mairie (ex: 1 000 FCFA pour une naissance). Ce montant est imprimé automatiquement sur le reçu de pré-demande physique remis au citoyen pour éliminer toute incertitude avant son déplacement.
*   **F-03 : Tableau de Bord de Suivi Dynamique** : Visualisation graphique en temps réel de l'état d'avancement des dossiers soumis (Statuts : *Reçu, En cours d'examen, Prêt pour signature, Signé & Archivé, Rejeté*).
*   **F-04 : Alertes d'Interface Contextuelles** : Notifications visuelles immédiates et prioritaires en cas de changement de statut critique (notamment pour guider le relais sur les dossiers marqués "Rejeté").

### 4.3. Module Portail Agent Communal (Mairie de Niaguis)
*   **F-05 : File d'Attente Ordonnancée** : Centralisation chronologique des flux de données reçus, avec filtres multicritères avancés (par type d'acte : Naissance/Mariage/Décès, et par village d'origine).
*   **F-06 : Commutateur de Cycle de Vie (Statuts)** : Interface permettant de modifier l'état d'un dossier en un clic (Valider / Mettre en attente) après vérification humaine des pièces justificatives.
*   **F-07 : Module de Rejet avec Motif Explicite Obligatoire** : En cas de dossier incomplet ou invalide, obligation de saisir textuellement la cause juridique du rejet pour guider l'action de correction du relais sur le terrain.
*   **F-08 : Génération d'Aperçu PDF de Contrôle** : Production automatisée et 100% locale d'une fiche récapitulative normalisée pour relecture physique par l'Officier d'état civil avant l'impression officielle définitive.
*   **F-09 : Guichet de Caisse (Paiement Unique à la Mairie, Facturation & Historique)** : Lorsqu'un citoyen se présente physiquement à la mairie pour récupérer son document validé :
    1.  L'agent clique sur le bouton **"Encaisser la taxe municipale"**. Le système bascule instantanément l'état du paiement à "Payé" en base de données.
    2.  Le système génère automatiquement une **Facture/Reçu PDF nominatif de caisse** (via une bibliothèque locale comme FPDF, sans aucune connexion Internet) contenant le numéro de suivi, le montant exact de la taxe perçue, la mention *"PAYÉ EN ESPÈCES À LA MAIRIE"*, la date, l'heure et l'identifiant de l'agent encaisseur.
    3.  L'action est automatiquement historisée dans le journal de traçabilité comptable de l'application.
*   **F-10 : Clôture par Indexation Physique Légale** : Formulaire obligatoire permettant de lier de manière définitive la demande numérique payée au numéro de registre physique officiel et annuel archivé à la mairie.

### 4.4. Module Administrateur Système (Équipe Technique)
*   **F-11 : Gestion des Droits (Provisioning) & Paramétrage des Tarifs** : Interface de création, modification, suspension des comptes utilisateurs, et espace de mise à jour des coûts des taxes municipales pour l'affichage dynamique.
*   **F-12 : Sauvegarde Récurrente à Chaud (Backup MySQL)** : Script d'exportation locale complète de la structure et des données sur un support amovible physique externe sécurisé (Clé USB, Disque dur externe).

### 4.5. Matrice de Validation des Fonctionnalités

| Code | Intitulé Fonctionnel | Risque couvert si implémenté | Criticité | Statut |
| :--- | :--- | :--- | :--- | :--- |
| **F-02** | Formulaire Dynamique Multi-Actes | Dossiers invalides juridiquement selon le type de fait civil traité. | **Bloquante** | Validée |
| F-05 | File d'attente par type et par village | Perte de traçabilité et confusion entre les naissances, mariages et décès. | Majeure | Validée || F-07 | Motif de Rejet Obligatoire | Blocage de la communication et incapacité du relais à corriger le dossier. | Moyenne | Validée || F-08 | Génération de l'Aperçu PDF | Erreur de frappe imprimée de façon irréversible sur le registre papier officiel. | Bloquante | Validée || F-09 | Indexation au numéro de Registre | Rupture du lien légal obligatoire entre l'application et l'archive papier. | Bloquante | Validée |

### 5. Section 3 : Besoins Non Fonctionnels (Exigences de Qualité)5.1. NF-01 : 
Architecture Réseau (Contrainte d'Autonomie Intranet)Spécification : Fonctionnement impératif en mode 100% déconnecté de l'Internet mondial (0 octet de data externe consommé). L'application s'exécute localement via Apache/MySQL (XAMPP/WampServer ou Linux local). Aucune bibliothèque ne doit dépendre d'un CDN ou d'un lien externe (toutes les ressources CSS Bootstrap, JS, et polices de caractères sont téléchargées localement dans les répertoires du projet).

### 5.2. NF-02 : Sécurité et Intégrité Étanche (Architecture PHP/MySQL)Protection Cryptographique :
 Hachage irréversible des mots de passe utilisateurs à l'aide de l'algorithme robuste BCRYPT via la fonction native password_hash() de PHP avant insertion dans la base MySQL. Vérification stricte via password_verify().Imperméabilité aux Injections SQL : Utilisation stricte, obligatoire et systématique de l'interface PDO avec des requêtes préparées (prepare() et execute()) pour neutraliser toute tentative d'injection SQL sur l'ensemble des requêtes de l'application.Neutralisation des Failles XSS : Nettoyage systématique de toutes les chaînes de caractères et données textuelles saisies par le terrain avant leur rendu à l'écran, via l'utilisation stricte de la fonction htmlspecialchars().

### 5.3. NF-03 : Traçabilité et Auditabilité Comptable et MétierJournal des Logs Applicatifs : 
Implémentation en base de données d'une table d'audit immuable. Chaque transaction (changement d'état, encaissement de taxe au guichet, génération de facture) écrit automatiquement l'identifiant de l'agent responsable (id_user), la nature exacte de l'action, l'adresse IP locale (ip_adresse), et un horodatage précis (datetime).