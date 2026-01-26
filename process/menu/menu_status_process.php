<?php
include '../../config/database.php';
include '../../includes/auth_check.php';
Login_Check();

if (isset($_GET['id']) && isset($_GET['set'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $status = mysqli_real_escape_string($conn, $_GET['set']);

    $query = "UPDATE menu_harian SET riwayat = '$status' WHERE id_menu = '$id'";

    if (mysqli_query($conn, $query)) {
        $msg = ($status == 1) ? "Menu berhasil diarsipkan" : "Menu berhasil dipulihkan";
        echo "<script>alert('$msg'); window.location='../../pages/petugas/menu/menu_manage.php?status=$status';</script>";
    }
}
?>