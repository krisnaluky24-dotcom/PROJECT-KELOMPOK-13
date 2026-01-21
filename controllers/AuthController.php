<?php
session_start();

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$action = $_POST['action'] ?? '';

/* =====================================================
   LOGIN
   ===================================================== */
if ($action === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->login($username, $password)) {
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role_id'] = $user->role_id;

        // Debug: Cek role_id
        error_log("DEBUG: Login success. Username: " . $user->username . ", Role ID: " . $user->role_id);

        // 🔑 PEMISAHAN ROLE
        if ($user->role_id == 1) {
            // ADMIN
            error_log("DEBUG: Redirect to admin dashboard");
            header("Location: /kelompok13/views/admin/dashboard.php");
        } else {
            // MAHASISWA
            error_log("DEBUG: Redirect to user complaints");
            header("Location: /kelompok13/views/complaint/list_user.php");
        }
        exit;
    } else {
        header("Location: /kelompok13/views/auth/login.php?error=invalid");
        exit;
    }
}

/* =====================================================
   REGISTER
   ===================================================== */
if ($action === 'register') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($user->usernameExists($username)) {
        header("Location: /kelompok13/views/auth/register.php?error=exists");
        exit;
    }

    // ⬇️ INI YANG DIPERBAIKI
    if ($user->register($username, $password, 2)) {
        header("Location: /kelompok13/views/auth/login.php?success=1");
        exit;
    } else {
        header("Location: /kelompok13/views/auth/register.php?error=failed");
        exit;
    }
}
