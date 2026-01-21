<?php
require_once '../../middleware/Auth.php';
require_once '../../config/Database.php';
require_once '../../models/Complaint.php';

Auth::check();
Auth::admin();

$db = (new Database())->getConnection();
$complaint = new Complaint($db);
$data = $complaint->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Pengaduan (Admin)</title>
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
            max-width: 1200px;
            width: 100%;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
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
        .status-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        select {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 0.95em;
        }
        .btn-update {
            padding: 8px 16px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.2s;
        }
        .btn-update:hover {
            background-color: #0056b3;
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
        .button-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: 0.3s;
            font-weight: 600;
        }
        a:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>📋 Data Pengaduan</h2>

        <table>
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Judul</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $data->fetch()): 
                    $status = $row['status'] ?? 'pending';
                    $statusClass = 'status-' . str_replace(' ', '_', $status);
                ?>
                <tr>
                    <td>#<?= $row['user_id'] ?? ''; ?></td>
                    <td><?= htmlspecialchars($row['title'] ?? ''); ?></td>
                    <td><span class="status-badge <?= $statusClass; ?>"><?= ucfirst(str_replace('_', ' ', $status)); ?></span></td>
                    <td>
                        <form action="/kelompok13/controllers/ComplaintController.php" method="POST" class="status-form">
                            <input type="hidden" name="action" value="update_status">
                            <input type="hidden" name="id" value="<?= $row['id'] ?? ''; ?>">
                            <select name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="pending" <?= (isset($row['status']) && $row['status'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="process" <?= (isset($row['status']) && $row['status'] === 'process') ? 'selected' : ''; ?>>Process</option>
                                <option value="resolved" <?= (isset($row['status']) && $row['status'] === 'resolved') ? 'selected' : ''; ?>>Resolved</option>
                                <option value="setuju" <?= (isset($row['status']) && $row['status'] === 'setuju') ? 'selected' : ''; ?>>Setuju</option>
                                <option value="tidak_setuju" <?= (isset($row['status']) && $row['status'] === 'tidak_setuju') ? 'selected' : ''; ?>>Tidak Setuju</option>
                            </select>
                            <button type="submit" class="btn-update">✅ Update</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <div class="button-container">
            <a href="/kelompok13/views/admin/dashboard.php">← Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
