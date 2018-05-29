<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 02/05/18
 * Time: 10:12
 */

require ('./models/Post.php');

class PostController{

    public function index(){
        $posts = Post::all();
        require_once ('./views/posts/index.php');
    }

    public function show(){
        $post = Post:: getPostById((int)$_GET['id']);
        $comments = Comments::getAllCommentsByIdPost((int)$_GET['id']);
        require_once ('./views/posts/show.php');
    }

    public function newPost(){
        if(isset($_GET['id'])){
            $post = Post:: getPostById((int)$_GET['id']);
            require_once ('./views/posts/newPost.php');
        }else{
            require_once ('./views/posts/newPost.php');
        }
    }

    public function create(){
        if(isset($_SESSION['user']['id']) && isset($_POST['content'])){
            $post = Post:: createNewPost($_SESSION['user']['id'], $_POST['content']);
            $posts = Post::all();
            require_once ('./views/posts/index.php');
        }else{
            call('pages', 'error');
        }
    }

    public function update(){
        if(isset($_GET['id']) && isset($_POST['content'])){
            $post = Post:: update($_GET['id'], $_POST['content']);
            $posts = Post::all();
            require_once ('./views/posts/index.php');
        }else{
            call('pages', 'error');
        }
    }

    public function confirm(){
        if(isset($_GET['id'])){
            $post = Post:: getPostById((int)$_GET['id']);
            require_once ('./views/posts/confirm.php');
        }else{
            call('pages', 'error');
        }
    }

    public function delete(){
        if(isset($_GET['id'])){
            $post = Post:: deletePostById((int)$_GET['id']);
//            require_once ('./views/posts/index.php');

            $posts = Post::all();
            require_once ('./views/posts/index.php');
        }else{
            call('pages', 'error');
        }
    }
}