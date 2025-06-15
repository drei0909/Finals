<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION['admin_ID'])) {
    header("Location: admin_L.php");
    exit();
}

// Get admin name from session
$adminName = htmlspecialchars($_SESSION['admin_FN'] ?? 'Admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard | IZANA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #f8f5f2;
      font-family: 'Segoe UI', sans-serif;
    }

    .dashboard-header {
      background-color: #4e342e;
      color: white;
      padding: 1rem;
      text-align: center;
    }

    .dashboard-content {
      padding: 2rem;
    }

    .card {
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }

    .card h4 {
      margin-bottom: 1rem;
    }

    .logout-btn {
      background-color: #8d6e63;
      border: none;
      font-weight: bold;
      transition: 0.3s;
    }

    .logout-btn:hover {
      background-color: #6d4c41;
    }

    .btn-outline-dark {
      font-weight: 600;
    }
  </style>
</head>
<body>

  <div class="dashboard-header">
    <h1>Welcome, <?= $adminName ?>!</h1>
    <p>Admin Dashboard</p>
    <a href="admin_logout.php" class="btn btn-danger mt-2">
      <i class="fa fa-sign-out-alt"></i> Logout
    </a>
  </div>

  <div class="container dashboard-content">
    <div class="row g-4">
      <!-- View Customers -->
      <div class="col-md-6">
        <div class="card p-4">
          <h4><i class="fa fa-users"></i> View Customers</h4>
          <p>Manage and view all registered customers.</p>
          <a href="view_customers.php" class="btn btn-outline-dark">Open</a>
        </div>
      </div>

      <!-- View Orders -->
      <div class="col-md-6">
        <div class="card p-4">
          <h4><i class="fa fa-box"></i> View Orders</h4>
          <p>Check all customer orders and activities.</p>
          <a href="view_orders.php" class="btn btn-outline-dark">Open</a>
        </div>
      </div>

      <!-- Order Approval Panel -->
      <div class="col-md-6">
        <div class="card p-4">
          <h4><i class="fa fa-file-invoice-dollar"></i> Order Approval Panel</h4>
          <p>Review GCash payment receipts and approve or reject orders.</p>
          <a href="pending_payments.php" class="btn btn-outline-dark">Review Now</a>
        </div>
      </div>


      <!-- Admin Profile Settings -->
      <div class="col-md-6">
        <div class="card p-4">
          <h4><i class="fa fa-user-cog"></i> Profile Settings</h4>
          <p>Change admin credentials or profile image.</p>
          <a href="admin_profile.php" class="btn btn-outline-dark">Edit Profile</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
