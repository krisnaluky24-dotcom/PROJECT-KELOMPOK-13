<?php
// controllers/CategoryController.php

require_once '../middleware/Auth.php';
require_once '../config/Database.php';
require_once '../models/Category.php';

Auth::check();     // wajib login
Auth::admin();     // hanya admin

$db = (new Database())->getConnection();
$category = new Category($db);

$action = $_POST['action'] ?? $_GET['action'] ?? '';

/* =====================================================
   CREATE CATEGORY
   ===================================================== */
if ($action === 'create') {
    $name = $_POST['name'] ?? '';
    
    if ($name) {
        if ($category->create($name)) {
            header("Location: /kelompok13/views/admin/categories.php?success=1");
        } else {
            header("Location: /kelompok13/views/admin/categories.php?error=1");
        }
    } else {
        header("Location: /kelompok13/views/admin/categories.php?error=invalid");
    }
    exit;
}

/* =====================================================
   UPDATE CATEGORY
   ===================================================== */
if ($action === 'edit') {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    
    if ($id && $name) {
        if ($category->update($id, $name)) {
            header("Location: /kelompok13/views/admin/categories.php?success=1");
        } else {
            header("Location: /kelompok13/views/admin/categories.php?error=1");
        }
    } else {
        header("Location: /kelompok13/views/admin/categories.php?error=invalid");
    }
    exit;
}

/* =====================================================
   DELETE CATEGORY
   ===================================================== */
if ($action === 'delete') {
    $id = $_POST['id'] ?? $_GET['delete'] ?? null;
    
    if ($id) {
        if ($category->delete($id)) {
            header("Location: /kelompok13/views/admin/categories.php?success=1");
        } else {
            header("Location: /kelompok13/views/admin/categories.php?error=1");
        }
    } else {
        header("Location: /kelompok13/views/admin/categories.php?error=invalid");
    }
    exit;
}

?>
