<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 02/05/18
 * Time: 10:12
 */

class UsersController{

    public function connectionForm(){
        if(isset($_SESSION['user'])){
            call ('pages', 'is_connected');
        }else{
            $regionsList = Regions::getAllRegions();
            require_once ('./views/users/connectionForm.php');
        }
    }

    public function create(){
        $_SESSION['confirmErrorMessage'] = '';
        //  CONTROLE DE LA VALIDITÉ DE LA SAISIE DES IDENTIFIANTS
        if (empty($_POST['pseudo']) || empty($_POST['password']) || empty($_POST['confirmPassword'])){
            $_SESSION['confirmErrorMessage'].= 'Erreur de saisie de vos identifiants !<br />';
            header('location:?controller=users&action=connectionForm');
        }
        //  CONTROLE DE LA VALIDITÉ DES MOTS DE PASSE
        if ($_POST['password'] !== $_POST['confirmPassword']){
            $_SESSION['confirmErrorMessage'].= 'La confirmation du mot de passe ne correspond pas au mot de passe saisi ! <br />';
            header('location:?controller=users&action=connectionForm');
        }
        //  VÉRIFICATION DE L'ADRESSE EMAIL
        if(!preg_match ( " /^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/ " , $_POST['email'] )){
            $_SESSION['confirmErrorMessage'].= 'Adresse email invalide ! <br />';
            header('location:?controller=users&action=connectionForm');
        }
        //  VÉRIFICATION DU TÉLÉPHONE
        if (!preg_match ( "#^0[0-9]([ .-]?[0-9]{2}){4}$#" , $_POST['tel'] ) )
        {
            $_SESSION['confirmErrorMessage'].= 'Numéro de téléphone invalide !<br />';
            header('location:?controller=users&action=connectionForm');
        }
        //  INSERTION EN BDD DANS LA TABLE USER AVEC DATE NON RENSEIGNÉE ET RÉCUPÉRATION D'UN CODE D'ACTIVATION
        $confirmLink = Users::createUser($_POST);

        echo '<a href="http://mini_blog.par/?controller=users&action=activation&code='. $confirmLink.'">Lien d\'activation</a>';
    }

    public function activation(){
        if(isset($_GET['code']) && !empty($_GET['code'])){
            Users::activation($_GET['code']);
        }
        $location = 'location:'.$_SESSION['current_page'];
        header($location);
    }

    public function connect(){
        //  CONTROLE DE LA VALIDITÉ DE LA SAISIE DES IDENTIFIANTS
        if (empty($_POST['pseudo']) || empty($_POST['password'])){
            $_SESSION['errorMessage'] = 'Erreur de saisie de vos identifiants';
            header('location:?controller=users&action=connectionForm');
        }else{
        //  CONTROLE DE L'EXISTENCE DE L'UTILISATEUR EN BDD
            $user = Users::getUser($_POST['pseudo'], $_POST['password']);
            if($_POST['pseudo'] == $user->pseudo && $_POST['password'] == $user->password){
                $_SESSION['user'] = [
                                        'id'=>$user->id,
                                        'pseudo'=>$user->pseudo,
                                        'roleId'=>$user->roleId,
                                        'role'=>$user->role,
                                        'email'=>$user->email,
                                        'telephone'=>$user->telephone,
                                        'regionId'=>$user->regionId,
                                        'createdDate'=>$user->createdDate
                                    ];
    //            print_r($_SESSION['user']['id']);
    //            print_r($_SESSION['user']['pseudo']);
    //            call ('pages', 'home');
                $location = 'location:'.$_SESSION['current_page'];
                header($location);
            }else{
                call ('pages', 'connectionError');
            }
        }
    }

    public function deconnexion(){
        unset($_SESSION['user']);
        header('location:http://mini_blog.par');
    }

    public function profil(){
        Users::getUserById($_SESSION['user']['id']);
        require_once('views/users/profil.php');
    }
}