<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();


ob_start(); // Required for header redirects
 

require_once('./classes/database_admin.php');
$sweetAlertConfig = "";
$con = new adminDatabase();
 
if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $admin = $con->loginAdmin($username, $password);
  

 
  if ($admin) {
    $_SESSION['admin_ID'] = $admin['admin_id'];
    $_SESSION['admin_FN'] = $admin['admin_FN'];
 
    // Success alert with redirect
    $sweetAlertConfig = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'success',
          title: 'Login Successful!',
          text: 'Redirecting to dashboard...',
          timer: 1500,
          showConfirmButton: false
        }).then(() => {
          window.location.href = 'index_A.php';
        });
      });
    </script>
    ";
  } else {
    // Failed login SweetAlert
    $sweetAlertConfig = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'error',
          title: 'Login Failed',
          text: 'Invalid username or password.',
          confirmButtonText: 'Try Again'
        });
      });
    </script>";
  }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin Login | IZANA</title>
 
  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />
 
  <style>
    body {
      background: linear-gradient(145deg, #121212, #1f1f1f);
      color: #f0f0f0;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }
 
    .login-box {
      background: #232323;
      padding: 2.5rem;
      border-radius: 16px;
      width: 100%;
      max-width: 480px;
      box-shadow: 0 0 30px rgba(0, 0, 0, 0.7);
    }
 
    .logo-container img {
      max-width: 80px;
      display: block;
      margin: 0 auto 1.2rem;
    }
 
    .form-title {
      font-size: 2rem;
      text-align: center;
      font-weight: 700;
      margin-bottom: 0.5rem;
      color: #00bcd4;
    }
 
    .form-subtitle {
      text-align: center;
      font-size: 0.95rem;
      color: #bbb;
      margin-bottom: 1.8rem;
    }
 
    .form-group {
      position: relative;
      margin-bottom: 1.5rem;
    }
 
    .form-group i {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      color: #888;
      z-index: 2;
      font-size: 1rem;
    }
 
    .form-group input {
      padding-left: 2.5rem;
      border-radius: 10px;
      border: 1px solid #444;
      background-color: #181818;
      color: #f4f4f4;
      height: 48px;
    }
 
    .form-group label {
      position: absolute;
      top: -10px;
      left: 45px;
      background-color: #232323;
      padding: 0 5px;
      font-size: 0.85rem;
      color: #999;
    }
 
    .btn-primary {
      background-color: #00bcd4;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 0.75rem;
      transition: 0.3s ease;
    }
 
    .btn-primary:hover {
      background-color: #0097a7;
    }
 
    .btn-outline-secondary {
      border: 2px solid #888;
      color: #bbb;
      background-color: transparent;
      border-radius: 10px;
      font-weight: 600;
      padding: 0.7rem;
      margin-top: 0.8rem;
    }
 
    .btn-outline-secondary:hover {
      background-color: #555;
      color: #fff;
    }
 
    footer {
      text-align: center;
      font-size: 0.85rem;
      color: #777;
      margin-top: 2rem;
    }
  </style>
</head>
 
<body>
  <div class="login-box">
    <div class="logo-container">
      <img src="./assets/izana-logo.jpg" alt="IZANA Logo" />
    </div>
    <div class="form-title">Admin Login</div>
    <div class="form-subtitle">Access your admin dashboard securely</div>
 
    <form method="POST" novalidate>
      <div class="form-group">
        <i class="fa fa-user-circle"></i>
        <input type="text" name="username" id="username" class="form-control" required>
        <label for="username">Username</label>
      </div>
 
      <div class="form-group">
        <i class="fa fa-lock"></i>
        <input type="password" name="password" id="password" class="form-control" required>
        <label for="password">Password</label>
      </div>
 
      <button type="submit" name="login" class="btn btn-primary w-100 mb-2">Login</button>
 
      <a href="home.php" class="btn btn-outline-secondary w-100">
        <i class="fa fa-home me-2"></i> Back to Home
      </a>
    </form>
 
    <footer>
      &copy; <?= date("Y") ?> IZANA Coffee Shop. Admin Panel.
    </footer>
  </div>
 
  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <?= $sweetAlertConfig ?>
</body>
</html>
 
 