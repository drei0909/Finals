<?php
session_start();
require_once('./classes/database_admin.php');

if (!isset($_SESSION['admin_ID'])) {
    header("Location: admin_L.php");
    exit();
}

$con = new adminDatabase();
$conn = $con->getConnection();
$adminID = $_SESSION['admin_ID'];

// Fetch current admin info
$stmt = $conn->prepare("SELECT * FROM admin WHERE admin_ID = ?");
$stmt->execute([$adminID]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['admin_FN'];
    $lastName = $_POST['admin_LN'];
    $username = $_POST['admin_username'];
    $email = $_POST['admin_email'];
    $password = $_POST['admin_password'];

    if (!empty($password)) {
        // Hash new password only if entered
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $update = $conn->prepare("UPDATE admin SET admin_FN=?, admin_LN=?, admin_username=?, admin_email=?, admin_password=? WHERE admin_ID=?");
        $update->execute([$firstName, $lastName, $username, $email, $hashedPassword, $adminID]);
    } else {
        // Update without changing password
        $update = $conn->prepare("UPDATE admin SET admin_FN=?, admin_LN=?, admin_username=?, admin_email=? WHERE admin_ID=?");
        $update->execute([$firstName, $lastName, $username, $email, $adminID]);
    }

    // Refresh session name
    $_SESSION['admin_FN'] = $firstName;

    header("Location: admin_profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Admin Profile | IZANA</title>
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

    .form-container {
      max-width: 600px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
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

<div class="container form-container">
  <h2 class="text-center mb-4"><i class="fa fa-edit"></i> Edit Admin Profile</h2>

  <form method="POST">
    <div class="mb-3">
      <label for="admin_FN" class="form-label">First Name</label>
      <input type="text" name="admin_FN" id="admin_FN" class="form-control" value="<?= htmlspecialchars($admin['admin_FN']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="admin_LN" class="form-label">Last Name</label>
      <input type="text" name="admin_LN" id="admin_LN" class="form-control" value="<?= htmlspecialchars($admin['admin_LN']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="admin_username" class="form-label">Username</label>
      <input type="text" name="admin_username" id="admin_username" class="form-control" value="<?= htmlspecialchars($admin['admin_username']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="admin_email" class="form-label">Email</label>
      <input type="email" name="admin_email" id="admin_email" class="form-control" value="<?= htmlspecialchars($admin['admin_email']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="admin_password" class="form-label">New Password (leave blank to keep current)</label>
      <input type="password" name="admin_password" id="admin_password" class="form-control">
    </div>

    <div class="d-flex justify-content-between">
  <a href="admin_profile.php" class="btn btn-secondary">
    <i class="fa fa-arrow-left"></i> Cancel
  </a>
  <a href="index_A.php" class="btn btn-outline-dark">
    <i class="fa fa-home"></i> Back to Dashboard
  </a>
  <button type="submit" class="btn btn-custom">
    <i class="fa fa-save"></i> Save Changes
  </button>
</div>

  </form>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
