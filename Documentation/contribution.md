# Projet 8 ToDoList
### Formation DA php / Symfony
## DOCUMENTATION DEVELOPPEUR COLLABORATION

##1. Versionning du projet

####1.1 Git
L'application se trouve sur un repository GitHub. Afin de commencer à travailler sur le projet il faudra : 
- Installer Git à la racine du projet
- cloner le repository GitHub sur votre machine en local : `https://github.com/Etienne21000/ToDoList.git`
- Récupérer l'ensemble des branches présentes dans le repository (devBranch / LocalBranch / Master )

####1.2 Commit
Afin de respecter les standards mis en place dans le developpement de cette application, vous devrez :
- Créer une nouvelle branche pour tous vos ajouts (michel_local par exemple) à partir de LocalBranch
- Vous pouvez effectuer une pull Request de LocalBranch avant de créer votre branch afin d'être à jour sur le projet
- Commit puis pusher cette branche sur le repository GitHub
- Ne pas changer de branche lorsque vous developpez et faites des Commit / push sur Git et le repo GitLab
- Après chaque journée de travail sur l'application il faudra Commit puis pusher sur le Repository GitLab
- Attention : Veillez à bien pusher vos commits depuis votre branche vers son clone sur GitHub.
#####1.2.1 Naming des commits
Afin de respecter le versionning depuis votre branche lorsque vous créer un nouveau commit le naming doit se présenter commme suit :
- `[NomDuProjet-VotreNom] description des modifications que vous avez apportées`.
- N'hésitez pas à détailler cette description.
- Exemple : `[ToDoList-MichelSerre] ajout de la methode qui permet de compter le total des tâches / les tâches à faire / les tâches terminées dans le TaskController : countTask(param)`

##2. Verification des elements pushés
####2.1 Vérifications 
Après chaque Push sur GitHub le code sera recetté. 
- Si tout est ok pour le lead developpeur vous serez amené à merger vos modifications.

####2.2 Pull request
Une fois votre code validé il faudra créer une pull request et la merger vers la branche devBranch comme suit :
- Depuis votre branche sur GitHub créer une nouvelle Pull Request depuis l'onglet pull requests -> New pull request
- Base : votre branche 
- Compare : devBranche
- Créer la pull resquest
- Merger la pull request

Une fois merger effectuez la même opération depuis devBranch vers Master.
####2.3 Delete Branch
Après avoir créé et merger les pull requests jusqu'à la branch Master vous pourrez :
- Supprimer votre branche soit depuis GitHub soit depuis votre IDE
- Fetch les branches pour quelles se mettent à jour sur votre IDE
- Effectuer une pull request depuis la branche Master vers votre IDE (Branche Master Egalement) afin que le projet soit à jour sur votre environement local
- Créer une nouvelle branche à partir de Master et répéter les opération à partir de la section 1.2 de ce document



