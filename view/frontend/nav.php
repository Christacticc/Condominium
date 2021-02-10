<nav class="navbar navbar-expand-lg" style="margin:1em 0;">
    <a class="navbar-brand" href="#"><img alt="Logo Condominium" src="../public/images/logos/LogoCondominium_290x128.png" style="width:100%"></a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div id="navbar" class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Entreprise</a>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="#">Qui nous sommes</a>
                <a class="dropdown-item" href="#">Équipe</a>
                <a class="dropdown-item" href="#">Vidéos</a>
                <a class="dropdown-item" href="#">Contact</a>
                <a class="dropdown-item" href="#">Témoignages</a>
                </div>
            </li>
            <li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Gestion</a>
                <div class="dropdown-menu">
                <a class="dropdown-item" href="#">La gestion</a>
                <a class="dropdown-item" href="#">Nos immeubles</a>
                <a class="dropdown-item" href="#">Médiation</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
        </ul>
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">  
                <?= isset($_SESSION['condo']) ? '<form action="index.php" method="post" class="form-inline"><button type="submit" id="deconnection" class="btn btn-link" name="deconnection">Déconnexion</button></form>' : '<a class="nav-link" href="index.php">Votre espace copro</a>' ?>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
</nav>