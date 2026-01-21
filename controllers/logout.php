<?php
session_start();
session_destroy();
header("Location: /kelompok13/views/auth/login.php");
exit;
?>
