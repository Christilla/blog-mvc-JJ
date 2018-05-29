<?php
    if(isset($post)){
        $authorId = $post['author'];
        $content = $post['content'];
        $action = ["get" => "update", "button" => "Modifier le billet"];
    }else{
        $authorId = 1;
        $content = "";
        $action = ["get" => "create", "button" => "Créer le billet"];
    }


?>
<p>Ajouter un billet</p>
<form method="post" action="http://mini_blog.par/?controller=post&action=<?= $action["get"]; ?>&id=<?= (int)$_GET["id"]; ?>">
<!--    <input type="hidden" name="authorId" value="<?= $authorId; ?>" />    -->
    <textarea name="content"><?= $content; ?></textarea>
    <input type="submit" name="submit" value="<?= $action["button"]; ?>" />
</form>
