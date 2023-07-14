<?php

namespace App\Controllers;

use App\Models\Product;

class ProductController extends CoreController
{
    public function list()
    {
        // Atelier S06E01 : Etape 2 dynamisation
        // On appelle le Model Product pour récupérer tous les produits
        $modelProduct = new Product();
        $products = $modelProduct->findAll();

        $this->show('catalog/product-list', [
            'products' => $products
        ]);

    }

    public function add()
    {
        $this->show('catalog/product-add');
    }
}