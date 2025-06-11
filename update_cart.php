<?php
session_start();
require_once('./classes/database.php');

header('Content-Type: application/json');

if (!isset($_SESSION['order_id'])) {
    echo json_encode(['success' => false, 'message' => 'Order not found']);
    exit();
}

$orderId = $_SESSION['order_id'];
$itemId = $_POST['item_id'];
$quantity = $_POST['quantity'];

if ($quantity < 1) {
    echo json_encode(['success' => false, 'message' => 'Quantity must be at least 1']);
    exit();
}

$db = new database();
$con = $db->opencon();

// Update quantity
$stmt = $con->prepare("UPDATE order_items SET quantity = ? WHERE order_id = ? AND item_id = ?");
$stmt->execute([$quantity, $orderId, $itemId]);

// Get updated subtotal and total
$stmt = $con->prepare("SELECT mi.price, oi.quantity 
                       FROM order_items oi 
                       JOIN menu_items mi ON oi.item_id = mi.item_id 
                       WHERE oi.order_id = ? AND oi.item_id = ?");
$stmt->execute([$orderId, $itemId]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);
$subtotal = $item['price'] * $item['quantity'];

// Get total
$stmt = $con->prepare("SELECT mi.price, oi.quantity 
                       FROM order_items oi 
                       JOIN menu_items mi ON oi.item_id = mi.item_id 
                       WHERE oi.order_id = ?");
$stmt->execute([$orderId]);
$total = 0;
foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
    $total += $row['price'] * $row['quantity'];
}

echo json_encode([
    'success' => true,
    'subtotal' => $subtotal,
    'total' => $total
]);
