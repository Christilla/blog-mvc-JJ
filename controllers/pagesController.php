<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 02/05/18
 * Time: 11:16
 */

class PagesController{

    public function home(){
        require_once ('views/pages/home.php');
    }

    public function error(){
        require_once ('views/pages/error.php');
    }

    public function connectionError(){
        require_once ('views/pages/connectionError.php');
    }

    public function is_connected(){
        require_once ('views/pages/is_connected.php');
    }

    public function message(){
        require_once ('views/pages/message.php');
    }
}