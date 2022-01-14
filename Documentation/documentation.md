# Projet 8 ToDoList
### Formation DA php / Symfony
## DOCUMENTATION TECHNIQUE

##User Authentication

##1. Entity User

La classe User ``(src/Entity/User)`` représente les différents elements qui caractérisent un utilisateur.
Cette classe se trouve dans le NameSpace ``App\Entity\``. Elle implémente les classes Symfony ``UserInterface`` et `PasswordAuthenticatedUserInterface`.
La classe est composée de variable dont la proté est restrainte à la classe qui l'utilise (private) et
des getteurs et setteurs, qui permettent de récupérer et de poster des données.

####1.1 UserInterface
Cette classe Symfony permet d'instancier des methodes particulières telles que 
```php 
getSalt()
getRoles()
getUserIdentifier()
``` 
qui simplifient et securisent l'utilisation de l'entity User. 

####1.2 PasswordAuthenticatedUserInterface
Cette classe Symfony permet de décoder les mots de passe utilisateurs (encodé dans la class src/Controller/UserController).
L'encodage est effectué par hashage des mots de passe (définit dans le fichier `config/packages/security.yml` -> password_hashers ).

####1.3 Entity relations and constraints
dans la classe `App\Entity\User` on trouve des annotations php. Elles correspondent principalement à la configuration de l'ORM Doctrine et les constraints qui s'appliqueront à la class.
#####1.3.1 Class annotations
Les annotations au dessus de la déclaration de la class User `(@ORM)` permettent de définir la table / le type (entity) / et le repository lié.
L'annotation `( @UniqueEntity("email") )` permet de définir le champ d'identification unique pour chaque utilisateur, ici le champ email par convention.
#####1.3.2 Class variables annotations
Les annotations au dessus des variables de la class User (@ORM) fonctionnent de la même façon.
`(@ORM\Column)` permet de définir le typage de notre paramètre en base de données.
`(@Assert\)` permet d'ajouter une contrainte sur ce paramètre NotBlank par exemple.
`(@ORM\OneToMany / etc.)` permet de définir les relations entre les Enities qui seront ensuite migrés en base de données.
On trouve ici selon le type de relation une targetEntity et le mapping :
```php
/**
     * @ORM\OneToMany(targetEntity=Task::class, mappedBy="user")
*/
```

NB: Lorsqu'on modifie des annotations dans une Entity il ne faut pas oublié deffectuer une migration avec Doctrine afin de mettre à jour la base de données.

##2. Security.yml
Ce fichier de configuration du système de securité de Symfony permet de configurer le type d'encodage souhaité pour les mots de passe, Provider (identification unique pour les utilisateurs) et le Firewall.
####2.1 Password_hasher
Le password utilisateur utilise l'agorthme de hashage des mots de passe : 
```yaml
yamlsecurity:
    enable_authenticator_manager: true
    password_hashers:
        App\Entity\User:
            algorithm: 'auto'
```
####2.2 User provider
Le app_user_provider pointe vers l'entity User et se base sur la propriété email pour l'authentification :
```yaml
app_user_provider:
            entity:
                class: App\Entity\User
                property: email
```
####2.3 Firewalls
Le système de firewalls de Symfony permet de définir ici quelle class nous permet d'effectuer l'authentification.
```yaml
main:
     lazy: true
     provider: app_user_provider
     custom_authenticator: App\Security\AppLoginAuthenticator
```
            
On peut également y définir des routes qui seront accessible ou non si on a un utilisateur connecté. 

####2.4 access_control
L'access control permet quant à lui de définir des routes qui ne seront accessibles qu'à certain roles utilisateur.

         
##3. User Authentication
L'authentification des utilisateurs passe par la Classe App\Security\Authentication qui va faire appelle au login form.
Après le traitement de l'authentification par la class, l'utilisateur est redirigé vers la page demander.
Un système de Voters à été mis en place afin de mis dispatcher les utilisateur selon leur rôle.
- ROLE_ADMIN peut effectué toutes les actions sur l'application
- ROLE_USER n'aura pas accès au CRUD User et ne pourra avoir que des intéractions limitées sur Task : 
Il ne pourra modifier ou supprimer que des tâches qu'ils à lui même créé. ``
