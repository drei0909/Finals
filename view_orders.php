<?php
session_start();
require_once('./classes/database_admin.php');

if (!isset($_SESSION['admin_ID'])) {
    header("Location: admin_L.php");
    exit();
}

$con = new Admindatabase();
$orders = $con->getOrdersWithCustomerInfo();
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Orders | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container mt-5">
    <h2>Customer Orders</h2>
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>Order ID</th>
          <th>Customer</th>
          <th>Email</th>
          <th>Order Type</th>
          <th>Status</th>
          <th>Payment</th>
          <th>GCash Screenshot</th>
          <th>Ordered At</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($orders as $order): ?>
          <tr>
            <td><?= $order['order_ID'] ?></td>
            <td><?= $order['customer_FN'] . ' ' . $order['customer_LN'] ?></td>
            <td><?= $order['customer_email'] ?></td>
            <td><?= $order['order_type'] ?></td>
            <td><?= $order['status'] ?></td>
            <td><?= $order['payment_method'] ?></td>
            <td>
              <?php if ($order['screenshot_path']): ?>
                <a href="<?= $order['screenshot_path'] ?>" target="_blank">View</a>
              <?php else: ?>
                No Screenshot
              <?php endif; ?>
            </td>
            <td><?= $order['order_date'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
