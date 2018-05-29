<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 07/05/18
 * Time: 10:05
 */



class CommentsController
{
    public function create(){
        if(isset($_POST['id_post'], $_POST['id_user'], $_POST['comment'])){
            try {
                Comments::create((int)$_POST['id_post'], (int)$_POST['id_user'], $_POST['comment']);
                header('location:?controller=post&action=show&id='.$_POST['id_post']);
            } catch (PDOException $e) {
                print "Un problème est survenu lors de la requête. Veuillez contacter l'administrateur du site";

    //            die(); // Comment this out if you want the script to continue execution

            }
        }else{
            header('location:?controller=pages&action=error');
        }
//        Comments::create((int)$_POST['id_post'], (int)$_POST['id_user'], $_POST['comment']);
//        var_dump(Comments::getAllCommentsByIdPost((int)$_POST['id_post'], (int)$_POST['id_user'], $_POST['comment']));
    }
}