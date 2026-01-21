<?php
include '../../includes/auth_check.php';
include '../../config/database.php';

Login_Check();
Only_Allow(['Admin']);

if(isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $query = "DELETE FROM users WHERE uid = '$uid'";

    if (mysqli_query($conn, $query)){
        echo "<script>alert('User berhaasil dihapus'); window.location = '../../pages/admin/user_manage.php';</script>";
    } else {
        echo "Error: " . mysqli_errno(($conn));
    }
}
?>