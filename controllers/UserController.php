<?php
// controllers/UserController.php

require_once '../middleware/Auth.php';
require_once '../config/Database.php';
require_once '../models/User.php';

Auth::check();      // wajib login
Auth::admin();      // hanya admin

$db = (new Database())->getConnection();
$user = new User($db);

// CREATE USER (oleh Admin)
if (isset($_POST['action']) && $_POST['action'] === 'create') {
    $user->create(
        $_POST['username'],
        $_POST['password'],
        $_POST['role_id']
    );

    header("Location: /kelompok13/views/admin/users.php");
    exit;
}

// DELETE USER
if (isset($_GET['delete'])) {
    $user->delete($_GET['delete']);

    header("Location: /kelompok13/views/admin/users.php");
    exit;
}
