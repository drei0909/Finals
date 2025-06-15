<?php
require_once('./classes/database_admin.php');
session_start();

if (!isset($_SESSION['admin_ID'])) {
    header("Location: admin_L.php");
    exit();
}

$con = new adminDatabase();
$customers = $con->getAllCustomers(); // You will create this method next
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Customers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container py-4">
    <h2>Registered Customers</h2>
    <table class="table table-bordered table-striped mt-3">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Registered At</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($customers as $customer): ?>
        <tr>
          <td><?= htmlspecialchars($customer['customer_id']) ?></td>
          <td><?= htmlspecialchars($customer['customer_username']) ?></td>
          <td><?= htmlspecialchars($customer['customer_email']) ?></td>
          <td><?= htmlspecialchars($customer['customer_FN']) ?></td>
          <td><?= htmlspecialchars($customer['customer_LN']) ?></td>
          <td><?= htmlspecialchars($customer['created_at']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <a href="index_A.php" class="btn btn-secondary">Back to Dashboard</a>
  </div>
</body>
</html>
