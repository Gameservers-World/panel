<?php
/*
 * Component of the status module
 */

function drawRating($rating)
{
    $width = 300;
    $height = 15;
    $ratingbar = (($rating / 100) * $width) - 2;
    $image = imagecreate($width, $height);
    $fill = ImageColorAllocate($image, 67, 219, 0);
    if ($rating > 74) {
        $fill = ImageColorAllocate($image, 233, 233, 0);
    }
    if ($rating > 89) {
        $fill = ImageColorAllocate($image, 197, 6, 6);
    }
    if ($rating > 100) {
        echo "Overload Error!";
        exit();
    }
    $back = ImageColorAllocate($image, 255, 255, 255);
    $border = ImageColorAllocate($image, 151, 151, 151);
    ImageFilledRectangle($image, 0, 0, $width - 1, $height - 1, $back);
    ImageFilledRectangle($image, 1, 1, $ratingbar, $height - 1, $fill);
    ImageRectangle($image, 0, 0, $width - 1, $height - 1, $border);
    imagePNG($image);
    imagedestroy($image);
}
Header("Content-type: image/png");
drawRating($_GET['rating']);

?>