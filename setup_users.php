<?php
// File untuk setup user admin dan mahasiswa
require_once __DIR__ . '/../config/Database.php';

$database = new Database();
$db = $database->getConnection();

// Hapus user yang sudah ada
$sql = "TRUNCATE TABLE users";
$db->query($sql);

// Insert user admin dengan password 'password'
$username_admin = 'admin';
$password_admin = 'password';
$hash_admin = password_hash($password_admin, PASSWORD_BCRYPT);
$role_id_admin = 1;

$sql = "INSERT INTO users (username, PASSWORD, role_id) VALUES (:username, :password, :role_id)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username_admin);
$stmt->bindParam(':password', $hash_admin);
$stmt->bindParam(':role_id', $role_id_admin);
$stmt->execute();

// Insert user mahasiswa dengan password 'password'
$username_mhs = 'mahasiswa1';
$password_mhs = 'password';
$hash_mhs = password_hash($password_mhs, PASSWORD_BCRYPT);
$role_id_mhs = 2;

$sql = "INSERT INTO users (username, PASSWORD, role_id) VALUES (:username, :password, :role_id)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username_mhs);
$stmt->bindParam(':password', $hash_mhs);
$stmt->bindParam(':role_id', $role_id_mhs);
$stmt->execute();

echo "✅ User berhasil dibuat!\n";
echo "Admin: admin / password\n";
echo "Mahasiswa: mahasiswa1 / password\n";
?>

