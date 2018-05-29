<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 02/05/18
 * Time: 09:53
 */

class Post{

    public $id;
    public $author;
    public $content;
    public $created_date;
    public $pPseudo;

    /**
     * Post constructor.
     * @param $pId Int Identifiant du billet
     * @param $pAuthor Int Identifiant du rédacteur du billet
     * @param $pContent String Contenu du billet
     * @param $pCreated_date DateTime Date de création du billet
     * @param $pPseudo String Pseudo du rédacteur du billet
     */
    public function __construct($pId, $pAuthor, $pContent, $pCreated_date, $pPseudo){
        $this->id           = $pId;
        $this->author       = $pAuthor;
        $this->content      = $pContent;
        $this->created_date = $pCreated_date;
        $this->pPseudo      = $pPseudo;
    }

    /**
     * @return array Collection d'objet Post
     */
    public static function all(){
        $list = [];
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();
//      $req EST LA REQUÊTE

       // SELECT post.*, u.pseudo FROM post INNER JOIN users u ON post.author = u.id WHERE 1


        $req = 'SELECT post.*, u.pseudo FROM post
                INNER JOIN users u
                ON post.author = u.id WHERE 1';
        $req = $db->query($req);
//      POUR CHACUNE DES ENTRÉES DE LA TABLE Post
        foreach($req->fetchAll() as $post){
//          $list EST REMPLI AVEC DES OBJETS Post
            $list[] = new Post($post['id'], $post['author'], $post['content'], $post['created_date'], $post['pseudo']);
        }
        $req->closeCursor();
        return $list;
    }

    /**
     * @param $pId Int Identifiant du billet
     * @return array Élément Post issu de la BDD
     */
    public static function getPostById($pId){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();
//      $req EST LA REQUÊTE
        $req = 'SELECT * FROM post WHERE id = '.$pId;
        $req = $db->query($req);
        $returnValue = $req->fetch();
        $req->closeCursor();
        return $returnValue;
    }

    /**
     * @param $pAuthorId Int Identifiant du rédacteur du billet
     * @param $pContent String Contenu du billet
     */
    public static function createNewPost($pAuthorId, $pContent){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();


//        $req = "INSERT INTO post ('author', 'content', 'created_date') VALUES (:author, :content, NOW())";
        $req = "INSERT INTO post (`author`, `content`, `created_date`) VALUES (:author, :content, NOW())";
        $requete = $db->prepare($req);
        $requete->bindValue(':author', $pAuthorId, PDO::PARAM_INT);
        $requete->bindValue(':content', $pContent, PDO::PARAM_STR);

        $requete->execute();
    }

    /**
     * @param $pPostId Int Identifiant du billet
     * @param $pContent String Contenu du billet
     */
    public static function update($pPostId, $pContent){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

//        $req = "INSERT INTO post ('author', 'content', 'created_date') VALUES (:author, :content, NOW())";
        $req = "UPDATE post SET `content`=:content,`created_date`= NOW() WHERE id = :postId";
        $requete = $db->prepare($req);
        $requete->bindValue(':postId', $pPostId, PDO::PARAM_INT);
        $requete->bindValue(':content', $pContent, PDO::PARAM_STR);

        $requete->execute();
    }

    /**
     * @param $pPostId Int Identifiant du billet
     */
    public static function deletePostById($pPostId){
//      $db CONTIENT L'INSTANCE DE CONNEXION À LA BASE DE DONNÉES
        $db = Db::getInstance();

        $req = "DELETE FROM post WHERE id = :postId";
        $requete = $db->prepare($req);
        $requete->bindValue(':postId', $pPostId, PDO::PARAM_INT);

        $requete->execute();
    }
}