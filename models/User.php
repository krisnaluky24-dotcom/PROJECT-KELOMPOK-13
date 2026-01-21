<?php
// models/User.php

class User
{
    private $conn;
    private $table = "users";

    // Properti
    public $id;
    public $username;
    public $password;
    public $role_id;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    /* ===========================
       LOGIN USER / ADMIN
    =========================== */
    public function login($username, $password)
    {
        $sql = "SELECT id, username, password, role_id 
                FROM {$this->table} 
                WHERE username = :username 
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        // User tidak ditemukan
        if ($stmt->rowCount() === 0) {
            return false;
        }

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verifikasi password (bcrypt)
        if (!password_verify($password, $row['password'])) {
            return false;
        }

        // Set data user
        $this->id       = $row['id'];
        $this->username = $row['username'];
        $this->role_id  = $row['role_id'];

        return true;
    }

    /* ===========================
       CREATE USER (REGISTER)
    =========================== */
    public function create($username, $password, $role_id = 2)
    {
        $sql = "INSERT INTO {$this->table} 
                (username, password, role_id)
                VALUES (:username, :password, :role_id)";

        $stmt = $this->conn->prepare($sql);

        $username = htmlspecialchars(strip_tags($username));
        $password = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":role_id", $role_id);

        return $stmt->execute();
    }

    /* ===========================
       READ ALL USER (ADMIN)
    =========================== */
    public function getAll()
    {
        $sql = "SELECT u.id, u.username, r.role_name AS role
                FROM users u
                JOIN roles r ON u.role_id = r.id
                ORDER BY u.id DESC";

        return $this->conn->query($sql);
    }

    /* ===========================
       READ USER BY ID
    =========================== */
    public function getById($id)
    {
        $sql = "SELECT id, username, role_id
                FROM {$this->table}
                WHERE id = :id
                LIMIT 1";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /* ===========================
       UPDATE USER
    =========================== */
    public function update($id, $username, $role_id)
    {
        $sql = "UPDATE {$this->table}
                SET username = :username,
                    role_id = :role_id
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $username = htmlspecialchars(strip_tags($username));

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":role_id", $role_id);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    /* ===========================
       DELETE USER (ADMIN)
    =========================== */
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);

        return $stmt->execute();
    }

    /* ===========================
       CEK ROLE ADMIN
    =========================== */
    public function isAdmin()
    {
        return $this->role_id == 1;
    }

    /* ===========================
       CEK USERNAME SUDAH ADA
    =========================== */
    public function usernameExists($username)
    {
        $sql = "SELECT id FROM {$this->table} WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    /* ===========================
       REGISTER (ALIAS UNTUK CREATE)
    =========================== */
    public function register($username, $password, $role_id = 2)
    {
        return $this->create($username, $password, $role_id);
    }
}
