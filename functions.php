<?php

// Paramètres de connexion à la base de données (à adapter en fonction de votre environnement);

define('HOST', 'localhost');
define('USER', 'root');
define('DBNAME', 'links_manager_dev');
define('PASSWORD', ''); // windows (Mamp le mot de passe c'est 'root')

/**
 * Fonction de connexion à la base de données
 *
 * @return \PDO
 */
function db_connect(): PDO
{
    try {
        /**
         * Data Source Name : chaine de connexion à la base de données
         * Elle permet de renseigner le domaine du serveur de la base de données, le nom de la base de données cible et l'encodage de données pendant leur transport
         * @var string
         */
        $dsn =  'mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=utf8';

        return new PDO($dsn, USER, PASSWORD, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (\PDOException $ex) {
        echo sprintf('La demande de connexion à la base de donnée a échouée avec le message %s', $ex->getMessage());
        exit(0);
    }
}


/**
 * Fonction qui permet de récupérer le tableau des enregistrements de la table des liens
 * @return array
 */
function get_all_link()
{
    // connection à la base de données
    $connexion = db_connect();

    // création de la requête
    $stmt = $connexion->query("SELECT `link_id`, `title`, `url` FROM `links`");

    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // on récupère tout les résultats
    $select = $stmt->fetchAll();

    return $select;
}


/**
 * Fonction qui permet de récupérer un enregistrement à partir de son identifiant dans la table des liens
 * @param integer $link_id
 * @return array
 */
function get_link_by_id($link_id)
{
    // connection à la base de données
    $connexion = db_connect();

    // création de la requête préparé
    $stmt = $connexion->prepare("SELECT `link_id`, `title`, `url` FROM `links` WHERE link_id = :link_id");

    // création de paramètre pour sécurisé la requête
    $stmt->bindParam(":link_id", $link_id);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    
    // execution de la requête
    $stmt->execute();
    // on récupère un seul résultats
    $select = $stmt->fetchAll();

    return $select;
}


/**
 * Fonction qui permet de modifier un enregistrement dans la table des liens
 * @param array $data: ['link_id' => 1, 'title' => 'MDN', 'url' => 'https://developer.mozilla.org/fr/']
 * @return bool
 */
function update_link($data)
{
    // connection à la base de données
    $connexion = db_connect();

    // déclaration d'une variable pour récupérer le nombre de ligne inséré
    $nbLigne=0;

    // création de la requête préparé
    $stmt = $connexion->prepare("UPDATE links SET `title` = :title, `url` = :url_link WHERE `link_id` = :link_id");

    // création de paramètre pour sécurisé la requête
    $stmt->bindParam(":link_id", $data['link_id']);
    $stmt->bindParam(":link_id", $data['link_id']);
    $stmt->bindParam(":url_link", $data['url']);

    // execution de la requête
    $stmt->execute();

    // compte le nombre de ligne executé
    $nbLigne += $stmt->rowCount();
    

    return $nbLigne;
}


/**
 * Fonction qui permet de d'enregistrer un nouveau lien dans la table des liens
 * @param array $data: ['title' => 'MDN', 'url' => 'https://developer.mozilla.org/fr/']
 * @return bool
 */
function create_link($data)
{
    // connection à la base de données
    $connexion = db_connect();

    // déclaration d'une variable pour récupérer le nombre de ligne inséré
    $nbLigne=0;

    // création de la requête préparé
    $stmt = $connexion->prepare("INSERT INTO links(`title`, `url`) VALUE(:title, :url_link)");

    // création de paramètre pour sécurisé la requête
    $stmt->bindParam(":title", $data['title']);
    $stmt->bindParam(":url_link", $data['url']);

    // execution de la requête
    $stmt->execute();
    
    // compte le nombre de ligne executé
    $nbLigne += $stmt->rowCount();
    

    return $nbLigne;
}

/**
 * Fonction qui permet de supprimer l'enregistrement dont l'identifiant est $linl_id dans la table des liens
 * @param integer $link_id
 * @return bool
 */
function delete_link($link_id)
{
    // connection à la base de données
    $connexion = db_connect();

    // création de la requête préparé
    $stmt = $connexion->prepare("DELETE FROM `links` WHERE `link_id` = :link_id ");

    // création de paramètre pour sécurisé la requête
    $stmt->bindParam(':link_id', $link_id);

    // execution de la requête
    return $stmt->execute();
}
