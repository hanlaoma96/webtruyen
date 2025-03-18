<?php
class Category {
    private $conn;
    private $table_name = "categories";

    public $id;
    public $ten_the_loai;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getCategories() {
        $query = "SELECT * FROM " . $this->table_name;
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function addCategory() {
        $query = "INSERT INTO " . $this->table_name . " (ten_the_loai) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->ten_the_loai);
        return $stmt->execute();
    }

    public function updateCategory() {
        $query = "UPDATE " . $this->table_name . " SET ten_the_loai = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $this->ten_the_loai, $this->id);
        return $stmt->execute();
    }

    public function deleteCategory() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }
}