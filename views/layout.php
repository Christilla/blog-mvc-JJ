<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Mini blog</title>
        <link rel="stylesheet" type="text/css" href="styles/styles.css" media="all"/>
    </head>
    <body>
        <header>
            <?php if(isset($_SESSION['user'])){ ?>
            <p>Vous êtes connecté avec le compte de <span id="user"><?= $_SESSION['user']['pseudo']; ?></span> </p>
            <?php } ?>
            <nav>
                <ul>
                    <li><a href="http://mini_blog.par">Home</a> </li>
                    <li><a href="?controller=post&action=index">Blog</a> </li>
                    <li><a href="?controller=annonces&action=index">Annonces</a> </li>
                    <?php if(!isset($_SESSION['user'])){ ?>
                    <li><a href="?controller=users&action=connectionForm">Connexion</a> </li>
                    <?php } ?>
                    <?php if(isset($_SESSION['user'])){ ?>
                        <li><a href="?controller=users&action=profil">Mon profil</a> </li>
                        <li><a href="?controller=users&action=deconnexion">Déconnexion</a> </li>
                    <?php } ?>
                </ul>
            </nav>
        </header>
        <section id="content">
            <?php require_once('router.php');?>
        </section>
    </body>
</html>