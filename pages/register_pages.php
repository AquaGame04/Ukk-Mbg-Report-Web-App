<!DOCTYPE html>
<html lang="en">
<head>
    <!-- <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> -->
    <title>Register - MBG Report</title>
    <link rel="stylesheet" href="../assets/css/login_style.css">
</head>
<body>
    <div class="login-container">
        <h2>Registrasi User Baru</h2>
        <form action="../auth/register_process.php" method="POST">
            <input type="text" name="uid" placeholder="Buat UID (Contoh: USR001)" required><br>
            <input type="text" name="nama" placeholder="Nama Lengkap" required><br>
            <select name="role">
                <option value="Admin">Admin</option>
                <option value="Petugas Gizi">Petugas Gizi</option>
                <option value="Petugas Pengaduan">Petugas Pengaduan</option>
            </select><br>
            <input type="password" name="password" placeholder="buat Password" required><br>
            <button type="submit" name="register">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login_pages.php">Login</a></p>
        <p><a href="../index.php">Kembali ke Beranda</a></p>
    </div>
</body>
</html>