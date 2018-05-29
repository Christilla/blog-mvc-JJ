<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 14/05/18
 * Time: 11:20
 */

class Favoris
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
     * Favoris constructor.
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
     * @param $pUserId Int Identifiant de l'utilisateur
     * @param $pAnnonceId Int Identifiant de l'annonce
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
     * @param $pAnnonceId Int Identifiant de l'annonce
     */
    public static function delete($pAnnonceId){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

        $req = "  DELETE FROM 
                    favoris 
                  WHERE 
                    annonce_id = :id AND user_id = " . $_SESSION['user']['id'];

        $requete = $db->prepare($req);
        $requete->bindValue(':id', $pAnnonceId, PDO::PARAM_INT);

        $requete->execute();

    }
}