<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 02/05/18
 * Time: 09:17
 */

/**
 * Fonction de routage
 * @param $pController String Donnée contrôleur issues de l'URI
 * @param $pAction String  Donnée action issues de l'URI
 */
function call($pController, $pAction){
    require_once ('controllers/' . $pController . 'Controller.php');

    switch($pController){
        case('pages'):
            $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
            $controller = new PagesController();
            break;

        case('post'):
            $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
            require_once('models/Post.php');
            require_once('models/comments.php');
            $controller = new PostController();
        break;

        case('users'):
            require_once ('./models/Regions.php');
            require_once('models/users.php');
            $controller = new UsersController();
        break;

        case('comments'):
            $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
            require_once('models/comments.php');
            $controller = new CommentsController();
        break;

        case('annonces'):
            $_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
            require_once ('./models/Categories.php');
            require_once ('./models/Images.php');
            require_once ('./models/Regions.php');
            require_once ('./models/Favoris.php');
            require_once('models/Annonces.php');
            $controller = new AnnoncesController();
        break;
    }
    call_user_func(array($controller, $pAction));
//    $controller->{ $pAction }();
}

//  DÉFINITION DES ROUTES
$routes = array(
                'pages'     =>['home', 'error', 'connectionError', 'is_connected', 'message'],
                'users'     =>['connect', 'connectionForm', 'deconnexion', 'create', 'activation', 'profil'],
                'post'      =>['index', 'show', 'newPost', 'create', 'update', 'confirm', 'delete'],
                'comments'  =>['create', 'delete', 'update'],
                'annonces'  =>['index', 'annonceForm', 'create', 'mesannonces', 'mesfavoris', 'addfavorites', 'confirmdelete', 'delete', 'confirmdeletefav', 'deletefav'],
                'end'       =>['end']
                );

//  VÉRIFICATION DE L'EXISTENCE DES CONTRÔLEURS ET ACTIONS ASSOCIÉES DÉFINIS DANS L'URI
if(array_key_exists($controller, $routes)){
    if(in_array($action, $routes[$controller])){
        //  APPEL DE LA FONCTION DE ROUTAGE
        call($controller, $action);
    }else{
        //  ROUTAGE VERS UNE PAGE D'ERREUR SI L'ACTION DEMANDÉE N'EXISTE PAS
        call('pages', 'error');
    }
}else{
    //  ROUTAGE VERS UNE PAGE D'ERREUR SI LE CONTRÔLEUR DEMANDÉ N'EXISTE PAS
    call('pages', 'error');
}
