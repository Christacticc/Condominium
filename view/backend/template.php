<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
        <!-- Bootstrap -->
        <link href="../public/css/admin.css" rel="stylesheet">
        <link href="../vendor/bootstrap/css/bootstrap-4.4.1.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<?php
if ($bodyid == 'documentsAdd') {
?>
        <link href="../vendor/dropzone-5.7.0/dist/dropzone.css" rel="stylesheet">
        <link href="../public/css/dropzoneCustom.css" rel="stylesheet">
        <script src="../vendor/dropzone-5.7.0/dist/dropzone.js"></script>
        <script>
            Dropzone.autoDiscover = false;
        </script>
<?php        
}
?>            
    </head>
    <body id="<?= $bodyid ?>">
<?php
if (isset($_SESSION['user'])) // Si la session perso existe, on restaure l'objet.
{    
?>
        <!-- body code goes here -->
        <div class="container top-buttons py-1">
			<div class="row">
				<div class="col-sm-10">
					<span class="text-info small">&nbsp;<?= $user_name ?>&nbsp;</span>
					<a href="?deconnection=1" class="btn btn-sm btn-info" style="line-height: 1">Déconnexion</a>
<?php
    if ($_SESSION['user'] == 1 && $bodyid != 'admin')
    {
?>        
		            <a href="?admin=1" class="btn btn-sm btn-dark" style="line-height: 1">Administration</a>
<?php        
    }
?>    
		            <span class="text-info small">&nbsp;Le jeu de démonstration est réinitialisé chaque heure à l'heure et 25 minutes.</span>
				</div>
<?php
    if ($bodyid == 'condominiumView')
	{
?>

				<div class="col-sm-2 text-right">
                    <a href="../espacecopro/" class="btn btn-sm btn-info" style="line-height: 1" target="_blank"><i class="fas fa-external-link-square-alt"></i>&nbsp;Site public</a>
				</div>
<?php		
	}
 ?>
			</div>
		</div>
<?php
}
?>
        <?= $content ?>
<?php
if ($bodyid == 'documentsAdd') {
?>
        <script src="../public/js/dropzoneCustom.js"></script> 
<?php        
}
?>            
        <script src="../public/js/ajaxGet.js"></script>
        <script src="../public/js/ajaxPost.js"></script>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
        <script src="../vendor/bootstrap/js/jquery-3.4.1.min.js"></script>

        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="../vendor/bootstrap/js/popper.min.js"></script> 
        <script src="../vendor/bootstrap/js/bootstrap-4.4.1.js"></script>
        <script src="https://kit.fontawesome.com/80fb2356ba.js" crossorigin="anonymous"></script>        
        <script src="../public/js/form.js"></script>
    </body>
</html>