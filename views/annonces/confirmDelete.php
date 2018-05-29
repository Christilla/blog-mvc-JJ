<h1>Confirmation de suppression</h1>

<p>Vous souhaitez supprimer l'annonce n° <?= $_GET['id'] ?></p>
<p>Confimez-vous cette suppression :
    <a href="?controller=annonces&action=delete&id=<?= $_GET['id'] ?>" class="controllers">OUI</a>
    <a href="?controller=annonces&action=mesannonces" class="controllers">ANNULER</a>
</p>
