<p>Voici le détail du post </p>

    <p>
        <?= $post['author'] . ' : ' . $post['content'] . ' créé le ' . $post['created_date'];?>
    </p>

<?php if(isset($_SESSION['user'])){ ?>
    <form method="post" action="?controller=comments&action=create">
        <p><label for="comment">Insérer un commentaire</label> </p>
        <p><input type="text" name="comment" placeholder="Votre commentaire" /></p>
        <p>
            <input type="hidden" name="id_post" value="<?= $post['id'] ?>">
            <input type="hidden" name="id_user" value="<?= $_SESSION['user']['id'] ?>">
        </p>
        <p><button type="submit">Commenter</button> </p>
    </form>
<?php } ?>

<?php
    foreach ($comments as $comment){
?>
        <p><?= $comment->pPseudoUser; ?> a écrit ce commentaire le <?= $comment->pCreatedDate ;?></p>
        <p><?= $comment->pContent; ?></p>
<?php
    }
?>
