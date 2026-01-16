<?php
session_start();

// Menghapus semua variabel session seperti login = true
$_SESSION = [];

// Menghancurkan session di server agar tidak stuk
session_unset();
session_destroy();

// Mengarahkan ke halaman login saat logout
header("Location: ../pages/login_pages.php");
exit;
?>