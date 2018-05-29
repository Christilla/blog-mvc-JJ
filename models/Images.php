<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 15/05/18
 * Time: 09:39
 */

class Images
{
    /**
     * @param $pAnnonceId Int Identifiant de l'annonce
     * @param $pPath String Chemin d'accès à l'image
     * @param $pMainImage Boolean 1 si main image null si non
     * @return Int lastInsertId
     */
    public static function insert($pAnnonceId, $pPath, $pMainImage){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

        $req = "INSERT INTO images (
                                        `annonce_id`, 
                                        `chemin`, 
                                        `main_image`) 
                VALUES (
                        :annonce_id,
                        :chemin,
                        :mainImage)";

        $requete = $db->prepare($req);
        $requete->bindValue(':annonce_id', $pAnnonceId, PDO::PARAM_INT);
        $requete->bindValue(':chemin', $pPath, PDO::PARAM_STR);
        $requete->bindValue(':mainImage', $pMainImage, PDO::PARAM_INT);

        $requete->execute();
        return $db->lastInsertId();
    }

    /**
     * @param $pAnnonceId Int Identifiant de l'annonce
     */
    public static function delete($pAnnonceId){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

        $req = "  DELETE FROM images i 
                  INNER JOIN annonces a ON i.annonce_id = a.id
                  WHERE i.id = :id AND i.id_user = " . $_SESSION['user']['id'];
        $requete = $db->prepare($req);
        $requete->bindValue(':id', $pId, PDO::PARAM_INT);

        $requete->execute();

    }
}