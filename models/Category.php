<?php
class Category {
    private $conn;
    private $table = "categories";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($name) {
        return $this->conn->prepare(
            "INSERT INTO categories (name) VALUES (:n)"
        )->execute([':n'=>$name]);
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM categories");
    }

    public function getById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $name) {
        return $this->conn->prepare(
            "UPDATE categories SET NAME = :n WHERE id = :id"
        )->execute([':n' => $name, ':id' => $id]);
    }

    public function delete($id) {
        return $this->conn->prepare(
            "DELETE FROM categories WHERE id=:id"
        )->execute([':id'=>$id]);
    }
}
