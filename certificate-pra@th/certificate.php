<?php

function fetchCertificate($name = "Prathap Puppala", $recognition = "entrepeneurship and skills in Web Development", $creatorName = "" ) {
if (strlen($name) > 255 || strlen($recognition)> 255 || strlen($creatorName) > 255) {
  return;
}


  // Create the image
  $im = imagecreatefrompng('templates/blank.png');
  // now follows the drawing of text on the template certificate
  // replace path by your own font path
  $font = 'fonts/arial.ttf';
  $black = imagecolorallocate($im, 25, 25, 25);
  $fontSize = 15; // Font size is in pixels.
  //image width
  $imageX = imagesx($im);
  

  // Add the text
  //get the width of the certificate holder's name
  $textWidth = imagettfbbox($fontSize, 0,$font, $name);
  $textWidth = $textWidth[0] + $textWidth[2];
  imagettftext($im, $fontSize, 0, ($imageX - $textWidth) / 2, 475, $black, $font, $name); 
  //get another width
  $textWidth = imagettfbbox($fontSize, 0,$font, $recognition);
  $textWidth = $textWidth[0] + $textWidth[2];
  imagettftext($im, $fontSize, 0, ($imageX - $textWidth) / 2, 575, $black, $font, $recognition);
  //get the width of the programmer word
  $textWidth = imagettfbbox($fontSize * 2, 0,$font, "MOCKTESTS");
  $textWidth = $textWidth[0] + $textWidth[2];
  imagettftext($im, $fontSize * 2, 0, ( $imageX - $textWidth) / 2, 350, $black, $font , "MOCKTESTS");

  imagettftext($im, $fontSize, 0,680 , 670, $black, $font, date("d/m/Y"));
  imagettftext($im, $fontSize, 0, 330 , 670, $black, $font, $creatorName);
 $id = uniqid(true);
  header("Content-Type: image/png");
  echo imagepng($im);
  //save the image in a file
  imagepng($im,"img/certs/" . $id . ".png" );

  imagedestroy($im);
}




?>
