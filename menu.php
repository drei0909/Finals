<?php
session_start();
require_once('./classes/database.php');

// Redirect to login if not logged in
if (!isset($_SESSION['admin_ID'])) {
    header('Location: login.php');
    exit();
}

$db = new database();
$con = $db->opencon();

$adminId = $_SESSION['admin_ID'];
$orderType = $_SESSION['order_type'] ?? 'dinein';

// Create a new order if one doesn't exist in session
if (!isset($_SESSION['order_id'])) {
    $stmt = $con->prepare("INSERT INTO orders (admin_ID, order_type) VALUES (?, ?)");
    $stmt->execute([$adminId, $orderType]);
    $_SESSION['order_id'] = $con->lastInsertId();
}
$orderId = $_SESSION['order_id'];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Remove item from cart
    if (isset($_POST['remove_item_id'])) {
        $removeItemId = $_POST['remove_item_id'];
        $stmt = $con->prepare("DELETE FROM order_items WHERE order_id = ? AND item_id = ?");
        $stmt->execute([$orderId, $removeItemId]);
    }
    // Add or replace item
    elseif (isset($_POST['item_id'], $_POST['quantity'], $_POST['action'])) {
        $itemId = $_POST['item_id'];
        $quantity = max(1, (int)$_POST['quantity']);
        $action = $_POST['action'];

        if ($action === 'replace') {
            $stmt = $con->prepare("DELETE FROM order_items WHERE order_id = ? AND item_id = ?");
            $stmt->execute([$orderId, $itemId]);
        }

        $stmt = $con->prepare("INSERT INTO order_items (order_id, item_id, quantity) VALUES (?, ?, ?) 
                              ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)");
        $stmt->execute([$orderId, $itemId, $quantity]);
    }
}

// Fetch menu
$menu = $con->query("SELECT * FROM menu_items")->fetchAll(PDO::FETCH_ASSOC);

// Fetch items in the current cart
$stmt = $con->prepare("SELECT oi.item_id, mi.item_name, mi.price, oi.quantity 
                       FROM order_items oi 
                       JOIN menu_items mi ON oi.item_id = mi.item_id 
                       WHERE oi.order_id = ?");
$stmt->execute([$orderId]);
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calculate total
$totalAmount = 0;
foreach ($orderItems as $item) {
    $totalAmount += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Coffee Shop Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f8f5f0;
      font-family: 'Roboto', sans-serif;
    }
    h2, h3 {
      text-align: center;
      color: #4e342e;
      margin-top: 2rem;
    }
    .menu-card {
      background: #fff;
      border: 1px solid #e0cfc2;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.05);
    }
    .menu-title {
      font-size: 1.2rem;
      color: #3e2723;
      font-weight: bold;
    }
    .price {
      color: #6d4c41;
      font-weight: 500;
    }
    .quantity-input {
      width: 60px;
    }
    .btn-primary { background-color: #6f4e37; border: none; }
    .btn-warning { background-color: #ff9800; border: none; }
    .btn-danger { background-color: #d32f2f; }
    .btn-success { background-color: #388e3c; }
    .btn:hover { opacity: 0.9; }
    table { background: #fff; border-radius: 8px; }
    .subtotal, #total-amount { font-weight: bold; color: #4e342e; }
    footer {
      margin-top: 60px;
      text-align: center;
      color: #a1887f;
    }
    .badge {
      font-size: 0.8rem;
      background-color: #dc3545;
      color: white;
    }
  </style>
</head>
<body class="container py-4">

  <h2>
    ☕ Our Coffee Menu 
    <?php if (count($orderItems) > 0): ?>
      <span class="badge rounded-pill"><?= count($orderItems) ?></span>
    <?php endif; ?>
  </h2>

  <div class="row g-4 mb-5">
  <?php foreach ($menu as $item): ?>
    <div class="col-md-4 col-lg-3">
      <div class="menu-card">
        <form method="post">
          <div class="menu-title"><?= htmlspecialchars($item['item_name']) ?></div>
          <div class="price">₱<?= number_format($item['price'], 2) ?></div>
          <div class="d-flex gap-2 mt-2">
            <input type="hidden" name="item_id" value="<?= $item['item_id'] ?>">
            <input type="number" name="quantity" value="1" min="1" class="form-control quantity-input">
            <button type="submit" name="action" value="add" class="btn btn-primary btn-sm">Add</button>
            <button type="submit" name="action" value="replace" class="btn btn-warning btn-sm">Replace</button>
          </div>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</div>

  <h3>🛒 Your Cart</h3>
  <div class="table-responsive mb-3">
    <table class="table table-bordered align-middle text-center" id="cart-table">
      <thead class="table-light">
        <tr>
          <th>Item</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Subtotal</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orderItems as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item['item_name']) ?></td>
          <td>₱<?= number_format($item['price'], 2) ?></td>
          <td><?= (int)$item['quantity'] ?></td>
          <td>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
          <td>
            <form method="post" action="menu.php" style="display:inline;">
              <input type="hidden" name="remove_item_id" value="<?= $item['item_id'] ?>">
              <button type="submit" class="btn btn-danger btn-sm">Remove</button>
            </form>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="d-flex justify-content-between align-items-center px-2">
      <h4>Total: ₱<span id="total-amount"><?= number_format($totalAmount, 2) ?></span></h4>
      <div>
        <a href="clear_cart.php" class="btn btn-outline-danger">🗑 Clear Cart</a>
        <a href="checkout.php" class="btn btn-success">✅ Checkout</a>
      </div>
    </div>
  </div>

  <footer>
    <small>© <?= date("Y") ?> Brew Bliss Coffee. Crafted with love.</small>
  </footer>

</body>
</html>
