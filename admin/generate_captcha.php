<?php
session_start();

// Tạo mã CAPTCHA ngẫu nhiên (5 ký tự)
$captcha_text = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 5);
$_SESSION['captcha'] = $captcha_text;

// Tạo ảnh CAPTCHA
$width = 150;
$height = 50;
$image = imagecreate($width, $height);

// Màu sắc
$bg_color = imagecolorallocate($image, 255, 255, 255);
$text_color = imagecolorallocate($image, 0, 0, 0);
$line_color = imagecolorallocate($image, 100, 100, 100);

// Vẽ nhiễu đường thẳng
for ($i = 0; $i < 5; $i++) {
    imageline($image, rand(0, $width), rand(0, $height), rand(0, $width), rand(0, $height), $line_color);
}

// Vẽ chữ CAPTCHA
$font = __DIR__ . '/fonts/arial.ttf'; // Đường dẫn đến font chữ TTF
imagettftext($image, 20, rand(-10, 10), 20, 35, $text_color, $font, $captcha_text);

// Xuất ảnh ra trình duyệt
header("Content-type: image/png");
imagepng($image);
imagedestroy($image);
?>
