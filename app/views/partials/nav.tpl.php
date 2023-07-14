<nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo $router->generate('main-home'); ?>">oShop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>

              
              
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= (($router->match()['name'])=== 'main-home') ? 'active' : ''  ?>" href="<?php echo $router->generate('main-home'); ?>">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (($router->match()['name'])=== 'catalog-category') ? 'active' : ''  ?>" href="<?= $router->generate('catalog-category') ?>">Catégories <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (($router->match()['name'])=== 'catalog-product') ? 'active' : ''  ?>" href="<?= $router->generate('catalog-product') ?>">Produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Types</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Marques</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tags</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sélection Accueil</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>