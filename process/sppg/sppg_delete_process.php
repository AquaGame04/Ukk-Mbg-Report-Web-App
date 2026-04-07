<?php
include '../../config/database.php';

if (isset($_GET['id'])) {
    $id_sppg = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Get photo to delete
    $query_select = "SELECT foto_tim FROM sppg WHERE id_sppg = '$id_sppg'";
    $result_select = mysqli_query($conn, $query_select);
    $data = mysqli_fetch_assoc($result_select);
    
    // Delete from database
    $query_delete = "DELETE FROM sppg WHERE id_sppg = '$id_sppg'";
    
    if (mysqli_query($conn, $query_delete)) {
        // Delete photo file if exists
        if (!empty($data['foto_tim']) && file_exists("../../assets/uploads/sppg/" . $data['foto_tim'])) {
            unlink("../../assets/uploads/sppg/" . $data['foto_tim']);
        }
        
        echo "<script>alert('Tim SPPG Berhasil Dihapus'); window.location='../../pages/sppg/sppg_manage.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus tim SPPG: " . mysqli_error($conn) . "'); window.location='../../pages/sppg/sppg_manage.php';</script>";
    }
} else {
    echo "<script>window.location='../../pages/sppg/sppg_manage.php';</script>";
}
?>