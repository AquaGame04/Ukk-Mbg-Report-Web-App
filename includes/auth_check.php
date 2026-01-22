<?php
session_start();

// fungsi untuk mengecek apakah sudah login
function Login_Check() {
    if(!isset($_SESSION['login']) || $_SESSION['login'] !== true){
        header("Location: ../pages/login_pages.php");
        exit;
    }
}

// fungsi untuk mengecek hak akses role tertentu
function Only_Allow($roles_izinkan) {
    // jika role user tidak ada dalam daftar role yang diizinkan
    if(!in_array($_SESSION['role'], $roles_izinkan)){
        echo "<script>
             alert('Akses Ditolak! Anda tidak memiliki izin ke halaman ini');
             window.location='../process/dashboard.php'
             </script>";
        exit;
    }
}
?>