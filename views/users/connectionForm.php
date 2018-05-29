
<h1>Connexion utilisateur</h1>
<form method="post" action="http://mini_blog.par/?controller=users&action=connect">
    <fieldset>
        <legend>J'ai déjà un compte membre</legend>
        <?php if(isset($_SESSION['errorMessage'])){?>
            <p style="color: red; font-weight: bold;"><?= $_SESSION['errorMessage']; ?>
        <?php } unset($_SESSION['errorMessage']); ?>
        <p>
            <label for="pseudo">Saisissez votre pseudo</label>
            <input type="text" name="pseudo" id="pseudo" />
        </p>
        <p>
            <label for="password">Saisissez votre mot de passe</label>
            <input type="password" name="password" id="password" />
        </p>
        <p>
            <input type="submit" name="submit" value="Se connecter" />
        </p>
    </fieldset>
</form>

<form method="post" action="http://mini_blog.par/?controller=users&action=create">
    <fieldset>
        <legend>Je veux m'inscrire</legend>
        <?php if(isset($_SESSION['confirmErrorMessage'])){?>
            <p style="color: red; font-weight: bold;"><?= $_SESSION['confirmErrorMessage']; ?>
        <?php } unset($_SESSION['confirmErrorMessage']); ?>
        <p>
            <label for="pseudo">Saisissez votre pseudo</label>
            <input type="text" name="pseudo" id="pseudo" />
        </p>
        <p>
            <label for="password">Saisissez votre mot de passe</label>
            <input type="password" name="password" id="password" />
        </p>
        <p>
            <label for="confirmPassword">Confirmez votre mot de passe</label>
            <input type="password" name="confirmPassword" id="confirmPassword" />
        </p>
        <p>
            <label for="email">Saisissez une adresse email valide</label>
            <input type="text" name="email" id="email" />
        </p>
        <p>
            <label for="tel">Saisissez un numéro de téléphone valide</label>
            <input type="text" name="tel" id="tel" />
        </p>
        <p>
            <label for="region">Région dans laquelle vous habitez : </label>
            <select name="region">
            <?php
                foreach ($regionsList as $oRegion){
                    echo "<option value = " . $oRegion->id .">" . $oRegion->name . "</option>";
                }
            ?>
            </select>
        </p>
        <p>
            <input type="submit" name="submit" value="Créer un compte" />
        </p>
    </fieldset>
</form>
