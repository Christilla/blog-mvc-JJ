<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 07/05/18
 * Time: 09:38
 */



class Comments
{
    public $pId;
    public $pIdPost;
    public $pIdUser;
    public $pContent;
    public $pCreatedDate;
    public $pPseudoUser;

    /**
     * Comments constructor.
     * @param $pId Int Identifiant du commentaire
     * @param $pIdPost Int Identifiant du billet associé
     * @param $pIdUser Int Identifiant du rédactuer du billet
     * @param $pContent String Contenu du commentaire
     * @param $pCreatedDate DateTime Date de création du commentaire
     * @param null $pPseudoUser String Pseudo du rédacteur du commentaire
     */
    private function __construct($pId, $pIdPost, $pIdUser, $pContent, $pCreatedDate, $pPseudoUser = null){
        $this->pId = $pId;
        $this->pIdPost = $pIdPost;
        $this->pIdUser = $pIdUser;
        $this->pContent = $pContent;
        $this->pCreatedDate = $pCreatedDate;
        $this->pPseudoUser = $pPseudoUser;
    }

    /**
     * @param $pIdPost Int Identifiant du billet
     * @param $pIdUser Int Identifiant du rédacteur du commentaire
     * @param $pContent String Contenu du commentaire
     * @return Comments Objet Comments
     */
    public static function create($pIdPost, $pIdUser, $pContent){

        $db = Db::getInstance();
        $created_date = date('Y-m-d H:i:s');
        $req = "INSERT INTO comments (`id_post`, `id_user`, `content`, `created_date`) VALUES (:id_post, :id_user, :content, :created_date)";
        $requete = $db->prepare($req);
        $requete->bindValue(':id_post', $pIdPost, PDO::PARAM_INT);
        $requete->bindValue(':id_user', $pIdUser, PDO::PARAM_INT);
        $requete->bindValue(':content', $pContent, PDO::PARAM_STR);
        $requete->bindValue(':created_date', $created_date);

        $requete->execute();
        return new Comments($db->lastInsertId(), $pIdPost, $pIdUser, $pContent, $created_date);
    }

    /**
     * @param $pIdPost Int Identifiant du billet concerné
     * @return array Collection d'objets Comments
     */
    public static function getAllCommentsByIdPost($pIdPost){
        $list = [];

        $db = Db::getInstance();
        /*
         * SELECT
                u.pseudo pseudo,
                c.content content

            FROM comments c

            INNER JOIN users u

            ON c.id_user = u.id
         */
        $req = "SELECT 
                    c.*, 
                    u.pseudo pseudo
                FROM comments c
                INNER JOIN users u
                ON c.id_user = u.id
                WHERE c.id_post = :id_post
                ORDER BY c.created_date
                DESC";
        $requete = $db->prepare($req);
        $requete->bindValue(':id_post', $pIdPost, PDO::PARAM_INT);
        $requete->execute();

        foreach($requete->fetchAll() as $comment){
//          $list EST REMPLI AVEC DES OBJETS Comments
//            printr($comment);
            $list[] = new Comments($comment['id'], $comment['id_post'], $comment['id_user'], $comment['content'], $comment['created_date'], $comment['pseudo']);
        }
        $requete->closeCursor();
        return $list;
    }
}