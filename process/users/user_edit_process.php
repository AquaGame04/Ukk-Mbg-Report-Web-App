<?php
include '../../config/database.php';

if(isset($_POST['update'])) {
    $old_uid = mysqli_real_escape_string($conn, $_POST['old_uid']);
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $role = $_POST['role'];
    $id_sekolah = trim($_POST['id_sekolah']);
    $password = $_POST['password'];

    $val_sekolah = !empty($id_sekolah) ? "'$id_sekolah'" : "NULL";

    // Check if new UID already exists (excluding current old_uid)
    if ($uid !== $old_uid) {
        $check_query = "SELECT uid FROM users WHERE uid = '$uid'";
        $check_result = mysqli_query($conn, $check_query);
        
        if (mysqli_num_rows($check_result) > 0) {
            echo "<script>alert('Username \"$uid\" sudah terdaftar! Gunakan username yang berbeda.'); window.history.back();</script>";
            exit;
        }
    }

    if(!empty($password)){
        $query = "UPDATE users SET uid='$uid', nama='$nama', role='$role', password='$password', id_sekolah = $val_sekolah WHERE uid='$old_uid'";
    } else {
        $query = "UPDATE users SET uid='$uid', nama='$nama', role='$role', id_sekolah = $val_sekolah WHERE uid='$old_uid'";
    }

    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Diperbarui'); window.location='../../pages/admin/user_manage.php';</script>";
    }
}
?>

