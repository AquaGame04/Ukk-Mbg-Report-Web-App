<?php
include '../../config/database.php';

if(isset($_POST['update'])) {
    $old_uid = $_POST['old_uid'];
    $uid = $_POST['uid'];
    $nama = $_POST['nama'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if(!empty($password)){
        $query = "UPDATE users SET uid='$uid', nama='$nama', role='$role', password='$password' WHERE uid='$old_uid'";
    } else {
        $query = "UPDATE users SET uid='$uid', nama='$nama', role='$role' WHERE uid='$old_uid'";
    }

    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Data Berhasil Diperbarui'); window.location='../../pages/admin/user_manage.php';</script>";
    }
}
?>

