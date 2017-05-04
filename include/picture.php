<?php

header("Content-type: image/png");

$source = imagecreatefrompng("http://localhost:8080/Camagru/private/3.png");
$cadre = imagecreatefromgif("../cadre.gif");
$resize = imagecreatetruecolor(200, 200);

list($largeur, $hauteur) = getimagesize("../cadre.gif");
imagecopyresized($source, $cadre, 0, 0, 0, 0, 200, 200, $largeur, $hauteur);

//imagecopy($source, $resize, 0, 0, 0, 0, 200, 200);

imagepng($source);
imagedestroy($cpy, $source, $resize);

?>