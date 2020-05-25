<?php $title = 'Formulaire d\'identification'; ?>
<?php $bodyid = 'logginFormView'; ?>

<?php ob_start(); ?>
<div class="container">
    <div class="card mt-5" style="width:400px; margin-left: auto; margin-right: auto">
        <h1 class="h5 card-header">Identification</h1>
        <div class="card-body">
            <p><?php if (isset($msg)){ echo($msg);} ?></p>
            <form action="#" method="post"  class="needs-validation" novalidate>
                <div class="form-group">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" class="form-control" id="username" name="username" <?php if (isset($remember_user)){ echo('value="'.$remember_user.'"');} ?>  required>
                </div>
                <div class="form-group">
                    <label for="pwd">Mot de passe</label>
                    <input type="password" class="form-control"  id="pwd" name="pwd"  required>
                </div>
                <div class="custom-control custom-checkbox mb-3">
                    <input class="custom-control-input" type="checkbox" id="remember_user" name="remember_user" <?php if (isset($remember_user)){echo('checked');} ?>>
                    <label for="remember_user"   class="custom-control-label">Mémoriser mon nom d'utilisateur</label>
                </div>
                <div class="text-right">
                    <input type="hidden" id="recaptchaResponse" name="recaptcha-response">
                    <button type="submit" class="btn btn-primary">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
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