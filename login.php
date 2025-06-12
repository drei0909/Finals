<?php
session_start();

if (isset($_SESSION['admin_ID'])) {
  header('Location: index.php');
  exit();
}

require_once('./classes/database.php');
$sweetAlertConfig = "";
$con = new database();

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $user = $con->loginUser($username, $password);

  if ($user) {
    $_SESSION['admin_ID'] = $user['admin_id'];
    $_SESSION['admin_FN'] = $user['admin_FN'];

    $sweetAlertConfig = "
      <script>
      document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'success',
          title: 'Login Successful',
          text: 'Welcome, " . addslashes(htmlspecialchars($user['admin_FN'])) . "!',
          confirmButtonText: 'Continue'
        }).then(() => {
          window.location.href = 'index.php';
        });
      });
      </script>";
  } else {
    $sweetAlertConfig = "
      <script>
      document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
          icon: 'error',
          title: 'Login Failed',
          text: 'Invalid username or password.',
          confirmButtonText: 'OK'
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
  <title>IZANA | Login</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- SweetAlert2 -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

  <style>
    body {
      background: linear-gradient(to right, #f5f0eb, #ede0d4);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 1rem;
      font-family: 'Segoe UI', sans-serif;
    }

    .form-wrapper {
      background: #fff;
      padding: 2rem;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 500px;
    }

    .form-title {
      font-size: 2rem;
      font-weight: 700;
      color: #4e342e;
      text-align: center;
      margin-bottom: 0.5rem;
    }

    .form-subtitle {
      text-align: center;
      font-size: 0.95rem;
      color: #8d6e63;
      margin-bottom: 1.5rem;
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
      color: #8d6e63;
      z-index: 2;
      font-size: 1rem;
    }

    .form-group input {
      padding-left: 2.5rem;
      border-radius: 10px;
      height: 48px;
    }

    .form-group label {
      position: absolute;
      top: -10px;
      left: 45px;
      background-color: #fff;
      padding: 0 5px;
      font-size: 0.85rem;
      color: #6d4c41;
    }

    .btn-primary {
      background-color: #6d4c41;
      border: none;
      border-radius: 10px;
      font-weight: 600;
      padding: 0.75rem;
      transition: 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #5d4037;
    }

    .btn-secondary {
      border-radius: 10px;
      font-weight: 600;
      padding: 0.75rem;
      color: #6d4c41;
      border: 2px solid #6d4c41;
      background: transparent;
      transition: 0.3s ease;
    }

    .btn-secondary:hover {
      background-color: #6d4c41;
      color: #fff;
    }

    footer {
      text-align: center;
      font-size: 0.85rem;
      color: #a1887f;
      margin-top: 2rem;
    }

    .logo-container img {
      max-width: 100px;
      display: block;
      margin: 0 auto 1.5rem;
    }
  </style>
</head>

<body>
  <div class="form-wrapper">
    <div class="logo-container">
      <img src="./assets/izana-logo.jpg" alt="IZANA Logo" />
    </div>
    <div class="form-title">Welcome Back</div>
    <div class="form-subtitle">Login to your IZANA account</div>

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

      <a href="registration.php" class="btn btn-secondary w-100">
        <i class="fa fa-arrow-left me-2"></i>Back to Registration
      </a>
    </form>

    <footer>
      © <?= date("Y") ?> IZANA Coffee Shop. Crafted with care.
    </footer>
  </div>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?= $sweetAlertConfig ?>
</body>
</html>
