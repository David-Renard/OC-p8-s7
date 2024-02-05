# OC - p8

## Openclassrooms projet 8 (parcours : Développeur d'application - PHP/Symfony)

### Améliorez une application existante de ToDo & Co

## Codacy
### Here is the review of code by Codacy (on branch dev) :
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/41db61edaf69413b9efc644e1c5c265c)](https://app.codacy.com/gh/David-Renard/OC-p8-s7/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

### Contexte 

Je viens d'intégrer une startup dont le cœur de métier est une application permettant de gérer ses tâches quotidiennes.
L'entreprise vient tout juste d'être montée, et l'application a dû être développée à toute vitesse pour permettre de 
montrer à de potentiels investisseurs que le concept est viable.
Le choix du développeur précédent a été d'utiliser le framework PHP Symfony.

Mon rôle est d'améliorer la qualité de l'application (de code, perçue par l'utilisateur, perçue par les collaborateurs, 
perçue par moi-même).
Je suis ainsi chargé de :
* l'implémentation de nouvelles fonctionnalités;
* la correction de quelques anomalies (une tâche doit être attachée à un utilisateur, choisir un rôle pour un utilisateur)
* l'implémentation de tests automatisés.

Il m'est également demandé d'analyser le projet afin d'avoir une vision d'ensemble de la qualité du code et de la
performance de l'application. Je dois également apporter un document technique explicitant l'authentification.

## Installation
### Prerequisities
> Language : PHP ^8.2.9, Symfony ^7.0.3

> Database : Postgres ^15.0

> A WebServer

> Install composer

1. Clone or download (or fork to contribute) this repository : https://github.com/David-Renard/OC-p8-s7.git
2. Edit your own .env file into an .env.local file in wich you have to change the doctrine section and paste in :

`DATABASE_URL="postgresql://postgres:root@127.0.0.1:5432/ToDos7?serverVersion=15&charset=utf8"`

__ToDos7__ wille be the name of your database.

3. Create the database by running : 

`symfony console doctrine:database:create`

4. Then you can migrate by running : 

`symfony console doctrine:migrations:migrate`

5. Load fixtures by running :

`symfony console doctrine:fixtures:load`

6. Your project should now be ready!

7. You can use project after running symfony serve -d

8. Here is a ROLE_USER account :
* oceanebarb@hotmail.com
* Ocean84-Barb

9. Here is a ROLE_ADMIN account :
* xavdu@hotmail.com
* Xavier75+Dupon
