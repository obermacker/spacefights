<?php // grafik.php
header("Content-type: image/png");
$bild = imagecreatetruecolor(100, 100);
imagecolorallocate($bild, 0, 0, 0);

$orange = imagecolorallocate($bild, 255, 144, 0);
$rot_hell = imagecolorallocate($bild, 73, 25, 25);
$rot_dunkel = imagecolorallocate($bild, 41, 9, 9);


imagerectangle($bild, 20 * 2, 20 * 2, 30 * 2 + 1, 30 * 2 + 1, $rot_hell);

imagefill ( $bild, 25 * 2, 25 * 2 , $rot_dunkel );

imagesetpixel ($bild, 25 * 2, 25 * 2, $orange);
imagesetpixel ($bild, 25 * 2 + 1, 25 * 2, $orange);
imagesetpixel ($bild, 25 * 2, 25 * 2 + 1, $orange);
imagesetpixel ($bild, 25 * 2 + 1, 25 * 2 + 1, $orange);

imagepng($bild);imagedestroy($bild);
?> 