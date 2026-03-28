<?php
header('Content-Type: application/json');
include '../config/database.php';

$response = [
    'success' => false,
    'menu' => null,
    'gizi' => null
];

if (isset($_GET['id'])) {
    $id_menu = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Get menu data
    $query_menu = "SELECT m.*, s.nama_sekolah 
                   FROM menu_harian m
                   JOIN sekolah s ON m.id_sekolah = s.id_sekolah
                   WHERE m.id_menu = '$id_menu'";
    $result_menu = mysqli_query($conn, $query_menu);
    
    if ($result_menu && mysqli_num_rows($result_menu) > 0) {
        $menu = mysqli_fetch_assoc($result_menu);
        
        // Get nutrition data
        $query_gizi = "SELECT * FROM gizi_menu WHERE id_menu = '$id_menu'";
        $result_gizi = mysqli_query($conn, $query_gizi);
        $gizi = mysqli_fetch_assoc($result_gizi);
        
        $response['success'] = true;
        $response['menu'] = $menu;
        $response['gizi'] = $gizi ?: [];
    }
}

echo json_encode($response);
?>
