<?php
// models/Complaint.php

class Complaint {
    private $conn;
    private $table = "complaints";

    public $id;
    public $user_id;
    public $title;
    public $description;
    public $category_id;
    public $evidence;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    /* =====================================================
       CREATE
       ===================================================== */
    public function create() {
        $query = "INSERT INTO {$this->table}
                  (user_id, title, description, category_id, evidence, status)
                  VALUES (:user_id, :title, :description, :category_id, :evidence, 'pending')";

        $stmt = $this->conn->prepare($query);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));

        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":category_id", $this->category_id);
        $stmt->bindParam(":evidence", $this->evidence);

        return $stmt->execute();
    }

    /* =====================================================
       READ BY USER (INI YANG HILANG SEBELUMNYA)
       ===================================================== */
    public function readByUser($user_id) {
        $query = "SELECT * FROM {$this->table}
                  WHERE user_id = :user_id
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        return $stmt;
    }

    /* =====================================================
       READ ALL (ADMIN)
       ===================================================== */
    public function readAll() {
        $query = "SELECT c.*, u.username, cat.name AS category
                  FROM complaints c
                  JOIN users u ON c.user_id = u.id
                  JOIN categories cat ON c.category_id = cat.id
                  ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    /* =====================================================
       UPDATE STATUS (ADMIN)
       ===================================================== */
    public function updateStatus($id, $status) {
        $query = "UPDATE {$this->table}
                  SET STATUS = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":status", $status);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    /* =====================================================
       DELETE
       ===================================================== */
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    /* =====================================================
       ALIAS: GET ALL (sama dengan readAll)
       ===================================================== */
    public function getAll() {
        return $this->readAll();
    }

    /* =====================================================
       ALIAS: GET BY USER (sama dengan readByUser)
       ===================================================== */
    public function getByUser($user_id) {
        return $this->readByUser($user_id);
    }
}
