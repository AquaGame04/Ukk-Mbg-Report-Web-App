<?php
session_start();

if(!isset($_SESSION['login'])) {
    header("Location: ../pages/login_pages.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> -->
    <title>Dashboard - MBG Report</title>
</head>
<body>
    <!-- Untuk Membedakan Role -->
    <ul>
        <?php if($_SESSION['role'] == 'Admin'): ?>
            <li><a href="#">CRUD Data User (Poin 9)</a></li>
            <li><a href="#">CRUD Data Sekolah (Poin 10)</a></li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
            <li><a href="#">Input Menu Hari Ini (Poin 12)</a></li>
        <?php endif; ?>

        <?php if($_SESSION['role'] == 'Petugas Pengaduan'): ?>
            <li><a href="#">Kelola Pengaduan (Poin 16)</a></li>
        <?php endif; ?>
    </ul>

    <!-- Main Dashboard -->
    <h1>Selamat Datang, <?php echo $_SESSION['nama']; ?>!</h1>
    <p>Role anda saat ini: <strong><?php echo $_SESSION['role'];?></strong></p>
    <hr>
    <a href="../auth/logout_process.php" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?')">Logout dari Sistem</a>
</body>
</html>