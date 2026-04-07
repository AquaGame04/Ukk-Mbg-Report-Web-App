<?php
include '../config/database.php';

if(isset($_POST['register'])){
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    $query = "INSERT INTO users (uid, nama, role, password) VALUES ('$uid', '$nama', '$role', '$password')";

    if(mysqli_query($conn, $query)) {
        session_start();
        $_SESSION['pesan'] = "Registrasi Berhasil! Silakan Login.";

        header("Location: ../pages/login_pages.php");
        exit;
    }
}
?>