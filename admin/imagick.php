<?php
// Script de conversion de fichiers pdf en images
// 1) Pour afficher seulement la 1ere page :
/*$im = new Imagick();
$im->setResolution(144,144);
$im->readImage($_GET['file'] . '[0]');
$im->setImageFormat("jpg");
header("Content-Type: image/jpg");
echo $im;
*/

// 2) pour convertir un pdf multipages en gif animé. Limité à 10 pages pour limiter le temps de traitement.
header("Content-Type: image/gif");
$anim = new Imagick();
$anim->setFormat("gif");
//$countimg = new Imagick();
//$countimg->readImage($_GET['file']); Trop long de lire un long pdf, la structure try catch est plus rapide pour ne lire que les 10 premières pages sans connaître le nombre de pages.
//$count = $countimg->getNumberImages();
//echo($count . '<br>');
//if ($count > 10) {$count = 10;}
//for ($i = 0; $i <= $count - 1; $i++) {
for ($i = 0; $i <= 9; $i++) {
    $frame = new Imagick();
    try {
    $frame->readImage($_GET['file'] . '[' . $i .']');
    $frame->setImageFormat("gif");
    $frame->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE ); // On supprimer la transparence pour que les pages ne s'affichent pas les unes sur les autres.
    $frame->setResolution(144,144);
    $frame->setImageDelay(100); // 100 tiks = 1s
    $frame->minifyImage(); // Taille divisée par 2
    $anim->addImage($frame);
//        echo('Oui' . '<br>');
    }
    catch (Exception $e) {
//    echo('Non' . '<br>');
        $i=10;
    }
//    echo('Fin de la boucle' . '<br>');
}
//echo('Fin du script');
echo $anim->getImagesBlob();
?>