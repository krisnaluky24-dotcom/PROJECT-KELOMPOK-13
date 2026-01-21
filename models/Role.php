<?php
// models/Role.php

class Role {
    private $conn;
    private $table = "roles";

    public function __construct($db) {
        $this->conn = $db;
    }

    /* =====================
       CREATE
    ====================== */
    public function create($role_name) {
        $query = "INSERT INTO {$this->table} (role_name) VALUES (:role_name)";
        $stmt = $this->conn->prepare($query);

        // Sanitasi input
        $role_name = htmlspecialchars(strip_tags($role_name));

        return $stmt->execute([
            ':role_name' => $role_name
        ]);
    }

    /* =====================
       READ ALL
    ====================== */
    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY id ASC";
        return $this->conn->query($query);
    }

    /* =====================
       READ BY ID
    ====================== */
    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([
            ':id' => (int)$id
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* =====================
       UPDATE
    ====================== */
    public function update($id, $role_name) {
        $query = "UPDATE {$this->table} 
                  SET role_name = :role_name 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $role_name = htmlspecialchars(strip_tags($role_name));

        return $stmt->execute([
            ':role_name' => $role_name,
            ':id' => (int)$id
        ]);
    }

    /* =====================
       DELETE
    ====================== */
    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        return $stmt->execute([
            ':id' => (int)$id
        ]);
    }

    /* =====================
       RBAC HELPER
    ====================== */
    public function isAdmin($role_id) {
        return $role_id == 1;
    }
}
