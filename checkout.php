<?php
session_start();
require_once('./classes/database_customers.php');

if (!isset($_SESSION['customer_ID']) || !isset($_SESSION['order_id'])) {
    header("Location: menu.php");
    exit();
}

$db = new database_customers();
$con = $db->getConnection();

$customerId = $_SESSION['customer_ID'];
$orderId = $_SESSION['order_id'];

// Calculate total before form for display
$total = 0;
$stmt = $con->prepare("SELECT SUM(oi.quantity * mi.price) AS total 
                       FROM order_items oi 
                       JOIN menu_items mi ON oi.item_id = mi.item_id 
                       WHERE oi.order_id = ?");
$stmt->execute([$orderId]);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$total = $row ? $row['total'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paymentMethod = $_POST['payment_method'];
    $receiptPath = null;

    // GCash: validate and save image
    if ($paymentMethod === 'gcash' && isset($_FILES['gcash_receipt']) && $_FILES['gcash_receipt']['error'] === UPLOAD_ERR_OK) {
        $fileTmp = $_FILES['gcash_receipt']['tmp_name'];
        $fileName = basename($_FILES['gcash_receipt']['name']);
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExt, $allowedTypes)) {
            $newName = uniqid('receipt_') . '.' . $fileExt;
            $targetPath = 'uploads/' . $newName;
            if (move_uploaded_file($fileTmp, $targetPath)) {
                $receiptPath = $targetPath;
            } else {
                die("Error uploading receipt.");
            }
        } else {
            die("Invalid file type. Only JPG, PNG, GIF allowed.");
        }
    }

    // Update order
    $stmt = $con->prepare("UPDATE orders SET payment_method = ?, receipt = ?, status = 'pending', total = ?, paid_at = NULL WHERE order_id = ?");
    $stmt->execute([$paymentMethod, $receiptPath, $total, $orderId]);

    // Clear session order
    unset($_SESSION['order_id']);

    // Redirect to success
    header("Location: order_success.php?order_id=$orderId");  
    exit();
}

// Fetch order and order items for display
$stmt = $con->prepare("SELECT * FROM orders WHERE order_id = ? AND customer_ID = ?");
$stmt->execute([$orderId, $customerId]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Order not found.");
}

$stmt = $con->prepare("SELECT mi.item_name, mi.price, oi.quantity
                       FROM order_items oi 
                       JOIN menu_items mi ON oi.item_id = mi.item_id 
                       WHERE oi.order_id = ?");
$stmt->execute([$orderId]);
$orderItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Brew Bliss</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #fff8f0; padding: 40px; font-family: 'Segoe UI', sans-serif; }
    .container { max-width: 700px; background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 0 10px rgba(0,0,0,0.1);}
  </style>
</head>
<body>
  <div class="container">
    <h2 class="mb-4">Checkout</h2>
    <p><strong>Order #<?= $orderId ?></strong></p>

    <ul class="list-group mb-3">
      <?php foreach ($orderItems as $item): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <?= htmlspecialchars($item['item_name']) ?> (x<?= $item['quantity'] ?>)
          <span>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
        </li>
      <?php endforeach; ?>
    </ul>

    <h5>Total: ₱<?= number_format($total, 2) ?></h5>

    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Payment Method:</label><br>
        <input type="radio" name="payment_method" value="cash" required> Cash
        <input type="radio" name="payment_method" value="gcash" required class="ms-3"> GCash
      </div>

      <div class="mb-3" id="gcashUpload" style="display: none;">
        <label for="gcash_receipt" class="form-label">Upload GCash Receipt:</label>
        <input type="file" name="gcash_receipt" id="gcash_receipt" class="form-control">
      </div>

      <button type="submit" class="btn btn-success w-100">Confirm & Pay</button>
    </form>
  </div>

  <script>
    document.querySelectorAll('input[name="payment_method"]').forEach(input => {
      input.addEventListener('change', function () {
        document.getElementById('gcashUpload').style.display = this.value === 'gcash' ? 'block' : 'none';
      });
    });
  </script>
</body>
</html>
