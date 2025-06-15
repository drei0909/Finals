<?php
require_once('../database_admin.php');
$con = new adminDatabase();

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $stmt = $con->opencon()->prepare("SELECT COUNT(*) FROM admin WHERE admin_email = ?");
    $stmt->execute([$email]);
    echo $stmt->fetchColumn() > 0 ? 'taken' : 'available';
}
?>
