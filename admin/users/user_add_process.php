<?php
include '../../config/database.php';

if(isset($_POST['submit'])) {
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $role = $_POST['role'];
    $password = $_POST['password'];

    $query = "INSERT INTO users (uid, nama, role, password) VALUES ('$uid', '$nama', '$role', '$password')";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('User Berhasil Ditambahkan'); window.location='../../pages/admin/user_manage.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    }
?>