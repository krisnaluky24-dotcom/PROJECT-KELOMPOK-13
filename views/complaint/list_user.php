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

// Ambil data pengaduan user
$stmt = $complaint->readByUser($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pengaduan Saya</title>
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
            max-width: 1000px;
            width: 100%;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 30px;
        }
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-create {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.4);
        }
        .btn-logout {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }
        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(220, 53, 69, 0.4);
        }
        .empty-message {
            text-align: center;
            padding: 40px;
            color: #666;
            font-size: 1.1em;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        table td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        table tr:hover {
            background-color: #f5f5f5;
        }
        table tr:last-child td {
            border-bottom: none;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: 600;
        }
        .status-pending {
            background-color: #ffc107;
            color: #333;
        }
        .status-process {
            background-color: #17a2b8;
            color: white;
        }
        .status-resolved {
            background-color: #28a745;
            color: white;
        }
        .status-setuju {
            background-color: #20c997;
            color: white;
        }
        .status-tidak_setuju {
            background-color: #dc3545;
            color: white;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .back-link:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 Daftar Pengaduan Saya</h2>

        <div class="action-buttons">
            <a href="/kelompok13/views/complaint/create.php" class="btn btn-create">➕ Buat Pengaduan Baru</a>
            <a href="/kelompok13/controllers/logout.php" class="btn btn-logout">🔓 Logout</a>
        </div>

        <?php if ($stmt === false || $stmt->rowCount() === 0): ?>
            <div class="empty-message">
                <p>📭 Anda belum membuat pengaduan apapun.</p>
                <p style="margin-top: 10px; color: #999;">Mulai buat pengaduan baru untuk mengajukan masalah Anda.</p>
            </div>
        <?php else: ?>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                    $status = $row['status'] ?? 'pending';
                    $statusClass = 'status-' . str_replace(' ', '_', $status);
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['title'] ?? ''); ?></td>
                        <td><span class="status-badge <?= $statusClass; ?>"><?= ucfirst(str_replace('_', ' ', $status)); ?></span></td>
                        <td><?= date('d/m/Y H:i', strtotime($row['created_at'] ?? '')); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <?php endif; ?>

    </div>
</body>
</html>
