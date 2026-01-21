<?php
require_once '../middleware/Auth.php';
Auth::check();
echo "Selamat datang, ".$_SESSION['user']['username'];
