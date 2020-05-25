<?php $title = 'Nous contacter' ?>
<?php $bodyid = 'contactForm'; ?>

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
                    <h1>Nous contacter</h1>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6 green trois-un-sm formulaire">
                <div class="bloc-text">
                    <h5>Contactez-nous par le formulaire ci-dessous, ou bien&nbsp;:</h5>
                    <ul>
                        <li>Par e-mail&nbsp;: <a href="mailto:gestion@sagnimortegestion.fr?subject=Contact%20site%20internet" target="_blank">gestion@sagnimortegestion.fr</a></li>
                        <li>à notre adresse postale&nbsp;: 12 place Mal LYAUTEY<br>69006 LYON</li>
                        <li>Par téléphone&nbsp;: <strong>Tél. 04 78 52 86 65 - Fax. 09 55 72 86 65</strong></li>
                    </ul>
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
                 <div id="contact-form" class="bloc-text">
                    <form id="contact-form" class="form-horizontal" style="padding: 0" action="" method="post"  autocomplete="off">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-3" style="padding-right: 1em;" for="forname">Votre prénom*&nbsp;:</label>
                            <div class="col-sm-9" style="padding: 0;">
                                <input type="text" class="form-control" id="forname" name="forname" required>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-3" style="padding-right: 1em;" for="name">Votre nom*&nbsp;:</label>
                            <div class="col-sm-9" style="padding: 0;">
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-3" style="padding-right: 1em; line-height: .9em" for="email">Votre adresse e-mail*&nbsp;:</label>
                            <div class="col-sm-9" style="padding: 0;">
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-3" style="padding-right: 1em; line-height: .9em" for="condo">Votre copropriété<?= isset($fgtpw) ? '*'  : '&nbsp;:<br><span class="small">(si concerné)&nbsp;&nbsp;</span>' ?></label>
                            <div class="col-sm-9" style="padding: 0;">
                                <input type="text" class="form-control" id="condo" name="condo"<?= isset($fgtpw) ? ' required' : '' ?>>
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-3" style="padding-right: 1em; line-height: .9em" for="subject">Le sujet de votre message&nbsp;:</label>
                            <div class="col-sm-9" style="padding: 0;">
                                <input type="text" class="form-control" id="subject" name="subject" value="<?= isset($fgtpw) ? 'Mot de passe oublié' : '' ?>">
                            </div>
                        </div>
                        <div class="form-group form-group-sm">
                            <label class="control-label col-sm-3" style="padding-right: 1em; line-height: .9em" for="name">Votre message*&nbsp;:</label>
                            <div class="col-sm-9" style="padding: 0;">
                                <textarea class="form-control" rows="5" id="message" name="message" required><?= isset($fgtpw) ? 'Bonjour,' . "\n\n" . 'Veuillez me renvoyer le mot de passe de ma copropriété.' . "\n\n" . 'Merci' : '' ?></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 text-right">
                            <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
                            <button type="submit" class="btn btn-sag btn-sm btn-success">Envoyer</button>
                        </div>
                    </form>
                </div>
                <div id="contact-merci" class="bloc-text invisible">
                    <h4>Merci,</h4>
                    <p>Nous avons bien reçu votre message et nous vous répondrons dans les meilleurs délais.</p>
                    <p>L'équipe Sagnimorte Conseils</p>
                </div>

            </div>
        </div>
    </section> <!-- End .main.container-->
    <script src="https://www.google.com/recaptcha/api.js?render=6LflGu8UAAAAAOvinOLeUDk7ZqEo5qvERcf-vPU8"></script>
    <script>
    grecaptcha.ready(function() {
        grecaptcha.execute('6LflGu8UAAAAAOvinOLeUDk7ZqEo5qvERcf-vPU8', {action: 'homepage'}).then(function(token) { 
            document.getElementById('recaptchaResponse').value = token
        });
    });
    </script>
<?php
$content = ob_get_clean();
require('template.php');
?>