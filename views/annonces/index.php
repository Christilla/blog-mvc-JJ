<h1>
    <?php
        if(isset($_GET['action'])){
            switch(true) {

                case ($_GET['action'] == 'mesannonces'):
                    echo "Mes annonces";
                    break;
                case ($_GET['action'] == 'mesfavoris'):
                    echo "Mes annonces favorites";
                    break;
                default:
                case ($_GET['action'] == 'index'):
                    echo "Index du site d'annonces";
                    break;
            }
        }else{
            echo "Index du site d'annonces";
        }
    ?>
</h1>

<nav>
    <ul>
        <?php if(isset($_SESSION['user'])){ ?>
        <li><a href="?controller=annonces&action=annonceForm">Déposer une annonce</a></li>
        <?php } ?>
    </ul>
</nav>

<?php if(isset($categoriesList) && isset($regionsList)){ ?>
<h2>Critères de recherche</h2>
    <form id="annoncesSearch">
        <fieldset>
            <legend>Rechercher une petite annonce</legend>
            <p>
                <label for="categorie">Recherche par catégories :&nbsp;</label>
                <select name="categorie" id="categorie">
                    <?php
                    foreach ($categoriesList as $oCategorie){
                        echo "<option value = " . $oCategorie->id .">" . $oCategorie->name . "</option>";
                    }
                    ?>
                </select>
            </p>
            <p>
                <label for="region">Recherche par régions :&nbsp;</label>
                <select name="region" id="region">
                    <?php
                    foreach ($regionsList as $region){
                        echo "<option value = " . $region->id .">" . $region->name . "</option>";
                    }
                    ?>
                </select>
            </p>
        </fieldset>
    </form>
<?php } ?>

    <section id="annonces">
        <h2>Liste des annonces</h2>
        <?php foreach ($result as $oAnnonce) {?>
        <article>
            <h3><?= $oAnnonce->titre; ?></h3>
            <p>Annonce rédigée par <?= $oAnnonce->pseudoUser; ?></p>
            <?php
                if(!isset($_GET['action'])){
                    $_GET['action'] = 'index';
                }
                if($_GET['action'] == 'index' && $oAnnonce->idUser != $_SESSION['user']['id']) { ?>
                <p><a href="?controller=annonces&action=addfavorites&id=<?= $oAnnonce->id ?>" class="controllers" >Ajouter cette annonce à mes favoris</a></p>
            <?php }?>
            <p><img src="<?= 'http://mini_blog.par/'.$oAnnonce->cheminImage; ?>" /> </p>
            <ul>
                <li><?= "Catégorie : ".$oAnnonce->categorieName ?></li>
                <li><?= "Région de l'annonce : ".$oAnnonce->regionName ?></li>
                <li><?= "Prix de vente : ".$oAnnonce->prixDeVente. " €" ?></li>
            </ul>
            <p><?= $oAnnonce->description ?></p>
            <?php
            //  SUPPRESSION D'UNE ANNONCE SI LE USER EN EST PROPRIÉTAIRE
            if($oAnnonce->idUser == $_SESSION['user']['id']){?>
                <p><a href="?controller=annonces&action=confirmdelete&id=<?= $oAnnonce->id ?>" class="controllers" >Supprimer cette annonce</a></p>
                <?php
            }   //  ENDIF
            ?>
            <?php
            //  SUPPRESSION D'UNE ANNONCE DANS LES FAVORIS
            if(isset($_GET['action']) && $_GET['action'] == 'mesfavoris'){?>
                <p><a href="?controller=annonces&action=confirmdeletefav&id=<?= $oAnnonce->id ?>" class="controllers" >Supprimer cette annonce de mes favoris</a></p>
                <?php
            }   //  ENDIF
            ?>
        </article>
            <?php
                }  //  ENDFOREACH
            ?>
    </section>