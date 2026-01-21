<?php
// views/auth/register.php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>
    <h2>Registrasi Mahasiswa</h2>

    <form action="/kelompok13/controllers/AuthController.php" method="POST">
        <input type="hidden" name="action" value="register">

        <div>
            <label>Username</label><br>
            <input type="text" name="username" required>
        </div><br>

        <div>
            <label>Password</label><br>
            <input type="password" name="password" required>
        </div><br>

        <button type="submit">Daftar</button>
    </form>

    <p>
        <a href="/kelompok13/views/auth/login.php">Kembali ke Login</a>
    </p>
</body>
</html>
