<?php
/**
 * Created by PhpStorm.
 * User: padbrain
 * Date: 03/05/18
 * Time: 13:42
 */
class Users{
    public $id;
    public $pseudo;
    public $password;
    public $pEmail;
    public $pRoleId;
    public $pCreatedDate;
    public $pRole;
    public $telephone;
    public $regionId;

    /**
     * Users constructor.
     * @param $pId
     * @param $pPseudo
     * @param $pPassword
     * @param $pEmail
     * @param $pRoleId
     * @param $pRole
     * @param $pCreatedDate
     * @param $pTelephone
     * @param $pRegionId
     */
    function __construct($pId, $pPseudo, $pPassword, $pEmail, $pRoleId, $pRole, $pCreatedDate, $pTelephone, $pRegionId){
        $this->id = $pId;
        $this->pseudo = $pPseudo;
        $this->password = $pPassword;
        $this->email = $pEmail;
        $this->roleId = $pRoleId;
        $this->role = $pRole;
        $this->createdDate = $pCreatedDate;
        $this->telephone = $pTelephone;
        $this->regionId = $pRegionId;
    }

    /**
     * @param $pPseudo String Pseudo de l'utilisateur
     * @param $pPassword String Password de l'utilisateur
     * @return Users Objet Users
     */
    public static function getUser($pPseudo, $pPassword){

        $db = Db::getInstance();

        $requete = "SELECT users.*, r.short_designation role FROM users INNER JOIN roles r ON r.id = users.role_id WHERE (pseudo = :pseudo) AND (password = :password)";
        $req = $db->prepare($requete);
        $req->bindValue(':pseudo', $pPseudo);
        $req->bindValue(':password', $pPassword);

        $req->execute();

        $returnValue = $req->fetch();
        $req->closeCursor();

        return new Users($returnValue['id'], $returnValue['pseudo'], $returnValue['password'], $returnValue['email'], $returnValue['role_id'], $returnValue['role'], $returnValue['created_date'], $returnValue['telephone'], $returnValue['region_id']);
    }

    /**
     * @param $pPost Array Données issues d'un formulaire
     * @return string Code d'activation du profil utilisateur
     */
    public static function createUser($pPost){
        $pPseudo = $pPost['pseudo'];
        $pPassword = $pPost['password'];
        $email = $pPost['email'];
        $tel = $pPost['tel'];
        $regionId = $pPost['region'];

        $db = Db::getInstance();

        $requete = "INSERT INTO `users`(`pseudo`, `password`, `email`, `role_id`, `telephone`, `region_id`) VALUES (:pseudo, :password, :email, (SELECT `id` FROM `roles` WHERE `short_designation` = 'member' ), :tel, :region)";
        $req = $db->prepare($requete);
        $req->bindValue(':pseudo', $pPseudo, PDO::PARAM_STR);
        $req->bindValue(':password', $pPassword, PDO::PARAM_STR);
        $req->bindValue(':email', $email, PDO::PARAM_STR);
        $req->bindValue(':tel', $tel, PDO::PARAM_STR);
        $req->bindValue(':region', $regionId, PDO::PARAM_INT);

        $req->execute();
        $activationCode =  sha1($pPseudo.$pPassword.$db->lastInsertId());


        $requete = "UPDATE `users` SET `activation`= :activationCode WHERE id = (SELECT id WHERE `pseudo` = :pseudo AND `password` = :password)";
        $req = $db->prepare($requete);
        $req->bindValue(':activationCode', $activationCode);
        $req->bindValue(':pseudo', $pPseudo);
        $req->bindValue(':password', $pPassword);

        $req->execute();

        return $activationCode;

    }

    /**
     * @param $pCode Code d'activation du profil utilisateur
     */
    public static function activation($pCode){
        $db = Db::getInstance();

        $requete = "UPDATE `users` SET `created_date` = NOW(), `activation`= NULL WHERE `activation` = :code";
        $req = $db->prepare($requete);
        $req->bindValue(':code', $pCode);

        $req->execute();
    }

    /**
     * @param $pId Int Identifiant de l'utilisateur
     * @return Users Objet Users
     */
    public static function getUserById($pId){
        $db = Db::getInstance();

//        $requete = "SELECT users.*, r.short_designation role FROM users INNER JOIN roles r ON r.id = users.role_id WHERE (pseudo = :pseudo) AND (password = :password)";
        $requete = "SELECT users.*, r.short_designation role  FROM users INNER JOIN roles r ON r.id = users.role_id  WHERE users.id = ".$pId;
        $req = $db->query($requete);

//        $req->execute();

        $returnValue = $req->fetch();
        $req->closeCursor();

        return new Users($returnValue['id'], $returnValue['pseudo'], $returnValue['password'], $returnValue['email'], $returnValue['role_id'], $returnValue['role'], $returnValue['created_date'], $returnValue['telephone'], $returnValue['region_id']);
    }

}