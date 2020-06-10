<?php
/*$im = new Imagick();
$im->setResolution(144,144);
$im->readImage($_GET['file'] . '[0]');
$im->setImageFormat("gif");
header("Content-Type: image/gif");
echo $im;
*/
header("Content-Type: image/gif");
$anim = new Imagick();
$anim->setFormat("gif");

//$im->readImage($_GET['file'] . '[0]');
$count = new Imagick();
$count->readImage($_GET['file']);
//echo('$count->getNumberImages() : ' . $count->getNumberImages() .'<br>');
//var_dump($im->getNumberImages()); //returns 2
for ($i = 0; $i <= $count->getNumberImages() - 1; $i++) {
//    echo('$i : ' . $i . '<br>');
//    echo($_GET['file'] . '[' . $i .']' . '<br>');
    $frame = new Imagick();
    $frame->readImage($_GET['file'] . '[' . $i .']');
    $frame->setImageFormat("gif");
    $frame->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE );
    $frame->setResolution(144,144);
    $frame->setImageDelay(100);
$frame->minifyImage();
    $anim->addImage($frame);
}
echo $anim->getImagesBlob();

//$im->setImageFormat("gif");

?>