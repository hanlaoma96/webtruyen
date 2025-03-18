<?php
require_once __DIR__ . '/../vendor/autoload.php';// Đảm bảo đã cài firebase/php-jwt

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = "your_secret_key"; // Đổi thành khóa bí mật của bạn

// Hàm tạo JWT
function createJWT($user) {
    global $key;
    $payload = [
        "iss" => "yourdomain.com", // Người cấp token
        "aud" => "yourdomain.com", // Người nhận token
        "iat" => time(),           // Thời gian tạo token
        "exp" => time() + 3600,    // Thời gian hết hạn (1 giờ)
        "data" => [
            "id" => $user['id'],
            "username" => $user['username'],
            "role" => $user['role']
        ]
    ];
    
    return JWT::encode($payload, $key, 'HS256');
}

// Hàm xác thực JWT
function verifyJWT($jwt) {
    global $key;
    try {
        $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        return $decoded->data; // Trả về thông tin user trong token
    } catch (Exception $e) {
        return null; // Token không hợp lệ
    }
}
?>
