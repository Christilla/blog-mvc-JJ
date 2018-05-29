<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 14/05/18
 * Time: 09:57
 */

class Categories
{
    public $id;
    public $name;

    /**
     * Categories constructor.
     * @param $pId Int Identifiant de la catégorie
     * @param $pName String Nom de la catégorie
     */
    function __construct($pId, $pName){
        $this->id = $pId;
        $this->name = $pName;
    }

    /**
     * @return array Collection d'objets Catégorie
     */
    public static function getAllCategories(){
        $db = Db::getInstance();
        $list = [];

        $requete = "SELECT * FROM categories WHERE 1";
        $req = $db->query($requete);

        foreach($req->fetchAll() as $categorie){
//          $list EST REMPLI AVEC DES OBJETS Catégories
            $list[] = new Categories($categorie['id'], utf8_encode($categorie['name']));
        }
        $req->closeCursor();
        return $list;

    }

}