# Projet PHP-CV

## Description
Ce projet est une application web pour créer et gérer des CV en utilisant PHP. Il permet aux utilisateurs de s'inscrire, de créer des CV, de les visualiser, de les modifier et de les supprimer. Les administrateurs peuvent gérer les utilisateurs et leurs projets.

## Fonctionnalités principales
- **Inscription et connexion des utilisateurs** : Les utilisateurs peuvent s'inscrire et se connecter pour accéder à leurs profils.
- **Création de CV** : Les utilisateurs peuvent créer des CV en ajoutant des informations personnelles, des expériences professionnelles, des compétences, etc.
- **Gestion des CV** : Les utilisateurs peuvent visualiser, modifier et supprimer leurs CV.
- **Téléchargement de CV en PDF** : Les utilisateurs peuvent télécharger leurs CV au format PDF.
- **Gestion des projets** : Les utilisateurs peuvent ajouter, visualiser et supprimer leurs projets.
- **Interface administrateur** : Les administrateurs peuvent gérer les utilisateurs et leurs projets, ainsi que visualiser les CV des utilisateurs.

## Fonctionnalités non implémentées
- CSS basique 


## Prérequis
- Docker
- Docker Compose

## Installation
1. **Cloner le dépôt :**
    ```bash
    git clone https://github.com/SaikoHUB/Php-CV.git
    ```

2. **Déplacez-vous dans le répertoire du projet :**
    ```bash
    cd Php-CV
    ```

3. **Configurer les variables d'environnement :**
    - Créez un fichier `.env` à la racine du projet en vous basant sur le fichier `.env.example`.
    - Modifiez les paramètres de connexion à la base de données si nécessaire (hôte, nom de la base de données, utilisateur, mot de passe).

4. **Lancer les conteneurs Docker :**
    ```bash
    docker-compose up -d
    ```

5. **Importer la base de données :**
    - Ouvrez votre navigateur et accédez à `http://localhost:8081` pour accéder à phpMyAdmin.

    - Connectez-vous avec les identifiants suivants : 
        - Utilisateur : `root`
        - Mot de passe : `root`
    - Créez une nouvelle base de données nommée `portfolio`.
    - Importez le fichier `portfolio.sql` situé dans le répertoire du projet.

## Utilisation
1. **Accéder à l'application :**
    - Ouvrez votre navigateur et accédez à `http://localhost/public/index.php`.

2. **Créer un compte utilisateur :**
    - Cliquez sur "S'inscrire" et remplissez le formulaire d'inscription.
    - Connectez-vous avec vos identifiants.

3. **Créer et gérer vos CV :**
    - Une fois connecté, vous pouvez créer un nouveau CV en remplissant le formulaire de création.
    - Vous pouvez visualiser, modifier et supprimer vos CV depuis votre tableau de bord.

4. **Télécharger votre CV en PDF :**
    - Accédez à la page de visualisation de votre CV et cliquez sur le bouton "Télécharger en PDF".

5. **Gérer vos projets :**
    - Ajoutez, visualisez et supprimez vos projets depuis la section "Mes projets".

6. **Interface administrateur :**
    - Si vous êtes administrateur, vous pouvez accéder au tableau de bord administrateur pour gérer les utilisateurs et leurs projets via le mot de passe : `admin123`

## Licence


## Auteurs
- [Delbeau Jean-Baptiste](https://github.com/SaikoHUB)