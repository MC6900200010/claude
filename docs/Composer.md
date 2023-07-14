# composer : la bibliotheque d'outils pour PHP

C'est une bibliotheque d'outils php

[site officiel](https://getcomposer.org/)

## Stynthese mise a jour ou instal composer

1. Mise a jour ou instal composer au lancement du projet

Si on a déjà un fichier json (mise a jour de composer)
   - Ds le terminal a la racine faire la cmd  : `composer dump-autoload`
   - ou il  existe aussi la commande `composer update`

Si aucun fichier json 
   - faire la cmd `Composer install`
    - 
  
1. Altorouter
   Ds le terminal a la racine faire la cmd : `composer require altorouter/altorouter`

2. `require`

Dans le fichier index.php

 ```php
 require __DIR__ . '/../vendor/autoload.php';
```

## Synthese instal des librairies

- AltoRouter 
  - Permet le rouatge des routes dans index
  - Dans le terminale a la racine du projet faire cmd : `composer require altorouter/altorouter`

- benoclock/alto-dispatcher
  - permet de deisparcher aprezs le routage
  - https://packagist.org/packages/benoclock/alto-dispatcher
  - Dans le terminale a la racine du projet faire cmd : `composer require benoclock/alto-dispatcher`

- symfony / var-dumper
  - Fournit des mécanismes pour parcourir n'importe quelle variable PHP arbitraire
  - Il fournit une meilleure dump()fonction que vous pouvez utiliser à la place de var_dump().
  - https://packagist.org/packages/symfony/var-dumper
  - Dans le terminale a la racine du projet faire cmd : `composer require symfony/var-dumper`
  - dump(get_defined_vars());

### composer (instal entiere)

Pour les téléporteurs :

    ```bash
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

    php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

    php composer-setup.php

    php -r "unlink('composer-setup.php');"

    sudo mv composer.phar /usr/local/bin/composer

    composer --version
    Composer version 2.5.8
    ```

Pour les VM Cloud

    ```bash
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"

    php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"

    php composer-setup.php

    php -r "unlink('composer-setup.php');"

    sudo mv composer.phar /usr/bin/composer

    composer --version
    Composer version 2.5.8
    ```

Si le terminal demande un mot de passe `[sudo] Mot de passe de student : ` il faut taper le mot de passe et entrée.

Dans un terminal Linux, les mots de passe ne s'affiche pas, c'est donc normal de ne rien voir quand on tape le mot de passe.

### pour windows

    [doc](https://getcomposer.org/doc/00-intro.md#installation-windows)

    [liste des packages PHP](https://packagist.org/)

# fichier créer par composer

Composer crée à la racine du projet 2 fichiers :

* `composer.json`
  * c'est le fichier de paramétrage de notre projet
  * avec la liste des packages installés
* `composer.lock`
  * c'est un fichier interne à composer qui liste en détails les packages installés
  * on ne touche pas à ce fichier

✅ Les 2 composer nesont pas dans /vendor et c'est comme ca qu'on va savoir quoi installer chez nous en gros

# dossier `Vandor` créer par composer

Composer cré un dossier vendor à la racine du projet avec tous les package des bibliotheques
Ce dossier ne doit pas etre push sur git. Il faut l'integrer dans `.gitignore`

# utilisation des package

Pour utiliser les packages on doit faire un require.

```php
require __DIR__ . '/../vendor/autoload.php';
```







#### récap David

```php
$router->map(
   $method,  // method HTTP : GET/POST /!\ rien à voir avec $_GET
   $route, // A quoi la donnée doit correspondre/ Ce que devrait être l'url
   $target, // Quoi faire quand on est sur la bonne route
   $Name // Identifiant unique de la route

$router->match() // renvoie la route qui match avec l'url + renvoie ce qu'il est obtenue par target ET par les paramètre de route venant de l'URL

```


# CREATION D'UN FICHIER COMPOSER.JSON
tuto : https://grafikart.fr/tutoriels/composer-480


A la racin edu projet ds le terminal 

` composer init`