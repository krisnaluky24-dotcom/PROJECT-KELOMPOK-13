<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Pengaduan</title>
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
        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            padding: 50px;
            max-width: 400px;
            width: 100%;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo h1 {
            color: #333;
            font-size: 1.8em;
            margin-bottom: 10px;
        }
        .logo p {
            color: #666;
            font-size: 0.95em;
        }
        h2 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.5em;
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
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            transition: 0.3s;
        }
        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .btn-login {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 12px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid #f5c6cb;
        }
        .register-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .register-link p {
            color: #666;
            margin-bottom: 10px;
        }
        .register-link a {
            display: inline-block;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        .register-link a:hover {
            color: #764ba2;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo">
            <h1>📋 Pengaduan</h1>
            <p>Sistem Manajemen Pengaduan</p>
        </div>

        <h2>Login</h2>

        <?php
        if (isset($_GET['error'])) {
            echo "<div class='error-message'>";
            if ($_GET['error'] === 'invalid') {
                echo "❌ Username atau password salah!";
            } else if ($_GET['error'] === 'required') {
                echo "❌ Username dan password harus diisi!";
            }
            echo "</div>";
        }
        if (isset($_GET['success'])) {
            echo "<div style='background-color: #d4edda; color: #155724; padding: 12px 15px; border-radius: 5px; margin-bottom: 20px; border: 1px solid #c3e6cb;'>✅ Registrasi berhasil! Silakan login.</div>";
        }
        ?>

        <form action="/kelompok13/controllers/AuthController.php" method="POST">
            <input type="hidden" name="action" value="login">

            <div class="form-group">
                <label for="username">👤 Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan username..." required>
            </div>

            <div class="form-group">
                <label for="password">🔐 Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan password..." required>
            </div>

            <button type="submit" class="btn-login">🔓 Login</button>
        </form>

        <div class="register-link">
            <p>Belum punya akun?</p>
            <a href="/kelompok13/views/auth/register.php">📝 Buat akun baru</a>
        </div>
    </div>
</body>
</html>
