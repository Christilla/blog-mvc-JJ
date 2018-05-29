<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 14/05/18
 * Time: 09:57
 */

class Regions
{


    public $id;
    public $name;

    /**
     * Regions constructor.
     * @param $pId Int Identifiant de la région
     * @param $pName String intitulé de la région
     */
    function __construct($pId, $pName){
        $this->id = $pId;
        $this->name = $pName;
    }

    /**
     * @return array Collection d'objets Regions
     */
    public static function getAllRegions(){
        $db = Db::getInstance();
        $list = [];

        $requete = "SELECT * FROM regions WHERE 1";
        $req = $db->query($requete);

        foreach($req->fetchAll() as $region){
//          $list EST REMPLI AVEC DES OBJETS Regions
            $list[] = new Regions($region['id'], utf8_encode($region['name']));
        }
        $req->closeCursor();
        return $list;

    }

}