<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= $title ?></title>
		<!-- Modern browsers & Devices -->
		<link rel="icon" type="image/png" href="../favicon_32x32.png" sizes="32x32">
		<link rel="icon" type="image/png" href="../favicon_48x48.png" sizes="48x48">
		<link rel="icon" type="image/png" href="../favicon_64x64.png" sizes="64x64">
		<link rel="icon" type="image/png" href="../favicon_96x96.png" sizes="96x96">
		<link rel="icon" type="image/png" href="../favicon_128x128.png" sizes="128x128">
		<link rel="icon" type="image/png" href="../favicon_196x196.png" sizes="196x196">

		<!-- iOS & other mobile devices -->
		<link rel="apple-touch-icon" sizes="76x76" href="../favicon_76x76.png">
		<link rel="apple-touch-icon" sizes="120x120" href="../favicon_120x120.png">
		<link rel="apple-touch-icon" sizes="152x152" href="../favicon_152x152.png">
		<link rel="apple-touch-icon" sizes="167x167" href="../favicon_167x167.png">
		<link rel="apple-touch-icon" sizes="180x180" href="../favicon_180x180.png">

		<!-- Windows Tiles (optionally omitted and replaced with browserconfig.xml in root directory) -->
		<!--<meta name="msapplication-TileColor" content="#A0C20B" />
		<meta name="application-name" content="Sagnimorte Conseils" />
		<meta name="msapplication-squ are70x70logo" content="tile-small.png" />
		<meta name="msapplication-square150x150logo" content="tile-medium.png" />
		<meta name="msapplication-wide310x150logo" content="tile-wide.png" />
		<meta name="msapplication-square310x310logo" content="tile-large.png" />    
		-->
        <link rel="stylesheet" href="../vendor/bootstrap/css/bootstrap-4.4.1.css">
        <link rel="stylesheet" href="../public/css/custom.css">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet">
<!--        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
        <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">

    </head>
    <body id="<?= $bodyid ?>">
        <?= $content ?>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../public/js/ajaxGet.js"></script>
    <script src="../public/js/ajaxPost.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script> <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../vendor/bootstrap/js/bootstrap-4.4.1.js"></script>
    <script src="https://kit.fontawesome.com/80fb2356ba.js" crossorigin="anonymous"></script>
    <script src="../public/js/espacecopro.js"></script>
    </body>
</html>