<?php
session_start();
require_once('./classes/database_admin.php');

if (!isset($_SESSION['admin_ID'])) {
    header("Location: admin_L.php");
    exit();
}

$con = new adminDatabase();
$conn = $con->getConnection(); // Securely get the PDO connection
$adminID = $_SESSION['admin_ID'];

// Fetch admin info
$stmt = $conn->prepare("SELECT * FROM admin WHERE admin_ID = ?");
$stmt->execute([$adminID]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Profile | IZANA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #f5f5f5;
      font-family: 'Segoe UI', sans-serif;
    }

    .profile-container {
      max-width: 600px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .profile-header {
      text-align: center;
      margin-bottom: 30px;
    }

    .btn-custom {
      background-color: #4e342e;
      color: white;
      border: none;
    }

    .btn-custom:hover {
      background-color: #3e2723;
    }
  </style>
</head>
<body>

<div class="container profile-container">
  <div class="profile-header">
    <h2><i class="fa fa-user-shield"></i> Admin Profile</h2>
    <p>Welcome, <?= htmlspecialchars($admin['admin_FN'] . ' ' . $admin['admin_LN']) ?></p>
  </div>

  <table class="table table-bordered">
    <tr>
      <th>First Name</th>
      <td><?= htmlspecialchars($admin['admin_FN']) ?></td>
    </tr>
    <tr>
      <th>Last Name</th>
      <td><?= htmlspecialchars($admin['admin_LN']) ?></td>
    </tr>
    <tr>
      <th>Username</th>
      <td><?= htmlspecialchars($admin['admin_username']) ?></td>
    </tr>
    <tr>
      <th>Email</th>
      <td><?= htmlspecialchars($admin['admin_email']) ?></td>
    </tr>
  </table>

  <div class="d-flex justify-content-between mt-4">
    <a href="update_admin_profile.php" class="btn btn-custom">
      <i class="fa fa-edit"></i> Edit Profile
    </a>
    <a href="admin_logout.php" class="btn btn-danger">
      <i class="fa fa-sign-out-alt"></i> Logout
    </a>
  </div>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
