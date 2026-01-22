<?php
include '../../config/database.php';

if (isset($_POST['update'])) {
    $old_id = mysqli_real_escape_string($conn, $_POST['old_id']);
    $id_sppg = mysqli_real_escape_string($conn, $_POST['id_sppg']);
    $nama_tim = mysqli_real_escape_string($conn, $_POST['nama_tim']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $id_sekolah = mysqli_real_escape_string($conn, $_POST['id_sekolah']);
    $ketua = mysqli_real_escape_string($conn, $_POST['ketua_tim']);
    $kontak = mysqli_real_escape_string($conn, $_POST['kontak_tim']);
    $foto_lama = $_POST['foto_lama']; // Mengambil nama foto lama dari hidden input

    // Proses array anggota tim menjadi string
    $anggota = isset($_POST['anggota_tim']) ? implode(',', $_POST['anggota_tim']) : '';

    // Logika Upload Foto
    if(!empty($_FILES['foto_tim']['name'])){
        $foto_name = $_FILES['foto_tim']['name'];
        $tmp_name = $_FILES['foto_tim']['tmp_name'];
        $new_foto_name = "team_" . time() . "_" . $foto_name;
        $upload_path = "../../assets/uploads/" . $new_foto_name; // Definisi path

        if(move_uploaded_file($tmp_name, $upload_path)){
            // Hapus foto lama dari folder jika ada dan jika bukan string kosong
            if(!empty($foto_lama) && file_exists("../../assets/uploads/" . $foto_lama)){
                unlink("../../assets/uploads/" . $foto_lama);
            }
            $foto_final = $new_foto_name;
        } else {
            $foto_final = $foto_lama;
        }
    } else {
        // Jika user tidak upload foto baru, pakai foto lama
        $foto_final = $foto_lama;
    }

    // Perbaikan Query (Perhatikan tanda koma setelah $anggota)
    $query = "UPDATE sppg SET 
                id_sppg = '$id_sppg', 
                nama_tim = '$nama_tim', 
                jabatan = '$jabatan',
                id_sekolah = '$id_sekolah', 
                ketua_tim = '$ketua', 
                kontak_tim = '$kontak',
                anggota_tim = '$anggota',
                foto_tim = '$foto_final'
              WHERE id_sppg = '$old_id'";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data Tim SPPG Berhasil Diperbarui'); window.location='../../pages/sppg/sppg_manages.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>