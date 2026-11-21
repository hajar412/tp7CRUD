# TP 7 : Conception et CRUD multi-entités

Application web de gestion d'un **centre de formation**, réalisée en PHP, PDO et MySQL dans le cadre de la Licence Développement Web Full Stack et DevOps (Faculté des Sciences et Techniques de Marrakech, 2026/2027).

L'application permet de gérer trois entités liées entre elles : les **formations**, les **modules** et les **étudiants**.

## Règles métier

- Le centre propose plusieurs formations.
- Chaque étudiant est rattaché à une seule formation, et une formation peut accueillir plusieurs étudiants.
- Chaque formation contient plusieurs modules, et chaque module appartient à une seule formation.

## Technologies

- PHP (procédural) avec PDO
- MySQL (moteur InnoDB)
- HTML et CSS
- XAMPP (Apache + MySQL) et phpMyAdmin

## Structure du projet

```
tp7CRUD/
├── index.php                 Page d'accueil (accès aux trois espaces)
├── database/
│   ├── connexion.php         Connexion PDO centralisée
│   └── database.sql          Création de la base, des tables et des données de test
├── Formation/
│   ├── index.php             Liste
│   ├── create.php            Ajout
│   ├── edit.php              Modification
│   └── delete.php            Suppression
├── Module/
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   └── delete.php
├── Etudiant/
│   ├── index.php
│   ├── create.php
│   ├── edit.php
│   └── delete.php
└── style/
    └── style.css             Feuille de style commune
```

## Modèle de données

Base de données : `tp7CRUD`

| Table | Colonnes | Clé primaire | Clé étrangère |
|---|---|---|---|
| `formations` | `codeFormation`, `nomFormation`, `description`, `duration` | `codeFormation` | aucune |
| `modules` | `codeModule`, `nomModule`, `description`, `codeFormation` | `codeModule` | `codeFormation` vers `formations` |
| `etudiants` | `id`, `nom`, `prenom`, `email`, `codeFormation` | `id` (auto-incrémenté) | `codeFormation` vers `formations` |

Relations :

- `formations` 1 — N `modules`
- `formations` 1 — N `etudiants`

![Diagramme de classes de la base tp7CRUD](captures/00_diagramme_classes.png)
*Diagramme de classes de la base tp7CRUD : une formation (1) accueille plusieurs étudiants (N) et contient plusieurs modules (N).*

Contraintes importantes :

- L'e-mail d'un étudiant est **unique** (`UNIQUE`).
- Les clés étrangères utilisent le comportement par défaut `ON DELETE RESTRICT` : une formation ne peut pas être supprimée tant que des étudiants ou des modules y sont rattachés.

## Installation

1. Installer et lancer **XAMPP**, puis démarrer **Apache** et **MySQL**.
2. Copier le dossier du projet dans `C:\xampp\htdocs\` pour obtenir `C:\xampp\htdocs\tp7CRUD`.
3. Ouvrir **phpMyAdmin** (`http://localhost/phpmyadmin`), onglet **Importer**, puis choisir le fichier `database/database.sql`. Cela crée la base `tp7CRUD`, les trois tables et les données de départ.
4. Vérifier les paramètres de `database/connexion.php` (par défaut : hôte `localhost`, utilisateur `root`, sans mot de passe).
5. Ouvrir l'application : `http://localhost/tp7CRUD/`

### Données de départ

- 3 formations : INFO (Informatique), MATH (Mathématiques), PHYS (Physique)
- 2 étudiants : Sara Alaoui et Youssef Benani, rattachés à INFO
- 2 modules : M101 (Programmation C) et M102 (Bases de données), rattachés à INFO

## Fonctionnalités

- **Page d'accueil** avec un lien vers chacun des trois espaces de gestion.
- **CRUD complet** pour les formations, les modules et les étudiants : liste, ajout, modification, suppression.
- **Liste déroulante alimentée par MySQL** dans les formulaires des modules et des étudiants pour choisir la formation.
- **Affichage lisible des relations** : les listes montrent le nom de la formation et non son code, grâce à une jointure SQL.
- **Formulaires de modification préremplis** avec les valeurs existantes.
- **Codes générés automatiquement** pour les formations (quatre lettres) et les modules.
- **Gestion des erreurs** :
  - e-mail déjà utilisé : message « Cet e-mail existe déjà. » avec conservation des saisies ;
  - suppression d'une formation utilisée : message « Impossible de supprimer cette formation : elle est utilisée par des étudiants ou des modules. »
