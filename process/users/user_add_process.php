<?php
include '../../config/database.php';

if(isset($_POST['submit'])) {
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $role = $_POST['role'];
    $id_sekolah = $_POST['id_sekolah'];
    $password = $_POST['password'];

    $val_sekolah = !empty($id_sekolah) ? "'$id_sekolah'" : "NULL";

    // Check if UID already exists
    $check_query = "SELECT uid FROM users WHERE uid = '$uid'";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        echo "<script>alert('Username \"$uid\" sudah terdaftar! Gunakan username yang berbeda.'); window.history.back();</script>";
    } else {
        $query = "INSERT INTO users (uid, nama, role, password, id_sekolah) VALUES ('$uid', '$nama', '$role', '$password', $val_sekolah)";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('User Berhasil Ditambahkan'); window.location='../../pages/admin/user_manage.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    }
?>