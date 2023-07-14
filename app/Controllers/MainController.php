<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        // Atelier S06E01 : on doit dynamiser la home
        // On va utiliser la méthode findAllHomePage() pour les catégories
        // $modelCategory = new Category();
        // $categories = $modelCategory->findAllHomepage();

        // V2 : Pour ne pas créer à chaque fois une nouvelle instance de la classe, on pourrait utiliser des méthodes "statiques" (mot-clé static)
        // Dans ce cas, on peut appeler la méthode directement sur la classe
        // Syntaxe : Nom_classe::nom_methode()
        $categories = Category::findAllHomepage();
        // remplace les lignes 19 et 20

        // On va créé 1 méthode pour n'afficher que les 5 premiers produits
        $modelProduct = new Product();
        $products = $modelProduct->findFiveProductsHomePage();

        // On appelle la méthode show() de l'objet courant
        // En argument, on fournit le fichier de Vue
        // Par convention, chaque fichier de vue sera dans un sous-dossier du nom du Controller
        $this->show('main/home', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
