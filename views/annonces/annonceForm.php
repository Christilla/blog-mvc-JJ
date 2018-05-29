

<h1>Déposer une annonce</h1>

<form method="post" action="<?= '?controller=annonces&action=create' ?>" enctype="multipart/form-data">
    <fieldset>
        <legend>Description de votre annonce (tous ces champs sont obligatoires)</legend>
        <?php
            if (isset($_SESSION['annonceFormErrorMessage'])){
        ?>
                <p style="font-weight: bold; color: red;">
                    <?= $_SESSION['annonceFormErrorMessage'] ?>
                </p>
         <?php
                unset($_SESSION['annonceFormErrorMessage']);
            }
        ?>
        <p>
            <label for="titre">Titre de votre annonce : </label><br />
            <input type="text" name="titre" id="titre" />
        </p>
        <p>
            <label for="categorie">Dans quelle catégorie rangez-vous votre annonce ?</label><br />
            <select name="categorie" id="categorie">
                <option value="0" selected="selected">Faites un choix</option>
                <?php
                foreach ($categoriesList as $categorie){
                    echo "<option value = " . $categorie->id .">" . $categorie->name . "</option>";
                }
                ?>
            </select>
        </p>
        <p>
            <label for="description">Description de votre annonce : </label><br />
            <textarea id="description" name="description"></textarea>
        </p>
        <p>
            <label for="prix">Prix de vente : </label><br />
            <input type="text" name="prix" id="prix" />
        </p>
     </fieldset>
     <fieldset>
        <legend>Fichiers images à joindre à votre annonce</legend>
        <p>
            <label for="image_1">Fichier image N° 1  :</label><br />
            <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
            <input type="file" name="image_1" id="image_1" />
        </p>
        <p>
            <label for="image_2">Fichier image N° 2  :</label><br />
            <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
            <input type="file" name="image_2" id="image_2" />
        </p>
        <p>
            <label for="image_3">Fichier image N° 3  :</label><br />
            <input type="hidden" name="MAX_FILE_SIZE" value="50000" />
            <input type="file" name="image_3" id="image_3" />
        </p>
     </fieldset>
    <input type="submit" name="submit" value="Envoyer" />
</form>