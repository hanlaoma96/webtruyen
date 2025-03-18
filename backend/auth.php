<?php
require_once 'jwt.php';

function authenticate() {
    $headers = apache_request_headers();
    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Thiếu token!"]);
        exit();
    }

    $token = str_replace('Bearer ', '', $headers['Authorization']);
    $user = verifyJWT($token);

    if (!$user) {
        http_response_code(401);
        echo json_encode(["status" => "error", "message" => "Token không hợp lệ hoặc hết hạn!"]);
        exit();
    }

    return $user; // Trả về thông tin user nếu token hợp lệ
}

// Kiểm tra quyền user (admin hoặc user)
function requireRole($requiredRole) {
    $user = authenticate(); // Xác thực user trước
    if ($user['role'] !== $requiredRole) {
        http_response_code(403);
        echo json_encode(["status" => "error", "message" => "Bạn không có quyền truy cập!"]);
        exit();
    }
}
?>
