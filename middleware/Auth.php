<?php
class Auth {
    public static function check() {
        session_start();
        if (!isset($_SESSION['is_logged_in'])) {
            header("Location: ../views/auth/login.php");
            exit;
        }
    }

    public static function admin() {
        if (!isset($_SESSION['role_id']) || $_SESSION['role_id'] != 1) {
            die("Akses ditolak");
        }
    }
}
