<?php
class ImgResizer {
private $originalFile = '';
public function __construct($originalFile = '') {
$this -> originalFile = $originalFile;
}
//the function below will get you an image with the width and height values set by you.
// In case you need exact size images.
public function resize_const($newWidth,$newHeight, $targetFile) {
if (empty($newWidth)|| empty($newHeight) || empty($targetFile)) {
return false;
}
// check extension of image
 $ext = substr(strrchr($this -> originalFile, '.'), 1);
 
                if(!strcmp("jpg",$ext) || !strcmp("jpeg",$ext)){
                         $src=imagecreatefromjpeg($this -> originalFile);
                }
 
                if(!strcmp("png",$ext)){
                         $src=imagecreatefrompng($this -> originalFile);
                }
                
                if(!strcmp("gif",$ext)){
                         $src=imagecreatefromgif($this -> originalFile);   
                }
//$src = imagecreatefromjpeg($this -> originalFile);
list($width, $height) = getimagesize($this -> originalFile);
$tmp = imagecreatetruecolor($newWidth, $newHeight);
imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
if (file_exists($targetFile)) {
unlink($targetFile);
}

if(!strcmp("gif",$ext)){
                         imagegif($tmp, $targetFile, 85);
                }else if(!strcmp("png",$ext)){
                         imagepng($tmp, $targetFile);
                }
                else{
                         imagejpeg($tmp, $targetFile, 85);
                }
//imagejpeg($tmp, $targetFile, 85); // 85 is my choice, make it between 0 – 100 for output image quality with 100 being the most luxurious
}
}
?>