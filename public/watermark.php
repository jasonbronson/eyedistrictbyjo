<?php
//Let's say you sent the filename via the url, i.e. watermark.php?filename=myimage.jpg
$filename="./productimages/".$_REQUEST['filename'];

if(!file_exists($filename)){
    exit;
}

/*
 * set the watermark font size
 * possible values 1,2,3,4, and 5
 * where 5 is the biggest
 */
$fontSize = 5;

$mmsize = $_REQUEST['size']; 
$mmsize = explode(" ", $mmsize);

//set the watermark text
$text = "{$mmsize[2]}mm";


/*
 * position the watermark
 * 10 pixels from the left
 * and 10 pixels from the top
 */
$xPosition = 570;
$yPosition = 630;

//create a new image
$newImg = imagecreatefromjpeg($filename);

//set the watermark font color to red
$fontColor = imagecolorallocate($newImg, 0, 0, 0);

//write the watermark on the created image
imagestring($newImg, $fontSize, $xPosition, $yPosition, $text, $fontColor);

//add overlay
$watermark = imagecreatefrompng("size2.png");
$size = getimagesize($filename);
$dest_x = 0;
$dest_y = 0;
$watermark_width = $size[0];
$watermark_height = $size[1];
imagecopy($newImg, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);

header('content-type: image/png');

//output the new image with a watermark to a file
//imagejpeg($newImg,"add-a-text-watermark-to-an-image-with-php_01.jpg",100);
/*
 * PNG file appeared to have
 * a better quality than the JPG
 */
imagepng($newImg);

/*
 * destroy the image to free
 * any memory associated with it
 */
imagedestroy($newImg);
imagedestroy($watermark);


?>