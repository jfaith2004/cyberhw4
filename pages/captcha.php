<?php
session_start();

// 1) Generate a random 6-char code
$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789'; // no similar chars
$code = substr(str_shuffle($chars), 0, 6);
$_SESSION['captcha_text'] = $code;

// 2) Create the image
$width = 150; $height = 50;
$image = imagecreate($width, $height);

// Colors
$bg = imagecolorallocate($image, 255, 255, 255);
$fg = imagecolorallocate($image, 0, 0, 0);

// 3) Add some noise
for ($i = 0; $i < 50; $i++) {
    imagesetpixel($image, rand(0,$width), rand(0,$height), $fg);
}

// 4) Render the text (you can change font path or size)
$font = __DIR__ . '/fonts/arial.ttf'; // ensure this exists or use a built-in font
imagettftext($image, 24, rand(-10,10), 15, 35, $fg, $font, $code);

// 5) Output as PNG
header('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
