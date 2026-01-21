<?php
require_once '../middleware/Auth.php';
require_once '../config/Database.php';
require_once '../models/Complaint.php';

Auth::check();
$db = (new Database())->getConnection();
$complaint = new Complaint($db);

$action = $_POST['action'] ?? '';

/* =====================================================
   CREATE COMPLAINT (USER)
   ===================================================== */
if ($action === 'create') {
    $file = $_FILES['evidence'];
    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $name = uniqid().'.'.$ext;
    move_uploaded_file($file['tmp_name'], "../public/uploads/".$name);

    $complaint->user_id = $_SESSION['user_id'];
    $complaint->category_id = $_POST['category_id'];
    $complaint->title = $_POST['title'];
    $complaint->description = $_POST['description'];
    $complaint->evidence = $name;
    
    if ($complaint->create()) {
        header("Location: ../views/complaint/list_user.php?success=1");
    } else {
        header("Location: ../views/complaint/create.php?error=1");
    }
    exit;
}

/* =====================================================
   UPDATE STATUS (ADMIN)
   ===================================================== */
if ($action === 'update_status') {
    $id = $_POST['id'] ?? null;
    $status = $_POST['status'] ?? null;

    error_log("DEBUG UPDATE STATUS: id=$id, status=$status");

    if ($id && $status) {
        if ($complaint->updateStatus($id, $status)) {
            error_log("DEBUG: Update berhasil");
            header("Location: ../views/complaint/list_admin.php?success=1");
        } else {
            error_log("DEBUG: Update gagal");
            header("Location: ../views/complaint/list_admin.php?error=failed");
        }
    } else {
        error_log("DEBUG: id atau status kosong");
        header("Location: ../views/complaint/list_admin.php?error=invalid");
    }
    exit;
}

?>
