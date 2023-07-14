# ajouter des donnees en BDD

## INDEX Creation de la route 

``` php
$router->map(
    'POST',
    '/category/add',
    [
        'method' => 'create',
        'controller' => '\App\Controllers\CategoryController'
    ],
    'catalog-createCategory'
);
```

## Controllers

``` php 
<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController
{
    // methode pour controller l'ajout de données
    public function create()
    {
        // On vérifie ce qui est contenu dans $_POST
            // verification de l'existance des données
                // https://www.php.net/manual/fr/function.filter-input.php
                // filter_input renvoie :
                    // filter-input retourne
                    // - false si le filtre échoue (par ex ici : la valeur n'est pas un string)
                    // - null si la variable n'est pas définie (par ex ici : $_POST['name'] n'existe pas)
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);
        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING);

        /
        // On créé un array qui va contenir les éventuelles erreurs qui seront traiter dans une autre procedure
        $errorList = [];

        if ($name === false) {
            // KO : on lève une erreur en ajoutant l'erreur dans l'array d'erreur
            $errorList[] = "Le nom de la catégorie n'a pas le bon format (on doit avoir une chaine de caractère)";
        }
        if (empty($name)) {
            // KO : on lève une erreur
            $errorList[] = "Merci de renseigner un nom pour cette nouvelle catégorie";
        }

        if ($subtitle === false) {
            $errorList[] = "Le sous-titre de la catégorie n'a pas le bon format (on doit avoir une chaine de caractère)";
        }
        if (empty($subtitle)) {
            $errorList[] = "Merci de renseigner un sous-titre pour cette nouvelle catégorie";
        }

        if ($picture === false) {
            $errorList[] = "L'image de la catégorie n'a pas le bon format (on doit avoir une chaine de caractère)";
        }
        if (empty($picture)) {
            $errorList[] = "Merci de renseigner une image pour cette nouvelle catégorie";
        }

        // Si on a aucune erreur ==> on pourra faire l'insertion en BDD
        // Aucune erreur : signifie que errorList est resté vide
        if (empty($errorList)) {
            // il n'y a eu aucune erreur
            // 1. créer un nouvel objet instance de Category
            $category = new Category();
            
            // 2. lui mettre les bonnes valeurs à ses propriétés
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);

            // 3. on appelle la méthode dédiée à faire l'insert en BDD
            $isInserted = $category->insert();

            // verification que l'insertion en bdd a été bien realisée
            if ($isInserted) {
                // Ici, l'insertion s'est bien passée
                // On redirige l'internaute vers la page liste
                // https://www.php.net/manual/fr/function.header.php
                header('Location: /category/list');
                exit;
            } else {
                // L'insertion a échouée : on ajoute un message d'erreur
                $errorList[] = "L'insertion de cette nouvelle catégorie a échouée";
            }
        }
    }
}
```

## Model

``` php
public function insert()
    {
        // Connexion à la BDD
        $pdo = Database::getPDO();

        // On écrit la query string (requête)
            // equêtes préparées (pour que la resuette ne puisse pas etre utilisé en cas d'interception)
                // exec() est remplacé par 2 méthodes : prepare() puis execute()
                // ON NE PASSE PLUS DE DONNEES DANS LA QUERY STRING
                // On utilise pour cela des marqueurs nommés (:nom)
        $sql = '
        INSERT INTO `category`
        (`name`, `subtitle`, `picture`)
        VALUES (:name, :subtitle, :picture)        
        ';

        // 1. On prépare la requête
        // https://www.php.net/manual/fr/pdo.prepare.php
        $query = $pdo->prepare($sql);

        // 2. On exécute la requête
        // C'est à ce moment là qu'on doit passer les valeurs attendues pour les marqueurs nommés
        $query->execute([
            // on recupere les donnée dans l'objet courant
            ':name' => $this->name,
            ':subtitle' => $this->subtitle,
            ':picture' => $this->picture
        ]);

    
        // verification pour savoir si l'insertion c'est bien passée
            // la méthode rowCount() compte le nombre de ligne insérées. 
        
        $nbOfInsertedRows = $query->rowCount();

        // si nb de ligne sup à 0 return true
        if ($nbOfInsertedRows > 0) {
            // Tout s'est bien passé, on a réussi à insérer la nouvelle catégorie
            // L'id de cette nouvelle catégorie est auto-généré (et incrémenté) par MySQL mais l'objet courant ne le connait pas
            // On doit récupérer cet id pour le stocker dans la propriété de la category (pourquoi le récupérer ? MuySQL ne transmet pas cette info à PHP, qui en a besoin lors de l'affichage de la liste des catégories au moment d'afficher l'id)
            $this->id = $pdo->lastInsertId();

            return true;

        } else {
            // KO : insertion échouée
            return false;
        }

    }