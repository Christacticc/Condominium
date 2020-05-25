<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Sagnimorte Conseils. Un conseil de valeur pour la maîtrise d'ouvrage et les promoteurs">
    <meta name="keywords" content="Équipe, écoute, service, gestion, patrimoine">
    <title>SAGNIMORTE CONSEILS - QUI NOUS SOMMES</title>
    <?php
include "includes/headlinks.php";
?>
</head>

<body class="basic <?= null !==$_GET['a'] && $_GET['a'] == 'g' ? 'gestion' : 'conseils' ?>" id="mediation">
    <header class="container">
        <?php
include "includes/nav.php";
?>
    </header>

    <div class="container"></div>
    <!--separator-->

    <section class="main container">
        <div class="row">
            <div class="col-xs-9 col-xs-offset-3"><h1>Qui nous sommes</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-3">
                <div class="row">
                    <div class="col-xs-12 photo un-un paire-8">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 green un-un">
                        
                    </div>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="bloc-text">
                    <h2>Sagnimorte Conseils a été créée en 2005 avec le projet d’accompagner l’intégration de nouveaux produits et de nouveaux usages dans le bâtiment collectif.</h2>
                    <p> Nous avons développé notre activité de conseil avec une forte implication dans les filières du bâtiment et de l’éco-construction. L’entreprise est adhérente du Cluster Eco-bâtiment que Marc Sagnimorte a présidé de 2011 à 2014.</p>
                    <p>Nous accompagnons les maîtres d’ouvrages privés ou publics, ainsi que les industriels fournisseurs de produits ou services aux immeubles dans la pertinence de leurs choix techniques.</p>
                    <p>Notre expertise en administration de biens nous a conduit à développer le pôle gestion sous la marque SAGNIMORTE GESTION, afin de faire bénéficier les utilisateurs de notre savoir-faire. Notre parc géré à ce jour s’étend sur toute la Métropole Lyonnaise, en habitation, en commercial ou en industriel.<br>
                        L’entreprise est adhérente à l’UNIS Lyon-Rhône.</p>
                    <p>À ce jour, Sagnimorte Conseils compte 7 collaborateurs, 2 500 lots en copropriété et 300 lots en gestion locative.</p>
                    <p><strong>Ils nous ont fait confiance&nbsp;:</strong></p>
                    <p>Vinci Immobilier, Nacarat, Bouwfons Marignan Immobilier…<br>
                        SFR, OECA smart Building, Intratone…</p>
                </div>
            </div>
        </div>
    </section> <!-- End .main.container-->
        <?php
include "includes/footer.php";
?>
</body>
</html>