# Projet 8 Améliorez une application existante de ToDo & Co

### Formation DA php / Symfony

## Description du projet 
Mettre à jour et ajouter des fonctionnalités au projet existant.

Migration du projet de la version de Symfony 3.1 à la version 5.3

Réaliser des tests : 
- Unitaires et fonctionnels
- Test coverage 
- Test de performance 
- Test de qualité de code

Le projet ToDoList a été réalisé avec :
- php 7.4
- Le framework Symfony (version 5.3)

## Pre-requis 
- php 7.3 ou suppérieur
- MySql 5.7 ou suppérieur
- php local web server avec MySql ou php local web server avec MAMP, XAMP etc.
- La configuration du projet se fait en lignes de commande depuis un terminal

## Documentation et maintenance

- [La documentation de l'authntification](https://github.com/Etienne21000/ToDoList/blob/master/Documentation/documentation.md) 
- [La documentation du processus de contribution](https://github.com/Etienne21000/ToDoList/blob/master/Documentation/contribution.md) 
- [La documentation des tests unitaires / fonctionnels et coverage](https://github.com/Etienne21000/ToDoList/blob/master/Documentation/phpUnitTests.md)

## Installation du projet

Il convient de se placer à la racine du projet avant de lancer l'ensemble des commandes d'initialisation :
`cd /usr/projectDir`

#### 1. Récupération du projet sur GitHub
- Créer un dossier pour le projet
- Initialiser Git à la racine du projet en executant la commande `git init` dans le terminal
- Cloner le repository et installer les dépendances du projet en éxecutant les commandes : 
>`git clone https://github.com/Etienne21000/ToDoList.git` <br>
>`composer install`

#### 2. Bases de données

##### a. Configuration des fichiers
- Editer le fichier doctrine.yml pour configurer la connexion à votre base de données
- Lancer votre server local avec la commande : `symfony serve`

##### b. Création de la base de données
- Executer les commandes :
>`symfony console doctrine:database:create` <br>
>`symfony console make:migration` <br>
>`symfony console doctrine:migrations:migrate` <br>

##### c. Création de la base de données de test
- Executer les commandes pour créer une base de données de test : 
>`symfony console --env=test doctrine:database:create`<br>
>`symfony console --env=test doctrine:schema:create`<br>

#### 3. Chargement des fixtures
- Executer la commande doctrine `symfony console doctrine:fixtures:load` 
- Pour la base de test : `symfony console doctrine:fixtures:load --env=test`

