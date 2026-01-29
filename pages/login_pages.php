<?php
session_start();

if(isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MBG Report</title>
    <link rel="stylesheet" href="../assets/css/login_style.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1>MBG REPORT</h1>
                <p>Sistem Transparansi Makan Bergizi Gratis</p>
            </div>
            
            <form action="../auth/login_process.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="uid">UID / Username</label>
                    <input type="text" id="uid" name="uid" placeholder="Masukkan UID Anda" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan Password" required>
                </div>
                
                <button type="submit" name="login" class="btn-login-submit">Masuk</button>
            </form>
            
            <div class="login-footer">
                <p>Belum punya akun? <a href="register_pages.php">Daftar di sini</a></p>
                <p><a href="../index.php">← Kembali ke Beranda</a></p>
            </div>
        </div>
    </div>
</body>
</html>