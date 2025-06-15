<?php
session_start();
require_once './classes/database_customers.php';

if (!isset($_SESSION['customer_ID'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['type'])) {
    echo "Invalid order type.";
    exit();
}

$orderType = $_GET['type'];
$customerId = $_SESSION['customer_ID'];

// Connect to DB
$db = new database_customers();
$con = $db->getConnection(); // ✅ now works instead of opencon()


// Insert order record
$stmt = $con->prepare("INSERT INTO orders (order_type, customer_ID, created_at) VALUES (?, ?, NOW())");
$stmt->execute([$orderType, $customerId]);

$orderId = $con->lastInsertId(); // get new order ID

// Store order ID in session for menu.php
$_SESSION['order_id'] = $orderId;

// Redirect to menu.php
header("Location: menu.php?type=$orderType");
exit();
?>
