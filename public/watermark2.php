<?php

//require_once('GDArrow.php');

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
$text1 = "{$mmsize[0]}mm";
$text2 = "{$mmsize[1]}mm";

//create a new image
$newImg = imagecreatefromjpeg($filename);

//set the watermark font color to red
$fontColor = imagecolorallocate($newImg, 0, 0, 0);

//left side text
$xPosition = isset($_REQUEST['leftside_x'])?$_REQUEST['leftside_x']:100;
$yPosition = isset($_REQUEST['leftside_y'])?$_REQUEST['leftside_y']:430;
//write the watermark on the created image
imagestring($newImg, $fontSize, $xPosition, $yPosition, $text1, $fontColor);

//right side text
$xPosition = isset($_REQUEST['rightside_x'])?$_REQUEST['rightside_x']:515;
$yPosition = isset($_REQUEST['rightside_y'])?$_REQUEST['rightside_y']:340;
imagestring($newImg, $fontSize, $xPosition, $yPosition, $text2, $fontColor);

//add overlay
$watermark = imagecreatefrompng("arrowup.png");
$size = getimagesize($filename);
$dest_x = isset($_REQUEST['arrowup_x'])?$_REQUEST['arrowup_x']:-10;
$dest_y = isset($_REQUEST['arrowup_y'])?$_REQUEST['arrowup_y']:200;
$watermark_width = $size[0];
$watermark_height = $size[1];
imagecopy($newImg, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);

$watermark = imagecreatefrompng("arrowside.png");
$size = getimagesize($filename);
$dest_x = isset($_REQUEST['arrowside_x'])?$_REQUEST['arrowside_x']:0;
$dest_y = isset($_REQUEST['arrowside_y'])?$_REQUEST['arrowside_y']:200;
$watermark_width = $size[0];
$watermark_height = $size[1];
imagecopy($newImg, $watermark, $dest_x, $dest_y, 0, 0, $watermark_width, $watermark_height);

//add overlay
/*$pink = imagecolorallocate($newImg, 255, 105, 180);
imagerectangle($newImg, 50, 50, 150, 150, $pink);
*/
header('content-type: image/png');

//output the new image with a watermark to a file
/*$file = str_replace("_2", "_4", $_REQUEST['filename']);
error_log($file);
imagejpeg($newImg, $file,100);
*/
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