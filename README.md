

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
