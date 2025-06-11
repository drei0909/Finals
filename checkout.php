<?php
session_start();
require_once('./classes/database.php');

if (!isset($_SESSION['admin_ID']) || !isset($_SESSION['order_id'])) {
    header('Location: menu.php');
    exit();
}

$db = new database();
$con = $db->opencon();

$orderId = $_SESSION['order_id'];

// Fetch admin full name for the order
$stmtAdmin = $con->prepare("
    SELECT CONCAT(a.admin_FN, ' ', a.admin_LN) AS admin_fullname
    FROM orders
    JOIN admin a ON orders.admin_ID = a.admin_id
    WHERE orders.order_id = ?
");
$stmtAdmin->execute([$orderId]);
$admin = $stmtAdmin->fetch(PDO::FETCH_ASSOC);

$adminName = $admin ? $admin['admin_fullname'] : "Unknown Admin";

// Fetch order items
$stmt = $con->prepare("
    SELECT mi.item_name, mi.price, oi.quantity 
    FROM order_items oi 
    JOIN menu_items mi ON oi.item_id = mi.item_id
    WHERE oi.order_id = ?
");
$stmt->execute([$orderId]);
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$orderItems) {
    echo "<p>Your cart is empty. <a href='menu.php'>Go back to menu</a></p>";
    exit();
}

// Calculate total
$totalAmount = 0;
foreach ($orderItems as $item) {
    $totalAmount += $item['price'] * $item['quantity'];
}

// Handle order confirmation
$thankYouMessage = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    // Update order status in DB (make sure your orders table has 'status' and 'completed_at' columns)
    $stmt = $con->prepare("UPDATE orders SET status = 'completed', completed_at = NOW() WHERE order_id = ?");
    $stmt->execute([$orderId]);

    // Clear the current order session so user can start new order
    unset($_SESSION['order_id']);

    $thankYouMessage = "Thank you for your order, $adminName! Your coffee will be ready soon ☕️";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Checkout - Review Your Order</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f8f5f0;
      font-family: 'Roboto', sans-serif;
    }
    h2 {
      color: #4e342e;
      margin-top: 2rem;
      text-align: center;
    }
    .admin-name {
      text-align: center;
      margin-bottom: 1rem;
      font-weight: 600;
      color: #6f4e37;
    }
    table {
      background: #fff;
      border-radius: 8px;
      margin-bottom: 2rem;
    }
    footer {
      margin-top: 60px;
      text-align: center;
      color: #a1887f;
    }
  </style>
</head>
<body class="container py-4">

  <h2>Review Your Cart</h2>
  <p class="admin-name">Order placed by: <?= htmlspecialchars($adminName) ?></p>

  <?php if ($thankYouMessage): ?>
    <div class="alert alert-success text-center"><?= htmlspecialchars($thankYouMessage) ?></div>
    <div class="text-center">
      <a href="menu.php" class="btn btn-primary mt-3">Order More Coffee</a>
    </div>
  <?php else: ?>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Item</th>
          <th>Price (₱)</th>
          <th>Quantity</th>
          <th>Subtotal (₱)</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orderItems as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['item_name']) ?></td>
            <td><?= number_format($item['price'], 2) ?></td>
            <td><?= (int)$item['quantity'] ?></td>
            <td><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <h4 class="text-end">Total: ₱<?= number_format($totalAmount, 2) ?></h4>

    <form method="post" class="mt-4 text-center">
      <button type="submit" name="confirm_order" class="btn btn-success btn-lg">Confirm Order</button>
      <a href="menu.php" class="btn btn-secondary ms-2">Back to Menu</a>
    </form>

  <?php endif; ?>

  <footer>
    <small>© <?= date("Y") ?> Brew Bliss Coffee. Crafted with love.</small>
  </footer>

</body>
</html>
