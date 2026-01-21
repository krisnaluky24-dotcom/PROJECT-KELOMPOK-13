<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../../models/Complaint.php';

// Proteksi login mahasiswa
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role_id'] != 2) {
    header("Location: /kelompok13/views/auth/login.php");
    exit;
}

$database = new Database();
$db = $database->getConnection();
$complaint = new Complaint($db);

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint->user_id = $_SESSION['user_id']; 
    $complaint->title = $_POST['title'] ?? '';
    $complaint->description = $_POST['description'] ?? '';
    $complaint->category_id = $_POST['category_id'] ?? 0;
    $complaint->evidence = '';

    // Upload file (tanpa helper)
    if (isset($_FILES['evidence']) && $_FILES['evidence']['error'] === 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];
        $ext = strtolower(pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION));

        if (in_array($ext, $allowed) && $_FILES['evidence']['size'] <= 2000000) {
            $newName = uniqid() . '.' . $ext;
            move_uploaded_file(
                $_FILES['evidence']['tmp_name'],
                __DIR__ . '/../../public/uploads/' . $newName
            );
            $complaint->evidence = $newName;
        }
    }

    if ($complaint->create()) {
        $message = "Pengaduan berhasil dikirim";
    } else {
        $message = "Gagal menyimpan pengaduan";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Pengaduan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 700px;
            width: 100%;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 10px;
            font-size: 2em;
        }
        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 0.95em;
        }
        .message {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95em;
        }
        input[type="text"],
        select,
        textarea,
        input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            transition: 0.3s;
        }
        input[type="text"]:focus,
        select:focus,
        textarea:focus,
        input[type="file"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        textarea {
            resize: vertical;
            min-height: 120px;
        }
        input[type="file"] {
            padding: 8px;
        }
        .file-info {
            font-size: 0.85em;
            color: #666;
            margin-top: 5px;
        }
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 30px;
            justify-content: center;
        }
        button,
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1em;
            transition: 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        button[type="submit"] {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-width: 150px;
        }
        button[type="submit"]:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .btn-back {
            background-color: #6c757d;
            color: white;
            min-width: 150px;
            text-align: center;
        }
        .btn-back:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(108, 117, 125, 0.4);
        }
        .category-info {
            background-color: #f9f9f9;
            padding: 12px;
            border-radius: 5px;
            font-size: 0.9em;
            color: #666;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📝 Buat Pengaduan</h2>
        <p class="subtitle">Sampaikan keluhan atau masalah Anda dengan detail</p>

        <?php if ($message): ?>
            <?php 
            $isSuccess = strpos($message, 'berhasil') !== false;
            $messageClass = $isSuccess ? 'success' : 'error';
            ?>
            <div class="message <?= $messageClass; ?>">
                <?= $isSuccess ? '✅' : '❌'; ?> <?= htmlspecialchars($message); ?>
                <?php if ($isSuccess): ?>
                    <br><a href="/kelompok13/views/complaint/list_user.php" style="color: inherit; margin-top: 10px; display: inline-block;">← Kembali ke daftar pengaduan</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">📌 Judul Pengaduan <span style="color: #dc3545;">*</span></label>
                <input type="text" id="title" name="title" placeholder="Masukkan judul pengaduan..." required>
            </div>

            <div class="form-group">
                <label for="category_id">📂 Kategori <span style="color: #dc3545;">*</span></label>
                <select id="category_id" name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="1">📚 Akademik</option>
                    <option value="2">🏢 Fasilitas</option>
                    <option value="3">📄 Administrasi</option>
                </select>
                <div class="category-info">
                    💡 Pilih kategori yang paling sesuai dengan keluhan Anda
                </div>
            </div>

            <div class="form-group">
                <label for="description">📋 Deskripsi <span style="color: #dc3545;">*</span></label>
                <textarea id="description" name="description" placeholder="Jelaskan masalah Anda secara detail..." required></textarea>
            </div>

            <div class="form-group">
                <label for="evidence">📎 Bukti (Opsional)</label>
                <input type="file" id="evidence" name="evidence" accept=".jpg,.jpeg,.png,.pdf">
                <div class="file-info">
                    📤 Format: JPG, JPEG, PNG, PDF | Ukuran maksimal: 2MB
                </div>
            </div>

            <div class="button-group">
                <button type="submit">✅ Kirim Pengaduan</button>
                <a href="/kelompok13/views/complaint/list_user.php" class="btn btn-back">← Batal</a>
            </div>
        </form>
    </div>
</body>
</html>
