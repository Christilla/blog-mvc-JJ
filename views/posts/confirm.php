<?php
if(isset($post)){
    $id = $post['id'];
    $content = $post['content'];
    $action = ["get" => "update", "button" => "Modifier le billet"];
}
?>
<h1>Suppression d'un billet</h1>
<p>Êtes-vous sur de vouloir supprimer le billet dont le contenu est le suivant :</p>
<p><?= $content ?></p>
<p>
    <a href="?controller=post&action=index">Annuler</a>
    <a href="?controller=post&action=delete&id=<?= $id; ?>">Confirmer</a>
</p>

