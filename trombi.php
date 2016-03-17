<?php
//Your Image
$imgSrc = "etc/trombi/".$_GET['id'];

list($width, $height) = getimagesize($imgSrc);

$myImage = imagecreatefromjpeg($imgSrc);

if ($width > $height) {
    $y = 0;
    $x = ($width - $height) / 2;
    $smallestSide = $height;
} else {
    $x = 0;
    $y = ($height - $width) / 2;
    $smallestSide = $width;
}

$thumbSize = 240;
$thumb = imagecreatetruecolor($thumbSize, $thumbSize);
imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

header('Content-type: image/jpeg');
imagejpeg($thumb);
?>