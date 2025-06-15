<?php
require_once('../database_admin.php');
$con = new adminDatabase();

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $stmt = $con->opencon()->prepare("SELECT COUNT(*) FROM admin WHERE admin_username = ?");
    $stmt->execute([$username]);
    echo $stmt->fetchColumn() > 0 ? 'taken' : 'available';
}
?>
