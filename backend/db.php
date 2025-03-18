<?php
$host = "localhost";
$user = "admin";  // Thay bằng user MySQL của bạn
$pass = "123456"; // Nếu có mật khẩu MySQL thì điền vào
$db = "webtruyen"; // Thay bằng tên database của bạn

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

?>