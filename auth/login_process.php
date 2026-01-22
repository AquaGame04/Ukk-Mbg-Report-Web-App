<?php
session_start();
ob_start(); // Tambahkan output buffering
include '../config/database.php';

if(isset($_POST['login'])){
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE uid = '$uid'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) === 1){
        $user = mysqli_fetch_assoc($result);

        if($password == $user['password']){
            $_SESSION['login'] = true;
            $_SESSION['uid'] = $user['uid'];
            $_SESSION['nama'] = $user['nama'];
            $_SESSION['role'] = $user['role'];
            
            // Pastikan path ini benar sesuai struktur folder Anda
            header("Location: ../pages/dashboard.php");
            exit;
        }
    }
    echo "<script>alert('UID atau Password Salah!'); window.location='../pages/login_pages.php';</script>";
    exit;
}
ob_end_flush();
?>