<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 02/05/18
 * Time: 09:16
 */

class Db{
//
    private static $instance = null;
//
    private function __construct(){

    }
//
    private function __clone(){

    }


    public static function getInstance(){
//      CRÉATION DE L'INSTANCE SI ELLE N'EXISTE PAS
//      SELF FAIT RÉFÉRENCE À LA CLASSE
        if(!isset(self::$instance)){

            $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8');


//          INSTANCIATION DE L'ATTRIBUT D'INSTANCE DE LA CLASSE Db
            self::$instance = new PDO('mysql:host=localhost;dbname=beweb_db', 'root', '', $option);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//            self::$instance->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        }
        return self::$instance;
    }
}