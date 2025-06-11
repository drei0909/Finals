<?php
session_start();
require_once './classes/database.php';

if (!isset($_SESSION['admin_ID'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['type'])) {
    echo "Invalid order type.";
    exit();
}

$orderType = $_GET['type'];
$adminId = $_SESSION['admin_ID'];

// Connect to DB
$db = new database();
$con = $db->opencon();

// Insert order record
$stmt = $con->prepare("INSERT INTO orders (order_type, admin_ID, created_at) VALUES (?, ?, NOW())");
$stmt->execute([$orderType, $adminId]);

$orderId = $con->lastInsertId(); // get new order ID

// Store order ID in session for menu.php
$_SESSION['order_id'] = $orderId;

// Redirect to menu.php
header("Location: menu.php?type=$orderType");
exit();
?>
