# Projet 8 ToDoList
### Formation DA php / Symfony
## DOCUMENTATION DEVELOPPEUR COLLABORATION

## 1. ToDoList et bonnes pratiques
Afin que le projet ToDoList reste facilement maintenable et évolutif il vous sera demander d'y contribuer avec la méthodologie qui suit.
#### 1.1 Développer selon les standards 
Vous collaborez sur le projet ToDoList cela signifie que vous travaillez à plusieur sur celui-ci. Il convient donc de respecter le versionning du projet comme indiqué dans la partie 2 de ce document.

Il convient également de respecter certains standards de développement web liés à php et Symfony.

Lorsque vous développez une nouvelle fonctionnalité :
- ajouter la php doc correspondante, vous pouvez également y ajouter une courte description indiquant votre nom, la date de création et la fonctionnalité développée
- s'assurer que les variables et methodes sont bien typées
- s'assurer que la ou les méthodes créées ne sont pas trop complexes / longues vous pouvez scinder une fonctionnalité en plusieurs méthodes
- dans certains cas vous pourrez créer des services (methode(s) qui peuvent être utilisées dans plusieurs classes)
#### 1.2 Tester, tester, tester...
Un autre élément important pour le développement de ce projet, qu'il s'agisse d'ajouts ou de modifications est de tester ce que vous avez fait avant de faire un commit.
Le dossier de test se trouve à la racine du projet. 
il faudra alors se placer dans le fichier de test qui correspond à la class à laquelle vous avez ajouté / modifié une fonctionnalité / ou une entity et y écrire vos tests.

Pour chaque fonctionnalité créée vous développerez en parallèle des tests :
- tests Unitaires si besoin 
- tests fonctionnels
- test coverage avant de faire votre commit

#### 1.3 Corriger 
##### 1.3.1 Corriger les erreurs liées aux tests phpUnit
Si vous rencontrer des erreurs lors de vos tests unitaires / fonctionnels / coverage il faudra les corriger.

Pour le test coverage, le niveau de couverture doit toujours être au minimum de 70%.
##### 1.3.2 Corriger les problèmes de qualité de code
Une fois que vous aurez fait votre commit (à partir de votre branche éphémère) puis pushé ce commit sur GitHub, vous pourrez vérifier la qualité de votre code via l'outil CodeClimate mis en place pour le projet.

Si les éléments que vous avez développé n'atteignent pas au minimum la note de A sur CodeClimate, il faudra corriger votre travail puis le renvoyer sur GitHub.

## 2. Versionning du projet

#### 2.1 Git
L'application se trouve sur un repository GitHub. Afin de commencer à travailler sur le projet il faudra : 
- Installer Git à la racine du projet
- cloner le repository GitHub sur votre machine en local : `https://github.com/Etienne21000/ToDoList.git`
- Récupérer l'ensemble des branches présentes dans le repository (devBranch / LocalBranch / Master )
- Installer l'ensemble des dépendances du projet sur votre environement local via la commande `composer install`

#### 2.2 Commit
Afin de respecter les standards mis en place dans le developpement de cette application, vous devrez :
- Créer une nouvelle branche pour tous vos ajouts (michel_local par exemple) à partir de devBranch
- Vous pouvez effectuer une pull Request à partir de devBranch avant de créer votre branch éphémère afin d'être à jour sur le projet
- Commit puis pusher cette branche sur le repository GitHub
- Après chaque journée de travail sur l'application il faudra Commit puis pusher sur le Repository GitHub
- Attention : Veillez à bien pusher vos commits depuis votre branche vers son clone sur GitHub.
##### 2.2.1 Naming des commits
Afin de respecter le versionning depuis votre branche lorsque vous créer un nouveau commit le naming doit se présenter commme suit :
- `[NomDuProjet-VotreNom] description des modifications que vous avez apportées`.
- N'hésitez pas à détailler cette description.
- Exemple : `[ToDoList-MichelSerre] ajout de la methode qui permet de compter le total des tâches / les tâches à faire / les tâches terminées dans le TaskController : countTask(param)`

## 3. Verification des elements pushés
#### 3.1 Vérifications 
Après chaque Push sur GitHub le code sera recetté. 
- Si tout est ok pour le lead developpeur vous serez amené à merger vos modifications.

#### 3.2 Pull request
Une fois votre code validé il faudra créer une pull request et la merger vers la branche devBranch comme suit :
- Depuis votre branche sur GitHub créer une nouvelle Pull Request depuis l'onglet pull requests -> New pull request
- Base : votre branche 
- Compare : devBranche
- Créer la pull resquest
- Merger la pull request

Une fois merger effectuez la même opération depuis devBranch vers Master.
#### 3.3 Delete Branch
Après avoir créé et merger les pull requests jusqu'à la branch Master vous pourrez :
- Supprimer votre branche soit depuis GitHub soit depuis votre IDE
- Fetch les branches pour quelles se mettent à jour sur votre IDE
- Effectuer une pull request depuis devBranch vers votre IDE (devBranch Egalement) afin que le projet soit à jour sur votre environement local
- Créer une nouvelle branche à partir de devBranch et répéter les opération à partir de la section 2.2 de ce document



