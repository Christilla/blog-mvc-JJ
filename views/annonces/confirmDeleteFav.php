<h1>Confirmation de suppression</h1>

<p>Vous souhaitez supprimer l'annonce n° <?= $_GET['id'] ?> de vos favoris</p>
<p>Confimez-vous cette suppression :
    <a href="?controller=annonces&action=deletefav&id=<?= $_GET['id'] ?>" class="controllers">OUI</a>
    <a href="?controller=annonces&action=mesfavoris" class="controllers">ANNULER</a>
</p>
