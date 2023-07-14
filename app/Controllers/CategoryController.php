<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends CoreController
{
    public function list()
    {
        // Atelier S06E01 : Etape 2
        // On dynamise la page category-list
        // Avant d'appeler show(), on doit récupérer toutes les catégories via le Model Category
        $modelCategory = new Category();
        $categories = $modelCategory->findAll();
        // On appelle shox() en lui passant en string
        // le sous-dossier et le nom du template à utiliser
        // Le contenu de $categories est transmis à show() via $viewData['categories']
        // NB : dans les templates, on pourra faire :
        // $viewData['categories'] ou directement $categories (grâce à extract())
        $this->show('catalog/category-list', [
            'categories' => $categories
        ]);        
    }

    public function add()
    {
        $this->show('catalog/category-add');
    }

    public function create()
    {
        //echo 'On a posté le form';
        // On vérifie ce qui est contenu dans $_POST
        //var_dump($_POST);

        // Avant de stocker les données dans des variables
        // on va vérifier qu'elles existent
         // On récupère les données venant du formulaire
        // https://www.php.net/manual/fr/function.filter-input.php
        // filter_input renvoie :
        // - la valeur si la variable existe
        // - false si le filtre échoue (par ex ici : la valeur n'est pas un string)
        // - null si la variable n'est pas définie (par ex ici : $_POST['name'] n'existe pas)
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

        $subtitle = filter_input(INPUT_POST, 'subtitle', FILTER_SANITIZE_STRING);

        $picture = filter_input(INPUT_POST, 'picture', FILTER_SANITIZE_STRING);

        // Si un des champs est false ou null ==> on ne pourra pas faire l'insert en BDD
        // Dans le cas où les champs sont false ou null, on va lever une erreur (en V2 : on pourrait ajouter des notifs JS en cas d'erreur)
        // On créé un array qui va contenir les éventuelles erreurs
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
            // On entre ici : il n'y a eu aucune erreur
            // On peut faire l'insert en BDD => créer une nouvelle catégorie
            // Créer une nouvelle catégorie :
            // 1. créer un nouvel objet instance de Category
            $category = new Category();
            
            // 2. lui mettre les bonnes valeurs à ses propriétés
            $category->setName($name);
            $category->setSubtitle($subtitle);
            $category->setPicture($picture);

            // 3. on appelle la méthode dédiée à faire l'insert en BDD
            $isInserted = $category->insert();

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