- **Confirmation** JavaScript avant chaque suppression.

## Sécurité

- Requêtes **préparées** avec paramètres nommés (`prepare()` / `execute()`) pour limiter les risques d'injection SQL.
- Affichage des données avec `htmlspecialchars()` pour empêcher l'injection de HTML ou de JavaScript.
- Suppressions et modifications toujours ciblées par une clause `WHERE` sur l'identifiant.

## Tests réalisés

Chaque test a été vérifié à trois niveaux : l'interface, le tableau de l'application, puis phpMyAdmin pour confirmer l'enregistrement dans la base. Les captures sont dans le dossier [`captures/`](captures/).

### État de départ

![Base tp7crud dans phpMyAdmin : tables etudiants, formations et modules](captures/00a_base_tables.png)
*Base tp7crud dans phpMyAdmin : tables etudiants, formations et modules*

![Structure de la table etudiants (clé primaire auto-incrémentée, e-mail unique)](captures/00b_structure_etudiants.png)
*Structure de la table etudiants (clé primaire auto-incrémentée, e-mail unique)*

### 1. Étudiants

#### Ajout

![Formulaire d'ajout rempli (Elidrissi Amine, Informatique)](captures/01_etudiant_ajout_formulaire.png)
*Formulaire d'ajout rempli (Elidrissi Amine, Informatique)*

![Le nouvel étudiant (id 9) apparaît dans la liste avec le nom de sa formation](captures/02_etudiant_ajout_liste.png)
*Le nouvel étudiant (id 9) apparaît dans la liste avec le nom de sa formation*

![Vérification dans phpMyAdmin : la ligne est enregistrée avec codeFormation = INFO](captures/03_etudiant_ajout_phpmyadmin.png)
*Vérification dans phpMyAdmin : la ligne est enregistrée avec codeFormation = INFO*

#### Modification

![Formulaire de modification : la liste des formations vient de la base](captures/04_etudiant_modification_formulaire.png)
*Formulaire de modification : la liste des formations vient de la base*

![La formation de l'étudiant est maintenant Physique](captures/05_etudiant_modification_liste.png)
*La formation de l'étudiant est maintenant Physique*

![Vérification dans phpMyAdmin : codeFormation = PHYS](captures/06_etudiant_modification_phpmyadmin.png)
*Vérification dans phpMyAdmin : codeFormation = PHYS*

#### Suppression

![Confirmation JavaScript avant la suppression](captures/07_etudiant_suppression_confirmation.png)
*Confirmation JavaScript avant la suppression*

![L'étudiant n'apparaît plus dans la liste, les autres sont intacts](captures/08_etudiant_suppression_liste.png)
*L'étudiant n'apparaît plus dans la liste, les autres sont intacts*

![Vérification dans phpMyAdmin : la ligne a disparu de la table](captures/09_etudiant_suppression_phpmyadmin.png)
*Vérification dans phpMyAdmin : la ligne a disparu de la table*

#### E-mail déjà utilisé (contrainte UNIQUE)

![Ajout avec sara.alaoui@example.com : message d'erreur, saisies conservées](captures/10_etudiant_email_double_message.png)
*Ajout avec sara.alaoui@example.com : message d'erreur, saisies conservées*

![Vérification dans phpMyAdmin : aucune ligne en double n'a été créée](captures/11_etudiant_email_double_phpmyadmin.png)
*Vérification dans phpMyAdmin : aucune ligne en double n'a été créée*

### 2. Formations

#### Ajout

![Formulaire d'ajout (BIOLOGIE, 36 heures)](captures/12_formation_ajout_formulaire.png)
*Formulaire d'ajout (BIOLOGIE, 36 heures)*

![La formation apparaît dans la liste avec le code BIOL généré automatiquement](captures/13_formation_ajout_liste.png)
*La formation apparaît dans la liste avec le code BIOL généré automatiquement*

![Vérification dans phpMyAdmin : la ligne BIOL est enregistrée](captures/14_formation_ajout_phpmyadmin.png)
*Vérification dans phpMyAdmin : la ligne BIOL est enregistrée*

#### Modification

![Formulaire de modification préremplie avec les valeurs existantes](captures/15_formation_modification_prerempli.png)
*Formulaire de modification préremplie avec les valeurs existantes*

![La durée de BIOL est passée de 36 à 40 heures](captures/16_formation_modification_liste.png)
*La durée de BIOL est passée de 36 à 40 heures*

![Vérification dans phpMyAdmin : duration = 40](captures/17_formation_modification_phpmyadmin.png)
*Vérification dans phpMyAdmin : duration = 40*

#### Suppression

![Confirmation avant la suppression de BIOL](captures/18_formation_suppression_confirmation.png)
*Confirmation avant la suppression de BIOL*

![BIOL n'apparaît plus, INFO, MATH et PHYS sont intactes](captures/19_formation_suppression_liste.png)
*BIOL n'apparaît plus, INFO, MATH et PHYS sont intactes*

![Vérification dans phpMyAdmin : la ligne a disparu](captures/20_formation_suppression_phpmyadmin.png)
*Vérification dans phpMyAdmin : la ligne a disparu*

### 3. Modules

#### Ajout

![Le module M103 (ALGORITHMIQUE) apparaît avec le nom de sa formation, Informatique](captures/24_module_ajout_liste.png)
*Le module M103 (ALGORITHMIQUE) apparaît avec le nom de sa formation, Informatique*

![Vérification dans phpMyAdmin : M103 est rattaché à INFO](captures/25_module_ajout_phpmyadmin.png)
*Vérification dans phpMyAdmin : M103 est rattaché à INFO*

#### Modification

![Formulaire de modification préremplie (module M102, formation Informatique)](captures/26_module_modification_prerempli.png)
*Formulaire de modification préremplie (module M102, formation Informatique)*

![Changement de la formation de M103 vers Mathématiques](captures/27_module_modification_formulaire.png)
*Changement de la formation de M103 vers Mathématiques*

![La liste affiche Mathématiques pour M103](captures/28_module_modification_liste.png)
*La liste affiche Mathématiques pour M103*

![Vérification dans phpMyAdmin : codeFormation = MATH](captures/29_module_modification_phpmyadmin.png)
*Vérification dans phpMyAdmin : codeFormation = MATH*

#### Suppression

![Confirmation avant la suppression de M103](captures/30_module_suppression_confirmation.png)
*Confirmation avant la suppression de M103*

![M103 a disparu, M101 et M102 sont intacts](captures/31_module_suppression_liste.png)
*M103 a disparu, M101 et M102 sont intacts*

![Vérification dans phpMyAdmin : la ligne a disparu](captures/32_module_suppression_phpmyadmin.png)
*Vérification dans phpMyAdmin : la ligne a disparu*

### 4. Relations entre les entités

#### Clé étrangère et protection des données

![Contrainte etudiants_ibfk_1 vers formations, avec ON DELETE RESTRICT](captures/21_relation_vue_relationnelle.png)
*Contrainte etudiants_ibfk_1 vers formations, avec ON DELETE RESTRICT*

![Suppression de INFO refusée : la formation est utilisée par des étudiants ou des modules](captures/22_relation_suppression_refusee.png)
*Suppression de INFO refusée : la formation est utilisée par des étudiants ou des modules*

![Après le refus, les étudiants sont toujours rattachés à INFO](captures/23_relation_etudiants_intacts.png)
*Après le refus, les étudiants sont toujours rattachés à INFO*

Les listes déroulantes des formulaires sont alimentées par la table `formations`, et les listes affichent le nom de la formation grâce à une jointure SQL (voir les captures ci-dessus).

### 5. Fichier SQL de départ

![Données de test du fichier database/database.sql](captures/33_database_sql.png)
*Données de test du fichier database/database.sql*

## Auteure

Hajar, Licence Développement Web Full Stack et DevOps, FST Marrakech.
Enseignant : Nefdaoui Aymane.
