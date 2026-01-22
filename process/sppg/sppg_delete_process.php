<?php
include '../../config/database.php';
include '../../includes/auth_check.php';
Login_Check();
Only_Allow(['Admin']);

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "DELETE FROM sppg WHERE id_sppg = '$id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Tim SPPG Berhasil Dihapus'); window.location='../../pages/sppg/sppg_manages.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>