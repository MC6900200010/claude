<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT * FROM `category` WHERE `id` =' . $categoryId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject('App\Models\Category');

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     *
     * @return Category[]
     */
    public function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT * FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $results;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT *
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, 'App\Models\Category');

        return $categories;
    }

    /**
     * Méthode qui insère une nouvelle catégorie en BDD
     *
     * @return void
     */
    public function insert()
    {
        // Connexion à la BDD
        $pdo = Database::getPDO();

        // On écrit la query string (requête)
        // On utilise à partir de maintenant des requêtes préparées
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
            ':name' => $this->name,
            ':subtitle' => $this->subtitle,
            ':picture' => $this->picture
        ]);

        // Arrivé ici, soit l'insertion s'est bien passée, soit elle a échoué
        // Insertion bien passée = on a inséré 1 ligne en BDD
        // Pour savoir ca : $query va appeller la méthode rowCount()
        // si ok ==> return true (sinon false)
        $nbOfInsertedRows = $query->rowCount();

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
}
