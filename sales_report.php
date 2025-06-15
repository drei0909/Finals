<?php
session_start();
require_once('./classes/database_admin.php');

if (!isset($_SESSION['admin_ID'])) {
    header("Location: admin_L.php");
    exit();
}

$con = new adminDatabase();
$orders = $con->getAllOrders();

$totalSales = 0;
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Sales Report</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h2 class="mb-4">Sales Report</h2>
  <table class="table table-bordered bg-white">
    <thead>
      <tr>
        <th>Order ID</th>
        <th>Order Type</th>
        <th>Status</th>
        <th>Payment Method</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($orders as $order): ?>
        <?php if ($order['status'] === 'Completed'): ?>
          <tr>
            <td><?= $order['order_ID'] ?></td>
            <td><?= $order['order_type'] ?></td>
            <td><?= $order['status'] ?></td>
            <td><?= $order['payment_method'] ?></td>
            <td><?= $order['created_at'] ?></td>
          </tr>
          <?php $totalSales += 1; ?>
        <?php endif; ?>
      <?php endforeach; ?>
    </tbody>
  </table>
  <div class="alert alert-info">
    <strong>Total Completed Orders:</strong> <?= $totalSales ?>
  </div>
</div>
</body>
</html>
