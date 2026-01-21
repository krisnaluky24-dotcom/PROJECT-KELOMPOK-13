<?php
session_start();

// Proteksi: hanya admin
if (!isset($_SESSION['is_logged_in']) || $_SESSION['role_id'] != 1) {
    header("Location: /kelompok13/views/auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
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
            padding: 20px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            margin-bottom: 30px;
            text-align: center;
        }
        .header h1 {
            color: #333;
            font-size: 2.5em;
            margin-bottom: 10px;
        }
        .header p {
            color: #666;
            font-size: 1.1em;
            margin-bottom: 20px;
        }
        .welcome {
            color: #667eea;
            font-size: 1.2em;
            font-weight: 600;
        }
        .menu-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .menu-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 30px;
            text-align: center;
            transition: 0.3s;
            text-decoration: none;
            color: #333;
        }
        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        }
        .menu-card .icon {
            font-size: 3em;
            margin-bottom: 15px;
        }
        .menu-card h3 {
            font-size: 1.3em;
            margin-bottom: 10px;
            color: #333;
        }
        .menu-card p {
            color: #666;
            font-size: 0.95em;
        }
        .logout-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            transition: 0.3s;
        }
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(220, 53, 69, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>👨‍💼 Dashboard Admin</h1>
            <p>Selamat datang,</p>
            <div class="welcome"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
        </div>

        <div class="menu-grid">
            <a href="/kelompok13/views/admin/users.php" class="menu-card">
                <div class="icon">👥</div>
                <h3>Kelola User</h3>
                <p>Manage pengguna sistem</p>
            </a>

            <a href="/kelompok13/views/admin/categories.php" class="menu-card">
                <div class="icon">📁</div>
                <h3>Kelola Kategori</h3>
                <p>Atur kategori pengaduan</p>
            </a>

            <a href="/kelompok13/views/complaint/list_admin.php" class="menu-card">
                <div class="icon">📋</div>
                <h3>Data Pengaduan</h3>
                <p>Kelola semua pengaduan</p>
            </a>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="/kelompok13/controllers/logout.php" class="logout-btn">🔓 Logout</a>
        </div>
    </div>
</body>
</html>
