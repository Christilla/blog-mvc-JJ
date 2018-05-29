
<?php if(isset($_SESSION['user'])){ ?>
    <nav>
        <ul>
            <li><a href="?controller=post&action=newPost">Nouveau post</a> </li>
        </ul>
    </nav>
<?php } ?>
<p>Voici une liste de tout les posts</p>

<?php foreach($posts as $post){ ?>
    <p>Billet écrit par : <?= $post->pPseudo ;?></p>
    <p><?= htmlentities($post->content) ;?></p>
    <p>
        <a href="?controller=post&action=show&id=<?= $post->id; ?>">Voir</a>
        <?php if(isset($_SESSION['user']) && $post->author == $_SESSION['user']['id']){ ?>
            <a href="?controller=post&action=newPost&id=<?= $post->id; ?>">Modifier</a>
            <a href="?controller=post&action=confirm&id=<?= $post->id; ?>">Supprimer</a>
        <?php } ?>
    </p>
<?php }?>