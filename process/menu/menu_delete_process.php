<?php
include '../../config/database.php';
include '../../includes/auth_check.php';
Login_Check();

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Ambil nama file foto dulu sebelum data di DB dihapus
    $res = mysqli_query($conn, "SELECT foto_url FROM menu_harian WHERE id_menu = '$id'");
    $data = mysqli_fetch_assoc($res);
    $foto = $data['foto_url'];

    // 2. Hapus data di database
    $query = "DELETE FROM menu_harian WHERE id_menu = '$id'";

    if (mysqli_query($conn, $query)) {
        // 3. Hapus file foto dari folder uploads
        if (file_exists("../../assets/uploads/menu/" . $foto)) {
            unlink("../../assets/uploads/menu/" . $foto);
        }
        echo "<script>alert('Menu Berhasil Dihapus'); window.location='../../pages/petugas/menu/menu_manage.php';</script>";
    }
}
?>