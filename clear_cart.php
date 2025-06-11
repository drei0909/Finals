<?php
session_start();
require_once('./classes/database.php');

// Ensure an order exists
if (!isset($_SESSION['order_id'])) {
    header("Location: menu.php");
    exit();
}

try {
    $orderId = $_SESSION['order_id'];

    $db = new database();
    $con = $db->opencon();

    // Use a prepared statement to clear the cart
    $stmt = $con->prepare("DELETE FROM order_items WHERE order_id = ?");
    $stmt->execute([$orderId]);

} catch (Exception $e) {
    // Optional: Log error or show a user-friendly message
    error_log("Cart clear failed: " . $e->getMessage());
}

// Redirect back to the menu
header("Location: menu.php");
exit();
