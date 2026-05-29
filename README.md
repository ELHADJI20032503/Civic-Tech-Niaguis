

> **Projet de Fin de Cycle (PFC) — Licence 3 Informatique et Développement d'Applications (IDA)**  
> **Université Numérique Cheikh Hamidou KANE (UN-CHK) — ENO de Ziguinchor**

#  Civic-Tech Niaguis : Digitalisation du processus de pré-demande d'actes d'état civil en milieu rural

## I. Présentation  du projet

### A. Contexte national et territorial
Le Sénégal s’est résolument engagé dans une stratégie de modernisation de son administration publique à travers l'axe 3 du Plan Sénégal Émergent (PSE), matérialisé par les chantiers d'envergure du projet national *e-Sénégal*. Cette dynamique vise à dématérialiser les procédures pour rapprocher l'administration de l'administré. 

Cependant, la mise en œuvre de cette vision nationale se heurte à des réalités géographiques et infrastructurelles complexes dès qu'on s'éloigne des grands centres urbains. C'est précisément le cas de la **commune rurale de Niaguis**, située dans la région de Ziguinchor. S'étendant sur une vaste superficie parsemée de villages parfois enclavés, Niaguis fait face au défi de la continuité territoriale du service public. L’accès effectif, rapide et équitable aux services de base de l’état civil (déclarations et demandes d'extraits de naissance, de mariage ou de décès) y demeure un goulot d'étranglement majeur pour le développement local.

### B. Problématique et analyse des insuffisances du modèle actuel

#### 1. Le constat de terrain et la rupture géographique
L'accès physique à l'officier d'état civil à la mairie centrale de Niaguis est un parcours du combattant pour les populations des villages périphériques. Ce dysfonctionnement systémique repose sur trois facteurs critiques :
* **L'enclavement et la distance physique :** Les citoyens doivent parcourir de longues distances sur des pistes parfois impraticables, notamment pendant la saison des pluies (hivernage), pour effectuer une simple pré-demande d'acte.
* **Le coût d'opportunité financier :** Les déplacements répétés (un premier pour déposer la demande, d'autres pour vérifier si l'acte est signé) représentent une charge financière insupportable pour les ménages ruraux à faibles revenus.
* **L'asymétrie d'information :** Le citoyen n'a aucune visibilité sur l'état de traitement de son dossier. Le manque de canaux de communication le contraint à se déplacer "à l'aveugle", générant frustration et perte de confiance envers l'institution municipale.

#### 2. Les conséquences socio-éducatives
La conséquence la plus dramatique de cette barrière administrative est le non-enregistrement chronique des nouvelles naissances. Des centaines d'enfants grandissent dans la commune sans existence juridique légale. Au Sénégal, l'absence d'un extrait de naissance valide dès l'école primaire bloque l'inscription aux examens nationaux (notamment le CFEE). Cela engendre une déscolarisation précoce des jeunes filles et garçons en milieu rural, alimentant l'exode rural et compromettant leur avenir citoyen.

#### 3. Les limites des solutions centralisées (Le paradoxe de l'élitisme numérique)
Pourquoi les grandes plateformes nationales ne règlent-elles pas le problème à Niaguis ?
1. **La dépendance à la connectivité (Le Mur Réseau) :** Les solutions de l'ADIE/Sénégal Numérique SA reposent sur un accès Internet haut débit (4G ou fibre) permanent. À Niaguis, le réseau est sujet à de fréquentes coupures ou zones blanches. Un système 100 % Cloud paralyse le service municipal au moindre incident réseau.
2. **La fracture numérique (L'illettrisme technologique) :** Demander à un producteur rural de manipuler une plateforme web complexe via un smartphone personnel exclut de facto la majorité de la population cible.
3. **Le découplage avec l'infrastructure physique :** Les registres historiques de la mairie de Niaguis sont sous format papier, souvent dégradés par le temps. Les plateformes nationales ne proposent pas de passerelle d'archivage ou de numérisation locale pour ces documents de base.

La **Civic-Tech Niaguis** naît de ce besoin : créer une solution intermédiaire, résiliente et inclusive, adaptée aux contraintes d'infrastructure du monde rural africain.

### C. Objectifs du projet

#### 1. Objectif général
Concevoir, développer et déployer une plateforme logicielle intermédiaire légère (Civic-Tech Niaguis) basée sur une architecture robuste PHP/MySQL et optimisée pour un fonctionnement hybride (Intranet local à la mairie / Extranet pour les relais), afin de décentraliser et de digitaliser intégralement le processus de pré-demande d'actes d'état civil dans la commune de Niaguis.

#### 2. Objectifs spécifiques
* **Mettre en place un réseau de Relais Communautaires :** Développer un portail applicatif épuré permettant aux acteurs de confiance locaux (chefs de village, délégués de quartier, agents de santé communautaire) d'enregistrer numériquement les pré-demandes pour le compte des populations analphabètes ou non connectées.
* **Éliminer les déplacements inutiles (Suivi Asynchrone) :** Intégrer un module de suivi d'avancement des dossiers à trois états (*Reçu*, *En cours de traitement*, *Prêt à la signature / Signé*) consultable à distance par les relais pour informer instantanément le citoyen.
* **Sécuriser et pérenniser le patrimoine de la commune :** Modéliser une base de données relationnelle MySQL locale permettant de sauvegarder numériquement les informations essentielles des registres physiques afin de parer aux risques de perte, d'incendie ou de dégradation des cahiers d'état civil.
* **Garantir la Haute Disponibilité (Mécanisme Intranet local) :** Configurer l'application pour qu'elle s'exécute sur un serveur local au sein de la mairie. En cas de coupure totale d'Internet à Niaguis, les agents municipaux continuent de saisir et traiter les actes en réseau local, les données se synchronisant automatiquement dès le retour du réseau.
* **Respecter l'interopérabilité nationale :** Structurer le code PHP et le dictionnaire de données SQL selon les standards de l'État sénégalais pour permettre, à terme, une migration ou une interconnexion fluide avec le registre national unifié de l'état civil.


## II. Analyse Méthodologique et Cadrage du Projet

### A. Déploiement de la méthode QQOQCP
Pour cerner toutes les dimensions opérationnelles de la dématérialisation à Niaguis, nous appliquons la méthode QQOQCP (Qui, Quoi, Où, Quand, Comment, Pourquoi).

*   **QUI ? (Les acteurs du système)**
    *   Bénéficiaires finaux : Les citoyens et familles de la commune de Niaguis (particulièrement en zone rurale).
    *   Utilisateurs intermédiaires (Les Relais) : Les chefs de village, délégués de quartier et agents communautaires qui saisissent les pré-demandes.
    *   Opérateurs système : Les agents administratifs de l'état civil et l'officier de l'état civil (le Maire ou ses adjoints) pour la validation et la signature.
    *   Concepteur : Notre groupe.

*   **QUOI ? (La solution technologique)**
    *   Le développement d'une plateforme web (PHP/JS) connectée à une application desktop de gestion (Java) permettant d'effectuer des pré-demandes d'actes d'état civil, d'archiver numériquement les registres papier et de suivre l'avancement des dossiers à distance.

     

*   **OÙ ? (L'ancrage géographique et technique)**
    *   *Géographique :* La commune rurale de Niaguis (Région de Ziguinchor, Sénégal).
    *   *Technique :* Un serveur local installé au sein de la mairie de Niaguis pour un fonctionnement en Intranet, avec une passerelle Extranet synchronisée pour les relais communautaires distants.

*   **QUAND ? (La temporalité du projet)**
    *   *Phase actuelle :* Phase de cadrage, conception de la base de données (MCD/MLD) et présentation initiale .
    *   *Phase future :* Développement des modules (PHP, JS, Java) etc.

*   **COMMENT ? **
    *   *Back-end :* PHP 8 avec l'extension PDO pour des requêtes SQL préparées (sécurité anti-injection).
    *   *Front-end :* HTML5/CSS3 (Grid/Flexbox responsive) et JavaScript asynchrone (Fetch API) pour la soumission des formulaires sans rechargement de page.
    *   *Application Interne :* Java (Swing/JavaFX) pour le traitement lourd et la génération de rapports par les agents de la mairie.
## III. Justification des Choix Technologiques et Utilité des Langages

Pour répondre aux exigences  de notre projet de Licence 3, la plateforme n'est pas un simple site web isolé, mais un écosystème interconnecté exploitant la complémentarité de quatre technologies majeures.

### 1. PHP 
*   **Rôle :** Langage Back-end principal de la plateforme web.
*   **Utilité  :** PHP fait office de passerelle entre l'interface utilisateur et la base de données. C'est lui qui reçoit les formulaires de pré-demande envoyés par les relais, vérifie la validité des données saisies, et exécute les algorithmes de routage des dossiers vers les espaces d'administration. Il assure également la sécurité des sessions utilisateurs (Citoyens vs Agents de mairie).

### 2. SQL / MySQL (La Persistance et la Sécurité des Données)
*   **Rôle :** Système de Gestion de Base de Données Relationnelle (SGBDR).
*   **Utilité exacte :** Il gère le stockage structuré et immuable de l'état civil de Niaguis. À travers des tables optimisées (`utilisateurs`, `pre_demandes`, `registres_physiques`), il permet d'archiver numériquement les données des cahiers papier. L'utilisation de requêtes SQL préparées via PDO en PHP garantit une protection absolue contre les attaques par injection SQL.

### 3. JavaScript ES6+ (L'Asynchronisme et l'Expérience Utilisateur Mobile)
*   **Rôle :** Langage Front-end dynamique.
*   **Utilité exacte :** En milieu rural où la connexion Internet est instable, JavaScript est crucial. Grâce à l'utilisation de la `Fetch API` (AJAX), il va permettre aux relais communautaires de soumettre des pré-demandes et de consulter l'onglet "Suivi Dossier" en temps réel sans jamais recharger la page web. Cela réduit drastiquement la consommation de bande passante et évite les plantages en cas de micro-coupures réseau.

### 4. Java 
*   **Rôle :** Application Desktop (Bureau) autonome.
*   **Utilité exacte :** Déployé localement sur les ordinateurs de la mairie de Niaguis, ce logiciel Java (Swing/JavaFX) offre un environnement de travail performant et sécurisé pour les agents d'état civil. Connecté à la même base de données MySQL, il permet d'automatiser l'impression des actes officiels au format PDF, de générer des statistiques graphiques sur la natalité, et d'assurer la continuité du service en mode Intranet (réseau local) même lors d'une panne Internet totale dans la commune.

*   **POURQUOI ? **
    *   Pour éradiquer le non-enregistrement des naissances à Niaguis, réduire à zéro les déplacements inutiles et coûteux des populations rurales, et offrir une solution informatique résiliente qui ne plante pas lors des coupures d'Internet.



### B. Matrice Stratégique SWOT (Forces, Faiblesses, Opportunités, Menaces)

Cette matrice permet d'anticiper les risques du projet et de maximiser ses chances de réussite sur le terrain en Casamance.


 🚀 FORCES (Facteurs internes positifs) | 

 • **Architecture Hybride** (Intranet/Extranet) : L'application fonctionne même sans connexion Internet à la mairie.<br>
• **Interface Inclusive** : Pensée pour être manipulée par des relais communautaires pour le compte des populations analphabètes.<br>
• **Sécurisation locale** : Sauvegarde numérique des registres papier contre l'usure du temps et les sinistres. 

⚠️ FAIBLESSES (Facteurs internes négatifs) 

 • **Dépendance énergétique** : Sensibilité aux coupures d'électricité à la mairie (nécessite un onduleur ou panneau solaire).<br>
 • **Courbe d'apprentissage** : Temps d'adaptation nécessaire pour les agents municipaux habitués au 100% papier.<br>
 • **Maintenance technique** : Besoin d'un suivi informatique local pour gérer le serveur.

 **💡 OPPORTUNITÉS (Facteurs externes positifs)** 

• **Alignement National** : S'inscrit directement dans la Vision Sénégal 2050 et la modernisation de l'état civil de l'État.<br>
• **Appui institutionnel** : Possibilité de s'appuyer sur l'expertise technique et le réseau de l'ENO de Ziguinchor.<br>
• **Réplication territoriale** : Solution hautement duplicable dans les autres communes rurales de la Casamance. 

**🚨 MENACES (Facteurs externes négatifs)** 

• **Résistance au changement** : Réticence de certains usagers ou agents face à la digitalisation des procédures.<br>
• **Instabilité du réseau mobile** : Difficultés temporaires pour les relais distants d'envoyer les paquets de pré-demandes.<br>
• **Évolution réglementaire** : Risque de modifications des standards nationaux d'état civil en cours de développement. |
