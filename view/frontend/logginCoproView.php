<?php $title = 'Accès à votre espace copropriétaire' ?>
<?php $bodyid = 'logginCoproView'; ?>

<?php ob_start(); ?>



<header class="container">
<?php
include "nav.php";
?>
</header>

<div class="container"></div>
<!--separator-->

<section class="main container">
    <h1 class="h3">Mon espace copro</h1>
    <p>Commencez à taper le <strong>nom</strong> ou <strong>un élément de l'adresse</strong> de votre copropriété, puis choisissez-la dans la liste qui s'affiche.</p>
    <form action="" method="post">
        <div class="form-row">
            <div class="col-sm-4">
                <div class="form-group form-group-sm">
                    <label class="control-label" for="member_name">Votre copropriété&nbsp;:</label>
                    <input type="text" class="form-control" list="member_feed" placeholder="Entrez le nom, la ville ou l'adresse de votre copropriété" id="member_name" name="member_name" <?php if (isset($remember_member)){ echo('value="'.$remember_member.'"');} ?> required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group form-group-sm">
                    <label class="member_feed" for="member_name">Choisissez&nbsp;:</label>
                    <select multiple class="form-control" size="0" style="padding: 0;"  id="member_feed"></select>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group form-group-sm">
                    <label class="control-label" for="pwd">Mot de passe&nbsp;:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Entrez votre mot de passe" name="pwd" required>
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label><input type="checkbox" id="remember_member" name="remember_member" <?php if (isset($remember_member)){echo('checked');} ?> >&nbsp;Mémoriser ma coproriété sur cet appareil</label>
            </div>
            <div class="col">
                <a href="index.php?password=1">Mot de passe oublié ?</a>
            </div>
            <div class="col">
                <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
                <button type="submit" class="btn btn-success">Envoyer</button>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col" id="message_container" style="padding: 30px;">
        <?php
        if (isset($msg))
        {
        ?>
        <p id="message"><?= isset($msg) ? $msg : '' ?></p>
        <?php                
        }
        ?>                
        </div>
    </div>
    <h2 class="h3">Connectez-vous à votre Espace Copro pour&nbsp;:</h2>
    <div class="row">
        <div class="col-sm-6">
            <h5>Accéder aux données de votre immeuble&nbsp;:</h5>
            <p>Toute votre documentation de copro en téléchargement&nbsp;</p>
            <ul>
                <li>Documentation juridique, documentation comptable et documentation technique,</li>
                <li>l'agenda de votre copropriété,</li>
                <li>la programmation de la prochaine assemblée générale et les informations pour y assister en présenciel ou en visio.</li>
            </ul>
        </div>
        <div class="col-sm-6">
            <h5>Participer en webcam à votre assemblée de copro</h5>
        </div>
    </div>
</section> <!-- End .main.container-->
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