# Projet 8 ToDoList
### Formation DA php / Symfony
## PROPOSITIONS D'AMELIORATIONS DE L'APPLICATION ToDoList

## 1. Performances de l'applciation
Pour améliorer les performances de l'application :
- Optimiser le système de cache sur le server de production
- Optimiser l'Autoloader de Composer sur le server de production 

les résultats dévraient être meilleurs que ceux des tests réalisés en environement local

## 2. Tests et intégration continue
#### 2.1 Intégration continue
Comme vu dans la documentation sur la contribution au projet, les commits pushés sur GitHub sont mergés jusqu'à la branche Master.

Il pourrait être interressant d'avoir un serveur de développement (autre que local)

Ces éléments permettraient de mettre en place une intégration continue du projet avec des tests automatisés qui se lanceraient avant de merger vers la branch de dev.

Pour l'intégration continue, il faudra mettre en place un script de déploiement notamment pour les commandes Symfony/Doctrine
#### 2.2 Intégration continue et tests automatisés
Si les tests sont réussi, la merge request est faite et le projet est mis à jour sur le serveur de dev.

De la même façon on pourrait intégrer des tests de performance au moment de merger vers la branche master avant que le projet soit déployé sur le server de produciton.
## 3. Fonctionnalités 
Afin d'améliorer les performances et la qualité de l'application ToDoList plusieurs fonctionnalités peuvent être envisagées : 
- Créer des class EventListener / EventSubscriber afin d'écouter les réponses et exceptions du composant Kernel afin de rediriger / renvoyer le bon message à l'utilisateur.
#### 3.1 Fonctionnalités users
- Créer une fonctionnalité de suppression des utilisateurs (admin uniquement / User si il s'agit de son propre compte)
- Améliorer le UserVoter pour qu'un utilisateur avec le ROLE_USER puisse éditer / supprimer son compte
- Créer une fonctionnalité permettant de vérifier la compléxité du mot de passe suivant une regex (sécurité)

#### 3.2 Fonctionnalités tasks
- Créer une fonctionnalité afin d'aficher une liste de tâches à faire ou terminée
- Créer une fonctionnalité permettant de compter le nombre total de tâches, les tâches à faire et les tâches terminées
- Créer une fonctionnalité permettant d'ajouter une deadline à une tâche (les administrateurs pourront modifier cette deadline)
- Créer une fonctionnalité permettant d'assigner une tâche à un utilisateur 
- Créer une fonctionnalité d'alerte indiquant que la deadline arrive bientôt à échéance : 
    
    popup dans l'application listant les tâches bientôt à échéance (si l'utilisateur est connecté)
    
    envoi d'un mail de rappel des tâches arrivant à échéance