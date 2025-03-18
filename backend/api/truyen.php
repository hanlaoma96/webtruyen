<?php
header('Content-Type: application/json');
require '../db.php'; // Include the database connection

if (isset($_GET['id'])) {
    // Lấy chi tiết một truyện
    $id = $conn->real_escape_string($_GET['id']);
    $sql = "SELECT * FROM truyen WHERE id = '$id'";
    $result = $conn->query($sql);
    echo json_encode($result->fetch_assoc());
} else {
    // Lấy danh sách truyện
    $sql = "SELECT * FROM truyen";
    $result = $conn->query($sql);
    $truyen = array();
    while($row = $result->fetch_assoc()) {
        $truyen[] = $row;
    }
    echo json_encode($truyen);
}

$conn->close();
?>
