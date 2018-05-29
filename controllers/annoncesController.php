<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 14/05/18
 * Time: 11:17
 */


class annoncesController
{

    public function index(){
        $categoriesList = Categories::getAllCategories();
        $regionsList = Regions::getAllRegions();
        $result = Annonces::getAll();
//        printr($result);
        require_once('views/annonces/index.php');
    }

    public function annonceForm(){
        $categoriesList = Categories::getAllCategories();
        require_once('views/annonces/annonceForm.php');
    }

    public function create(){
        //  CONTRÔLE DES INFORMATIONS SAISIES [TITRE, CATÉGORIE DESCRIPTION ET PRIX]
        if(empty($_POST['titre'])){
            $_SESSION['annonceFormErrorMessage'].= 'Vous devez saisir un titre pour votre annonce !<br>';
        }
        if($_POST['categorie'] == 0){
            $_SESSION['annonceFormErrorMessage'].= 'Vous devez saisir une catégorie pour votre annonce !<br>';
        }
        if(empty($_POST['description'])){
            $_SESSION['annonceFormErrorMessage'].= 'Vous devez saisir une description pour votre annonce !<br>';
        }
        if(empty($_POST['prix'])){
            $_SESSION['annonceFormErrorMessage'].= 'Vous devez saisir un prix pour votre annonce !<br>';
        }
        //  SI QU'UNE SEULE IMAGE N'EST TÉLÉCHARGÉE, CE DOIT ÊTRE LA PREMIÈRE
        IF($_FILES['image_1']['error'] === 4 && $_FILES['image_2']['error'] !== 4 || $_FILES['image_3']['error'] !== 4){
            $_SESSION['annonceFormErrorMessage'].= 'Si vous chargez une image, l\'image n°1 est obligatoire !';
        }
        if (isset($_SESSION['annonceFormErrorMessage'])){
            header('location:?controller=annonces&action=annonceForm');
        }

        $annonceId = Annonces::insert($_POST);

        if(($_FILES['image_1']['error'] != 4)){
            $extensions_valides = array( 'jpg' , 'jpeg' , 'gif' , 'png' );

            //1. strrchr renvoie l'extension avec le point (« . »).
            //2. substr(chaine,1) ignore le premier caractère de chaine.
            //3. strtolower met l'extension en minuscules.

            foreach ($_FILES as $_file => $properties){
            //    printr($_file);
            //    printr($properties);
                //  CONTRÔLE DU TYPE DE FICHIER
                $extension = strtolower(substr(strrchr($properties['name'], '.')  ,1));
                $path = "uploadedFiles/imageFiles/".$_SESSION['user']['pseudo'].".".$_file.".".time().".".$extension;

                if(move_uploaded_file($properties['tmp_name'],$path)){
                    ($_file == 'image_1') ? $mainImage = 1 : $mainImage = 0;
                    Images::insert($annonceId, $path, $mainImage);
                }

            }
            //printr($_FILES['image_1']);
        }
        $result = Annonces::getAll();
        printr($result);
        require_once ('/views/annonces/index.php');
    }

    public function confirmdelete(){
        require_once('views/annonces/confirmDelete.php');
    }

    public function delete(){
        Annonces::delete($_GET['id']);
//        require_once ('views/pages/message.php/?message=Votre annonce a bien été supprimée !');
        header('location:?controller=pages&action=message&message=Votre annonce a bien été supprimée !');
        printr($_GET);
    }

    public function mesannonces(){
        $result = Annonces::getAnnonces($_SESSION['user']['id']);
        require_once('views/annonces/index.php');
    }

    public function mesfavoris(){
        $result = Annonces::getFavoris($_SESSION['user']['id']);
        require_once('views/annonces/index.php');
    }

    public function addfavorites(){
        Favoris::addFavoris($_SESSION['user']['id'], $_GET['id']);
        header('location:?controller=annonces&action=index');
    }

    public function confirmdeletefav(){
        require_once('views/annonces/confirmDeleteFav.php');
    }

    public function deletefav(){
        Favoris::delete($_GET['id']);
        header('location:?controller=pages&action=message&message=Cette annonce a bien été supprimée de vos favoris !');
    }
}