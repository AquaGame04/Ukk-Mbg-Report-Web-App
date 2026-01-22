<?php
// session_start();

// if(!isset($_SESSION['login'])) {
//     header("Location: ../pages/login_pages.php");
//     exit;
// }

include '../includes/auth_check.php';
Login_Check();

$nama = $_SESSION['nama'];
$role = $_SESSION['role'];
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
    <!-- Main Dashboard
    <h1>Selamat Datang, <?php echo $_SESSION['nama']; ?>(<?php echo $_SESSION['role']; ?>)!</h1>
    <p>Role anda saat ini: <strong><?php echo $_SESSION['role'];?></strong></p>
    <hr> -->

    <div class="container">
    <aside class="sidebar">
        <div class="profile">
            <h3>MBG Report</h3>
            <p>User: <strong><?php echo $nama;?></strong></p>
            <span class="badge"><?php echo $role?></span>
        </div>
        <!-- Untuk Membedakan Role -->
        <nav class="menu">
            <ul>
                <li><a href="dashboard.php">Home</a></li>
                <?php if($_SESSION['role'] == 'Admin'): ?>
                    <li><a href="admin/user_manage.php">Kelola User</a></li>
                    <li><a href="sekolah/sekolah_manage.php">Kelola Sekolah</a></li>
                    <li><a href="sppg/sppg_manages.php">Kelola Tim SPPG</a></li>
                <?php endif; ?>

                <?php if($_SESSION['role'] == 'Petugas Gizi'): ?>
                    <li><a href="#">Input Menu & Gizi</a></li>
                <?php endif; ?>

                <?php if($_SESSION['role'] == 'Petugas Pengaduan'): ?>
                    <li><a href="#">Kelola Pengaduan</a></li>
                <?php endif; ?>
                <li><a href="../auth/logout_process.php" onclick="return confirm('Apakah Anda Yakin Ingin Keluar?')">Logout dari Sistem</a></li>
            </ul>
        </nav>
    </aside>

    <main class="content">
        <header>
            <h1>Dashboard <?php echo $role;?></h1>
            <p>Selamar datang kembali, <?php echo $nama;?> Apa yang ingin anda lakukan hari ini?</p>
        </header>

        <section class="stats-grid">
            <div class="card">
                <h3>Status Sistem</h3>
                <p>Aktif (Database Laragon Terhubung)</p>
            </div>

            <?php if($role == 'Admin') :?>
            <div class="card">
                <h3>Total User</h3>
                <p>Fitur Poin 9</p>
            </div>
            <?php endif;?>
        </section>
    </main>
</div>
</body>
</html>