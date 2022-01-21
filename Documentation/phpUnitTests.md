# Projet 8 ToDoList
### Formation DA php / Symfony
## DOCUMENTATION TESTS UNITAIRES / FONCTIONNELS / COVERAGE

## Pré-requis 

## 1. Base de données
Comme vu dans le fichier [readme.md](https://github.com/Etienne21000/ToDoList/blob/master/readme.md), 
il faut : 

- créer la base de données de test  
- charger les fixtures dans celle-ci

## 2. Utilisation de la base de données
Une fois les fixtures chargées dans la base de données ToDoList_test vous pouvez lancer les tests.

Après avoir lancer les tests fonctionnels du CRUD il faudra modifier la base.

Il faudra supprimer les utilisateurs / tâches créés puis rétablir l'auto-incrémentation des ids à partir de la dernière entrée dans ces deux tables.

#### 2.1 Avec une interface PhpMyAdmin
Si vous utiliser une interface phpMyAdmin pour la gestion de vos bases de données vous pouvez directement supprimer les nouvelles entrées en rétablir l'auto-incrémention aux ids suivant.

#### 2.2 En ligne de commandes
Depuis un terminal : 
- se connecter à la base de donnée `mysql -h maBaseDeDonnée -u User -p` puis renseigner le mot de passe de la base
- se placer dans la table souhaitée `use ToDoList_test`

Pour modifier les entrées de la table :
- supprimer la dernière entrée `DELETE FROM maTable WHERE id=idTest`
- vous pouvez ensuite vérifier l'id le plus haut dans la table `SELECT MAX(id) FROM maTable`
- auto-incrémentation des ids `ALTER TABLE maTable AUTO_INCREMENT=tableLastId`

Ces requêtes SQL peuvent également être utiliser avec une interface phpMyAdmin

## 2. Lancer les tests 

A aprtir d'un terminal en ligne de commande : 
- se placer à la racine du projet `cd myProjectDir`

Pour lancer l'ensemble des tests avec phpUnit :
- lancer la commande `vendor/bin/phpunit`

#### 2.1 Filtrer les tests 
Pour ne lancer que certains tests (unitaires et fonctionnels) il est possible d'ajouter des filtres en ligne de commande afin de n'exécuter que certaines class / methods. 
- pour tester une class : `vendor/bin/phpunit --filter=classATester`
- pour tester une method de class : `vendor/bin/phpunit --filter=methodATester`

#### 2.2 Test coverage 
Pour la configuration de votre machine avant de lancer le test coverage via phpUnit :
- vérifier que xDebug est installé et configuré sur la machine (php.ini)
- vérifier la présence xDebug `php -v`

Lancer le test coverage : 
- lancer la commande `vendor/bin/phpunit --coverage-html ./tests/testCoverage`
- le rapport de test au format Html sera créé dans le fichier `test/testCoverage`
- accéder à se rapport via un navigateur 

