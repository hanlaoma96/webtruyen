<?php
session_start();

// Hủy session của user
session_destroy();

// Trả về phản hồi thành công
header('Content-Type: application/json');
echo json_encode(["status" => "success", "message" => "Đăng xuất thành công!"]);
?>
