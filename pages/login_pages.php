<?php
session_start();

if(isset($_SESSION['login'])) {
    header("Location: ../process/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> -->
    <title>Login - MBG Report</title>
    <link rel="stylesheet" href="../assets/css/login_style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login Sistem</h2>
        <form action="../auth/login_process.php" method="POST">
            <input type="text" name="uid" placeholder="Masukkan UID" required><br>
            <input type="password" name="password" placeholder="Masukkan Password" required><br>
            <button type="submit" name="login">Masuk</button>
        </form><br>
        <p>Belum punya akun? <a href="register_pages.php">Daftar</a></p>
        <p><a href="../index.php">Kembali ke Beranda</a></p>
    </div>
</body>
</html>