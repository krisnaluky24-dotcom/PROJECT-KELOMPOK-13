<?php
require_once '../../middleware/Auth.php';
require_once '../../config/Database.php';
require_once '../../models/Category.php';

Auth::check();
Auth::admin();

$db = (new Database())->getConnection();
$category = new Category($db);
$data = $category->getAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Kategori</title>
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
            max-width: 900px;
            width: 100%;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 2em;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            padding: 10px 15px;
            border-radius: 5px;
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
        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #e0e0e0;
        }
        .form-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }
        input[type="text"] {
            flex: 1;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        button {
            padding: 10px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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
        .action-buttons {
            display: flex;
            gap: 8px;
        }
        .btn-edit, .btn-delete {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            font-weight: 600;
            transition: 0.2s;
        }
        .btn-edit {
            background-color: #28a745;
            color: white;
        }
        .btn-edit:hover {
            background-color: #218838;
        }
        .btn-delete {
            background-color: #dc3545;
            color: white;
        }
        .btn-delete:hover {
            background-color: #c82333;
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
        <h2>📁 Kategori Pengaduan</h2>

        <?php
        if (isset($_GET['success'])) {
            echo "<div class='message success'><b>✅ Operasi berhasil!</b></div>";
        } elseif (isset($_GET['error'])) {
            echo "<div class='message error'><b>❌ Terjadi kesalahan!</b></div>";
        }
        ?>

        <div class="form-container">
            <form action="/kelompok13/controllers/CategoryController.php" method="POST">
                <input type="hidden" name="action" value="create">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Masukkan nama kategori baru..." required>
                    <button type="submit">➕ Tambah Kategori</button>
                </div>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $data->fetch()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['NAME'] ?? $row['name']; ?></td>
                    <td>
                        <div class="action-buttons">
                            <form action="/kelompok13/controllers/CategoryController.php" method="POST" style="display:inline; flex: 1;">
                                <input type="hidden" name="action" value="edit">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <input type="text" name="name" value="<?= $row['NAME'] ?? $row['name']; ?>" required style="width: 120px; padding: 6px; border: 1px solid #ddd; border-radius: 4px;">
                                <button type="submit" class="btn-edit">✏️ Edit</button>
                            </form>
                            <form action="/kelompok13/controllers/CategoryController.php" method="POST" style="display:inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus kategori ini?')">🗑️ Hapus</button>
                            </form>
                        </div>
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
</body>
</html>
