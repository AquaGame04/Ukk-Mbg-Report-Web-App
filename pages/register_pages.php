<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - MBG Report</title>
    <link rel="stylesheet" href="../assets/css/login_style.css">
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <div class="login-header">
                <h1>MBG REPORT</h1>
                <p>Registrasi User Baru</p>
            </div>
            
            <form action="../auth/register_process.php" method="POST" class="login-form">
                <div class="form-group">
                    <label for="uid">UID (User ID)</label>
                    <input type="text" id="uid" name="uid" placeholder="Contoh: USR001" required>
                </div>
                
                <div class="form-group">
                    <label for="nama">Nama Lengkap</label>
                    <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                </div>
                
                <div class="form-group">
                    <label for="role">Peran / Role</label>
                    <select id="role" name="role" required class="select-role">
                        <option value="">-- Pilih Role --</option>
                        <option value="Admin">Admin</option>
                        <option value="Petugas Gizi">Petugas Gizi</option>
                        <option value="Petugas Pengaduan">Petugas Pengaduan</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Buat password yang kuat" required>
                </div>
                
                <button type="submit" name="register" class="btn-login-submit">Daftar</button>
            </form>
            
            <div class="login-footer">
                <p>Sudah punya akun? <a href="login_pages.php">Login di sini</a></p>
                <p><a href="../index.php">← Kembali ke Beranda</a></p>
            </div>
        </div>
    </div>
</body>
</html>