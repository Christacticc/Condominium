<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Sagnimorte Conseils. Une équipe de professionnels à votre écoute au quotidien pour vous conseiller dans la bonne gestion de votre patrimoine">
    <meta name="keywords" content="Équipe, écoute, service, gestion, patrimoine">
    <title>L'équipe de SAGNIMORTE CONSEILS à votre écoute</title>
    <?php
include "includes/headlinks.php";
?>
</head>

<body class="equipe <?= null !==$_GET['a'] && $_GET['a'] == 'g' ? 'gestion' : 'conseils' ?>">
    <header class="container">
        <?php
include "includes/nav.php";
?>
    </header>

    <div class="container"></div>
    <!--separator-->

    <section class="main container">
        <div class="row">
            <div class="col-xs-6 col-sm-4 gris un-un">
                <div class="bloc-text">
                    <h3>Une équipe de<br>professionnels</h3>
                    <p>à votre écoute au quotidien<br>pour vous conseiller dans<br>a bonne gestion de<br>votre patrimoine</p>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 orange un-un">
            </div>
            <div class="col-xs-6 col-sm-4 gris portrait un-un">
                <figure>
                  <img src="public/images/photos/marc-sagnimorte_400x400.jpg" class="img-responsive" alt="Photo de Marc SAGNIMORTE" />
                    <figcaption><div class="bloc-text"><span class="name">Marc SAGNIMORTE</span><br>
                      Président de <br>
                      Sagnimorte Gestion<br>
                      <a href="espacecopro/index.php?contact=1" title="Contacter Marc SAGNIMORTE">Contact</a></div></figcaption>
                </figure>
            </div>
            <div class="col-xs-6 col-sm-4 green un-un">
            </div>
            <div class="col-xs-6 col-sm-4 gris portrait un-un">
                <figure>
                  <img src="public/images/photos/Annick_BELLEFOND_400x400.jpg" class="img-responsive" alt="Photo d'Annick BELLEFOND" />
                    <figcaption><div class="bloc-text"><span class="name">Annick BELLEFOND</span><br>
                      Gestionnaire syndic<br>
                      <a href="espacecopro/index.php?contact=1" title="Contacter Annick BELLEFOND">Contact</a></div></figcaption>
                </figure>
            </div>
            <div class="col-xs-6 col-sm-4 orange portrait un-un">
            </div>
            <div class="col-xs-6 col-sm-4 orange portrait un-un">
            </div>
            <div class="col-xs-6 col-sm-4 blue un-un">
            </div>
            <div class="col-xs-6 col-sm-4 green portrait un-un">
            </div>
        </div>
    </section> <!-- End .main.container-->
        <?php
include "includes/footer.php";
?>
</body>
</html>