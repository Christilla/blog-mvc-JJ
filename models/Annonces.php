<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 14/05/18
 * Time: 11:20
 */

class Annonces
{
    public $id;
    public $titre;
    public $description;
    public $prixDeVente;
    public $cheminImage;
    public $pseudoUser;
    public $categorieName;
    public $regionName;
    public $idUser;

    /**
     * Annonces constructor.
     * @param $id Int Identifiant de l'annonce
     * @param $titre String Titre de l'annonce
     * @param $description String Description de l'annonce
     * @param $prixDeVente Decimal Prix de vente de l'annonce
     * @param $cheminImage String Chemin d'accès à la main image de l'annonce
     * @param $pseudoUser String Pseudo du rédacteur de l'annonce
     * @param $idUser
     * @param $categorieName String Nom de la catégorie à laquelle appartient l'annonce
     * @param $regionName String Région dans laquelle se situe le rédacteur de l'annonce
     */
    public function __construct($id, $titre, $description, $prixDeVente, $cheminImage, $pseudoUser, $idUser, $categorieName, $regionName){

        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->prixDeVente = $prixDeVente;
        $this->cheminImage = $cheminImage;
        $this->pseudoUser = $pseudoUser;
        $this->categorieName = $categorieName;
        $this->regionName = $regionName;
        $this->idUser = $idUser;
    }

    /**
     * @param $pPost array Données issues d'un formulaire
     * @return int Identifiant
     */
    public static function insert($pPost){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

//        $pPost = convertUTF8($pPost);
//        printr($pPost);
        $req = "INSERT INTO annonces (
                                        `titre`, 
                                        `description`, 
                                        `prix_de_vente`, 
                                        `user_id`, 
                                        `categorie_id`) 
                VALUES (
                        :titre,
                        :description,
                        :prix,
                        :userId,
                        :categorieId)";
        $requete = $db->prepare($req);
        $requete->bindValue(':titre', $pPost['titre'], PDO::PARAM_STR);
        $requete->bindValue(':description', $pPost['description'], PDO::PARAM_STR);
        $requete->bindValue(':prix', $pPost['prix'], PDO::PARAM_STR);
        $requete->bindValue(':userId', $_SESSION['user']['id'], PDO::PARAM_INT);
        $requete->bindValue(':categorieId', $pPost['categorie'], PDO::PARAM_INT);

        $requete->execute();
        return $db->lastInsertId();
    }

    /**
     * @return array Collection d'objets Annonces
     */
    public static function getAll(){
        $list = [];
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

        $req = "SELECT
                  a.id id,
                  a.titre titre,
                  a.description description,
                  a.prix_de_vente prix_de_vente,
                  i.chemin cheminImage,
                  u.pseudo pseudo,
                  u.id idUser,
                  c.name catName,
                  r.name regionName
                FROM
                  `annonces` a
                LEFT JOIN
                  `images` i ON i.annonce_id = a.id AND i.main_image = 1
                INNER JOIN
                  `users` u ON a.user_id = u.id
                INNER JOIN
                  `regions` r ON u.region_id = r.id
                INNER JOIN
                  `categories` c ON a.categorie_id = c.id
                WHERE
                  1
                ";
        $req = $db->query($req);
//      POUR CHACUNE DES ENTRÉES
        foreach($req->fetchAll() as $result){
//          $list EST REMPLI AVEC DES OBJETS
            $list[] = new Annonces($result['id'], $result['titre'], $result['description'], $result['prix_de_vente'], $result['cheminImage'], $result['pseudo'], $result['idUser'], $result['catName'], $result['regionName']);
        }
        $req->closeCursor();
        return $list;
    }

    /**
     * @param $pUserId int Identifiant utilisateur en BDD
     * @return array Collection d'objets Annonces
     */
    public static function getAnnonces($pUserId){
        $list = [];
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

        $req = "SELECT
                  a.id id,
                  a.titre titre,
                  a.description description,
                  a.prix_de_vente prix_de_vente,
                  i.chemin cheminImage,
                  u.pseudo pseudo,
                  u.id idUser,
                  c.name catName,
                  r.name regionName
                FROM
                  `annonces` a
                LEFT JOIN
                  `images` i ON i.annonce_id = a.id AND i.main_image = 1
                INNER JOIN
                  `users` u ON a.user_id = u.id
                INNER JOIN
                  `regions` r ON u.region_id = r.id
                INNER JOIN
                  `categories` c ON a.categorie_id = c.id
                WHERE
                  a.user_id = 
                " . $pUserId;
        $req = $db->query($req);
//      POUR CHACUNE DES ENTRÉES
        foreach($req->fetchAll() as $result){
//          $list EST REMPLI AVEC DES OBJETS
            $list[] = new Annonces($result['id'], $result['titre'], $result['description'], $result['prix_de_vente'], $result['cheminImage'], $result['pseudo'], $result['idUser'], $result['catName'], $result['regionName']);
        }
        $req->closeCursor();
        return $list;
    }

    /**
     * @param $pUserId int Identifiant utilisateur en BDD
     * @return array Collection d'objets Annonces
     */
    public static function getFavoris($pUserId){
        $list = [];
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

        $req = "SELECT
                  a.id id,
                  a.titre titre,
                  a.description description,
                  a.prix_de_vente prix_de_vente,
                  i.chemin cheminImage,
                  u.pseudo pseudo,
                  u.id idUser,
                  c.name catName,
                  r.name regionName
                FROM
                  `annonces` a
                LEFT JOIN
                  `images` i ON i.annonce_id = a.id AND i.main_image = 1
                INNER JOIN
                  `users` u ON a.user_id = u.id
                INNER JOIN
                  `regions` r ON u.region_id = r.id
                INNER JOIN
                  `categories` c ON a.categorie_id = c.id
                INNER JOIN
                  `favoris` f ON f.annonce_id = a.id
                WHERE
                  f.user_id = " . $pUserId;

        $req = $db->query($req);
//      POUR CHACUNE DES ENTRÉES
        foreach($req->fetchAll() as $result){
//          $list EST REMPLI AVEC DES OBJETS
            $list[] = new Annonces($result['id'], $result['titre'], $result['description'], $result['prix_de_vente'], $result['cheminImage'], $result['pseudo'], $result['idUser'], $result['catName'], $result['regionName']);
        }
        $req->closeCursor();
        return $list;

    }

    /**
     * @param $pUserId int Identifiant utilisateur en BDD
     * @param $pAnnonceId int Identifiant annonce en BDD
     */
    public static function addFavoris($pUserId, $pAnnonceId){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

        $req = "INSERT INTO favoris (
                                        `user_id`, 
                                        `annonce_id`) 
                VALUES (
                        :userId,
                        :annonceId)";
        $requete = $db->prepare($req);
        $requete->bindValue(':userId', $pUserId, PDO::PARAM_INT);
        $requete->bindValue(':annonceId', $pAnnonceId, PDO::PARAM_INT);

        $requete->execute();
    }

    /**
     * @param $pAnnonceId int Identifiant annonce en BDD
     */
    public static function delete($pAnnonceId){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();


        $req = " DELETE
                  annonces,
                  images,
                  favoris
                FROM
                  annonces
                INNER JOIN
                  images ON images.annonce_id = annonces.id
                INNER JOIN
                  favoris ON favoris.annonce_id = annonces.id
                WHERE
                  annonces.id = :id AND annonces.user_id = " . $_SESSION['user']['id'];
        $requete = $db->prepare($req);
        $requete->bindValue(':id', $pAnnonceId, PDO::PARAM_INT);

        $requete->execute();

    }
}