<?php $title = 'Accès à votre espace copropriétaire' ?>
<?php $bodyid = 'logginCoproView'; ?>
<?php ob_start(); ?>
<header class="container">
<?php
include "nav.php";
?>
</header>
<div class="container"></div>
<section class="main container">
    <h1 class="display-1">Mon espace copro</h1>
    <form action="" method="post" class="card mb-3">
        <div class="card-header">Commencez à taper le <strong>nom</strong> ou <strong>un élément de l'adresse</strong> de votre copropriété, puis choisissez-la dans la liste qui s'affiche.</div>
        <div class="card-body">
            <div class="form-row">
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="member_name">Votre copropriété&nbsp;:</label>
                        <input type="text" class="form-control" list="member_feed" placeholder="Entrez le nom, la ville ou l'adresse de votre copropriété" id="member_name" name="member_name" <?php if (isset($remember_member)){ echo('value="'.$remember_member.'"');} ?> required>
                    </div>
                    <label><input type="checkbox" id="remember_member" name="remember_member" <?php if (isset($remember_member)){echo('checked');} ?> >&nbsp;Mémoriser ma coproriété sur cet appareil</label>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="member_feed" for="member_name">Choisissez&nbsp;:</label>
                        <select multiple class="form-control" size="0" style="padding: 0;"  id="member_feed"></select>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="pwd">Mot de passe&nbsp;: (0000)</label>
                        <input type="password" class="form-control" id="pwd" placeholder="Entrez votre mot de passe" name="pwd" required>
                    </div>
                    <a href="#">Mot de passe oublié ?</a>
                </div>
            </div>
            <div class="form-row">
                <div class="d-none d-sm-block col-sm-2">
                    <img class="img-fluid" src="../public/images/illustrations/quartier_400x365.png" alt="mon quartier">
                </div>
                <div class="col-sm-6" id="message_container">
                <?php
                if (isset($msg))
                {
                ?>
                <p id="message"><?= isset($msg) ? $msg : '' ?></p>
                <?php                
                }
                ?>                
                </div>
                <div class="col-sm-4 pt-sm-2 pt-md-3 pt-lg-5 text-center">
                    <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
                    <button type="submit" class="btn btn-success"><span class="material-icons">login</span>Entrer</button>
                </div>
            </div>
        </div>
    </form>
    <p class="super font-italic">Connectez-vous à votre Espace Copro&#133;</p>
    <div class="row">
        <div class="col-md-4">
            <p class="super font-italic">pour télécharger votre documentation de copropriété,</p>
            <img style="display:block; width:60%; margin: auto" src="../public/images/illustrations/doc_400x349.png" alt="">
        </div>
        <div class="col-md-8">
            <div class="card-deck">
                <div class="card">
                    <div class="card-body">
                        <p class="lead">Documentation juridique</p>
                    </div>
                    <img class="card-img-bottom" src="../public/images/illustrations/legal_400x308.png" alt="">
                </div>                
                <div class="card">
                     <div class="card-body">
                        <p class="lead">Documentation comptable</p>
                    </div>
                   <img class="card-img-bottom" src="../public/images/illustrations/calc_400x400.png" alt="">
                </div>                
                <div class="card">
                    <div class="card-body">
                        <p class="lead">Documentation technique</p>
                    </div>
                    <img class="card-img-bottom" src="../public/images/illustrations/technique_400x315.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="col-sm-6">
            <p class="super font-italic">pour consulter l'agenda de votre copropriété.</p>
            <img style="display:block; width:60%; margin: auto" src="../public/images/illustrations/calendar400x400.png" alt="">
        </div>
        <div class="col-sm-6"> 
            <div class="card">
                <div class="card-body">
                    <p class="lead">Préparer la prochaine assemblée générale, et trouver les informations pour y assister en présenciel ou en visio.</p>
                    <img class="card-img-bottom" src="../public/images/illustrations/home-office-video-conference_400x277.png" alt="">
                </div>
            </div>
        </div>
    </div>
</section> <!-- End .main.container-->
<br><br>
<script src="https://www.google.com/recaptcha/api.js?render=6LdC--4UAAAAAIur9QMW9p_DHet-7gQ7LuZBEq5X"></script>
<script>
grecaptcha.ready(function() {
    grecaptcha.execute('6LdC--4UAAAAAIur9QMW9p_DHet-7gQ7LuZBEq5X', {action: 'homepage'}).then(function(token) { 
        document.getElementById('recaptchaResponse').value = token
    });
});
</script>
<?php
$content = ob_get_clean();
require('template.php');
?>