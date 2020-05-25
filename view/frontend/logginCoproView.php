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
        <div class="row">
            <div class="col-xs-12 col-sm-2 orange un-un-sm">
                <div class="bloc-text">
                    <h1>Mon espace copropriété</h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 blanc trois-un-sm formulaire">
                <div style="padding: 1em">
                    <form class="form-horizontal bloc-text" style="padding: 0" action="" method="post"  autocomplete="off">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4" style="padding-right: 1em;" for="member_name">Votre copropriété&nbsp;:</label>
                            <div class="col-sm-8" style="padding: 0;">
                                <input type="text" list="member_feed" class="form-control" placeholder="Entrez le nom, de votre copropriété" id="member_name" name="member_name" <?php if (isset($remember_member)){ echo('value="'.$remember_member.'"');} ?> autocomplete="off" required>
                                <select multiple class="form-control" size="0" style="padding: 0;"  id="member_feed"></select>

                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-4" style="padding-right: 1em;" for="pwd">Mot de passe&nbsp;:</label>
                            <div class="col-sm-4" style="padding: 0;">
                                <input type="password" class="form-control" id="pwd" placeholder="Entrez votre mot de passe" name="pwd" required>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-7 col-sm-offset-1">
                                <div class="checkbox">
                                    <label><input type="checkbox" id="remember_member" name="remember_member" <?php if (isset($remember_member)){echo('checked');} ?> >&nbsp;Mémoriser ma coproriété</label>
                                </div>
                                <div class="forgotten"><a href="index.php?password=1">Mot de passe oublié ?</a></div>
                            </div>
                            <div class="col-xs-4 text-right">
                                <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
                               <button type="submit" class="btn btn-sag btn-sm btn-success">Envoyer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4" id="message_container" style="padding: 30px;">
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
        <div class="row">
            <div class="col-xs-3 col-sm-2">
                <div class="row">
                    <div class="col-xs-12 green un-un">
                        <div class="bloc-text">
                            <h2>Toute votre documentation de copro en téléchargement</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 blanc un-deux">
                        <div class="bloc-text">
                            <h2>Participez en webcam à votre assemblée de copro</h2>
                            <img alt="" src="../../public/images/icones/webinar_300x210.jpg" class="img-responsive">
                            <p class="h2">WEB AG Copro</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-9 col-sm-8 texte">
                <div class="bloc-text">
                    <p><strong>Accès aux données de votre immeuble&nbsp;:</strong></p>
                    <ul>
                        <li>Documentation juridique, documentation comptable et documentation technique,</li>
                        <li>l'agenda de votre copropriété,</li>
                        <li>la programmation de la prochaine assemblée générale et les informations pour y assister en présenciel ou en visio.</li>
                    </ul>
                </div>
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