<?php
require_once '../backend/db.php';
require_once '../backend/auth.php';

requireRole('admin'); // Chỉ admin mới được truy cập

header('Content-Type: application/json');
echo json_encode([
    "status" => "success",
    "message" => "Chào mừng Admin!",
]);
?>
