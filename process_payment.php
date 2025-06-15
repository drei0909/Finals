<?php
session_start();
require_once('./classes/database_admin.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin_ID'])) {
    header("Location: admin_L.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['order_ID'], $_POST['action'])) {
        die("Invalid request.");
    }

    $orderID = $_POST['order_ID'];
    $action = $_POST['action'];

    $con = new adminDatabase();

    // Determine status based on action
    if ($action === 'approve') {
        $status = 'Completed';
    } elseif ($action === 'reject') {
        $status = 'Rejected';
    } else {
        die("Invalid action.");
    }

    try {
        $stmt = $con->conn->prepare("UPDATE orders SET status = ? WHERE order_ID = ?");
        $stmt->execute([$status, $orderID]);

        // Optional: Add flash message or SweetAlert2 later
        header("Location: pending_payments.php?success=" . $action);
        exit();
    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }
} else {
    header("Location: pending_payments.php");
    exit();
}
