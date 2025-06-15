<?php
session_start();
require_once('./classes/database_admin.php');

if (!isset($_SESSION['admin_ID'])) {
    header("Location: admin_L.php");
    exit();
}

$db = new adminDatabase();
$con = $db->getConnection();

$alert = ''; // Feedback message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['order_id'];
    $action = $_POST['action'];

    if ($action === 'approve') {
        $stmt = $con->prepare("UPDATE orders SET status = 'paid', paid_at = NOW() WHERE order_id = ?");
        $stmt->execute([$orderId]);
        $alert = 'approved';
    } elseif ($action === 'reject') {
        $stmt = $con->prepare("UPDATE orders SET status = 'rejected' WHERE order_id = ?");
        $stmt->execute([$orderId]);
        $alert = 'rejected';
    }
}

// Fetch pending orders
$stmt = $con->query("SELECT order_id, customer_ID, total, payment_method, receipt, status, created_at 
                     FROM orders 
                     WHERE status = 'pending' 
                     ORDER BY created_at DESC");
$pendingOrders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Approval Panel</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Pending Orders</h2>
      <a href="index_A.php" class="btn btn-outline-primary">← Back to Dashboard</a>
    </div>

    <?php if (count($pendingOrders) === 0): ?>
      <div class="alert alert-info">No pending orders.</div>
    <?php else: ?>
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>Order ID</th>
            <th>Customer ID</th>
            <th>Total</th>
            <th>Payment Method</th>
            <th>Receipt</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pendingOrders as $order): ?>
            <tr>
              <td><?= $order['order_id'] ?></td>
              <td><?= $order['customer_ID'] ?></td>
              <td>₱<?= number_format($order['total'], 2) ?></td>
              <td><?= ucfirst($order['payment_method']) ?></td>
              <td>
                <?php if ($order['receipt']): ?>
                  <a href="<?= $order['receipt'] ?>" target="_blank">View</a>
                <?php else: ?>
                  No receipt
                <?php endif; ?>
              </td>
              <td>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                  <button type="submit" name="action" value="approve" class="btn btn-success btn-sm">Approve</button>
                </form>
                <form method="POST" class="d-inline">
                  <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                  <button type="submit" name="action" value="reject" class="btn btn-danger btn-sm">Reject</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>

  <?php if ($alert === 'approved'): ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Order Approved!',
        text: 'The order has been marked as paid.',
        confirmButtonColor: '#198754'
      });
    </script>
  <?php elseif ($alert === 'rejected'): ?>
    <script>
      Swal.fire({
        icon: 'warning',
        title: 'Order Rejected',
        text: 'The order has been rejected.',
        confirmButtonColor: '#dc3545'
      });
    </script>
  <?php endif; ?>
</body>
</html>
