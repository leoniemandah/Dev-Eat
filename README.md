# Dev-Eat

Projet Web B2 

Ce projet est essentiellement dévéloppé en Symfony.

Symfony est un framework php pour les applications Web et console et un ensemble de composants PHP réutilisables. 

Pour pouvoir le faire fonctionner il vous faudra:

-installer composer en faisant ```composer install```

-allumer votre server en l'occurrence Wampserver

-créer le une base de donnée sur PhpMyAdmin et créer un fichier .env.local ou vous rentrerez les informations de votre bdd sous cette forme : DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7

-migrer les données dans la base en important le fichier sql dans php MyAdmin qui se trouve dans wampserver

créer vous un compte Mailgun est récupéré l'API ainsi que le domaine puis rentrer ces données dans le fichier .env.local sous cette forme : MAILER_DSN=mailgun://Votre-API:Votre-domaine@default?region=us

-lancer le projet en faisant ```php bin/console server:run```
