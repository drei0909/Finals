<?php
session_start();
require_once('./classes/database_customers.php');

if (!isset($_SESSION['customer_ID'])) {
    header("Location: login.php");
    exit();
}

$db = new database_customers();
$con = $db->getConnection();
$customer_ID = $_SESSION['customer_ID'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $currentPass = $_POST['current_password'];
    $newPass = $_POST['new_password'];
    $confirmPass = $_POST['confirm_password'];

    // Get current hashed password
    $stmt = $con->prepare("SELECT customer_password FROM customers WHERE customer_ID = ?");
    $stmt->execute([$customer_ID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!password_verify($currentPass, $user['customer_password'])) {
        $error = "Current password is incorrect.";
    } elseif ($newPass !== $confirmPass) {
        $error = "New passwords do not match.";
    } else {
        $newHashed = password_hash($newPass, PASSWORD_BCRYPT);
        $update = $con->prepare("UPDATE customers SET customer_password = ? WHERE customer_ID = ?");
        $update->execute([$newHashed, $customer_ID]);

        echo "<script>
            alert('Password updated successfully!');
            window.location.href='menu.php';
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Change Password | IZANA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #f5f0eb, #ede0d4);
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      font-family: 'Segoe UI', sans-serif;
      padding: 1rem;
    }

    .change-password-wrapper {
      background-color: #fff;
      border-radius: 20px;
      padding: 2.5rem;
      max-width: 450px;
      width: 100%;
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }

    .izana-logo {
      text-align: center;
      margin-bottom: 1rem;
    }

    .izana-logo h1 {
      font-weight: 800;
      color: #6f4e37;
      letter-spacing: 2px;
    }

    .izana-logo img {
      width: 100px;
      margin-bottom: 0.5rem;
    }

    .form-title {
      text-align: center;
      font-size: 1.5rem;
      color: #4e342e;
      margin-bottom: 1.5rem;
    }

    .btn-custom {
      background-color: #6d4c41;
      color: #fff;
      border: none;
      font-weight: 600;
      border-radius: 10px;
    }

    .btn-custom:hover {
      background-color: #5d4037;
    }

    .form-label {
      font-weight: 500;
      color: #5e4b44;
    }

    .alert {
      font-size: 0.95rem;
    }
  </style>
</head>
<body>
  <div class="change-password-wrapper">

    <!-- Logo Area -->
    <div class="izana-logo">
      <!-- Option A: Text Logo -->
      <h1>IZANA</h1>

      <!-- OR Option B: Image Logo -->
      <!-- <img src="./assets/izana-logo.jpg" alt="IZANA Logo"> -->
    </div>

    <!-- Title -->
    <div class="form-title">Change Password</div>

    <!-- Error Message -->
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <!-- Change Password Form -->
    <form method="POST">
      <div class="mb-3">
        <label for="current_password" class="form-label">Current Password</label>
        <input type="password" class="form-control" name="current_password" id="current_password" required>
      </div>

      <div class="mb-3">
        <label for="new_password" class="form-label">New Password</label>
        <input type="password" class="form-control" name="new_password" id="new_password" required>
      </div>

      <div class="mb-3">
        <label for="confirm_password" class="form-label">Confirm New Password</label>
        <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
      </div>

      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-custom">Update Password</button>
        <a href="menu.php" class="btn btn-secondary">Back to Menu</a>
      </div>
    </form>
  </div>
</body>
</html>
