# Projet 8 ToDoList
### Formation DA php / Symfony
## DOCUMENTATION TECHNIQUE

## User Authentication

## 1. L'authentification des utilisateurs

L'authentification des utilisateurs avec Symfony s'effectue à travers différents fichiers et classes : 
- loginForm.html.twig
- SecurityController.php
- AppLoginAuthenticator.php
- User.php
- security.yml
- Voters

#### 1.1 Où trouver ces fichiers

Voici l'arborescence des fichiers d'authentification qui vous permettra de les retrouver facilement :
```
|--config
    |--packages
        |--security.yml
|--src
    |--Controller
        |--SecurityController.php
    |--Entity
        |--User.php
    |--Security
        |--AppLoginAuthenticator.php
        |--Voter
            |--TaskVoter.php
            |--UserVoter.php
|--templates
    |--security
        |--login.html.twig
```

Pour authentifier un utilisateur il est redirigé vers le formulaire de connexion `login.html.twig` via le `SecurityController`, il renseigne ses identifiants de connexion
(mail et password). La classe `AppLoginAuthenticator` prend le relais et va de-hacher le mot de passe, chercher l'utilisateur en base de donnée via son email, vérifie son rôle et renvoie une réponse.

Les rôles enregistrés pour les users vont permettre ensuite d'accorder l'accès ou non à certaines fonctionnalités et routes de l'application.

On a définit ces accès dans le firewall du fichier `security.yml`, qui redirige ensuite vers les Voters qui vont permettre d'accorder ou non l'accès sous certaines condition.

Par exemple : 

Les `ROLE_USER` ne peuvent pas supprimer de taches qu'ils n'ont pas créés, c'est le TaskVoter qui va définir si l'utilisateur lié à la tâche est le même que l'utilisateur connecté, il pourra effectuer cette action.

## 1. Entity User

La classe User ``(src/Entity/User)`` représente les différents elements qui caractérisent un utilisateur.
Cette classe se trouve dans le NameSpace ``App\Entity\``. Elle implémente les classes Symfony ``UserInterface`` et `PasswordAuthenticatedUserInterface`.
La classe est composée de variable dont la porté est restreinte à la classe qui l'utilise (private) et
des getteurs et setteurs, qui permettent de récupérer et de poster des données.

#### 1.1 UserInterface
Cette classe Symfony permet d'instancier des methodes particulières telles que 
```php 
getRoles()
getUserIdentifier()
``` 
qui simplifient et sécurisent l'utilisation de l'entity User. 

#### 1.2 PasswordAuthenticatedUserInterface
Cette classe Symfony permet de décoder les mots de passe utilisateurs (encodé dans la class src/Controller/UserController).
L'encodage est effectué par hashage des mots de passe (définit dans le fichier `config/packages/security.yml` -> password_hashers ).

#### 1.3 Entity relations and constraints
dans la classe `App\Entity\User` on trouve des annotations php. Elles correspondent principalement à la configuration de l'ORM Doctrine et les constraints qui s'appliqueront à la class.
##### 1.3.1 Class annotations
Les annotations au dessus de la déclaration de la class User `(@ORM)` permettent de définir la table / le type (entity) / et le repository lié.
L'annotation `( @UniqueEntity("email") )` permet de définir le champ d'identification unique pour chaque utilisateur, ici le champ email par convention.
##### 1.3.2 Class variables annotations
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

##### 1.3.3 Authentification et User Entity
L'annotation `UniqueEntity` est donc le provider de connexion fournit par l'Entity au fichier `security.yml`. 

Le paramètre `$roles` qui renvoie un tableau permet de définir le ou les rôles attribués à un User.

Le paramètre `$password` permet de définir le mot de passe de l'utilisateur qui sera ensuite hashé et qui est définit dans le fichier `security.yml`

NB: Lorsqu'on modifie des annotations dans une Entity il ne faut pas oublier d’effectuer une migration avec Doctrine afin de mettre à jour la base de données.

## 2. Security.yml
Ce fichier de configuration du système de securité de Symfony permet de configurer le type d'encodage souhaité pour les mots de passe, Provider (identification unique pour les utilisateurs) et le Firewall.
#### 2.1 Password_hasher
Le password utilisateur utilise l'agoryithme de hashage des mots de passe : 
```yaml
yamlsecurity:
    enable_authenticator_manager: true
    password_hashers:
        App\Entity\User:
            algorithm: 'auto'
```
#### 2.2 User provider
Le app_user_provider pointe vers l'entity User et se base sur la propriété email pour l'authentification :
```yaml
app_user_provider:
            entity:
                class: App\Entity\User
                property: email
```
#### 2.3 Firewalls
Le système de firewalls de Symfony permet de définir ici quelle class nous permet d'effectuer l'authentification mais également quelles routes sont protéger par l'authentification, la déconnexion etc..
```yaml
main:
    pattern: ^/
    lazy: true
    provider: app_user_provider
    custom_authenticator: App\Security\AppLoginAuthenticator
    logout:
          path: /logout
```
            
Ici l'ensemble des routes de l'application sont protégées.  

#### 2.4 access_control
L'access control permet quant à lui de définir des routes qui ne seront accessibles qu'à certain roles utilisateur.

```yaml
access_control:
         - { path: '^/login$', roles: IS_AUTHENTICATED_ANONYMOUSLY }
         - { path: '^/', roles: [IS_AUTHENTICATED_FULLY, ROLE_USER] }
         - { path: '^/tasks/', roles: [IS_AUTHENTICATED_FULLY, ROLE_USER] }
         - { path: '^/users', roles: [IS_AUTHENTICATED_FULLY, ROLE_ADMIN] }
```
   
Dans ce cas de figure, seule la route de login est accessible par des utilisateurs non identifiés. Les autres routes necessitent d'être soit administrateur soit d'être authentifié comme user.

## 3. User Authentication et Voters
Comme expliqué précédemment, après le traitement de l'authentification, l'utilisateur est redirigé vers la page demander.
Un système de Voters à été mis en place afin de dispatcher les utilisateur selon leur rôle.
- ROLE_ADMIN peut effectué toutes les actions sur l'application
- ROLE_USER n'aura pas accès au CRUD User et ne pourra avoir que des interactions limitées sur Task :
Il ne pourra modifier ou supprimer que des tâches qu'ils à lui même créé.

Le rôle du TaskVoter va être de venir vérifier si le user_id attaché à la tâche que l'on veut modifier / supprimer est bien celui de l'utilisateur connecté :
```php
switch ($attribute) {
            case self::VIEW:
            case self::EDIT:
            case self::DELETE:
                return $task->getUser()->getId() === $user->getId();
                break;
        }
```

Si la condition est remplie pour les actions de type EDIT ou DELETE l'utilisateur est granted.

C'est également le voter qui va gérer si l'utilisateur peut modifier ou non la tâche d'un user anonyme :
```php
if(this->security->isGranted('ROLE_USER') && $task->getUser() === NULL)
{
            return false;
}
```

Enfin, on appelle dans les méthodes des controller les voter afin qu'ils puissent définir si l'action est possible ou non :
```php
$this->isGranted(TaskVoter::EDIT, $task);
```