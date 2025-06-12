<?php
session_start();
if (!isset($_SESSION['admin_ID'])) {
  header('Location: login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">    
<head>
  <meta charset="UTF-8">
  <title>Select Order Type</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(to right, #f5f0eb, #ece0d1);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 1rem;
    }

    .container-box {
      background-color: #ffffff;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0, 0, 0, 0.1);
      padding: 3rem 2rem;
      text-align: center;
      width: 100%;
      max-width: 600px;
      position: relative;
    }

    .logout-btn {
      position: absolute;
      top: 20px;
      right: 20px;
    }

    h1 {
      font-weight: 700;
      color: #4e342e;
      margin-bottom: 2rem;
    }

    .order-option {
      transition: all 0.3s ease;
      cursor: pointer;
      border-radius: 15px;
    }

    .order-option:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
    }

    .order-option i {
      transition: transform 0.3s;
    }

    .order-option:hover i {
      transform: scale(1.2);
    }

    .order-text {
      font-size: 1.2rem;
      font-weight: 600;
      color: #3e2723;
    }

    footer {
      text-align: center;
      font-size: 0.85rem;
      margin-top: 2rem;
      color: #a1887f;
    }
  </style>
</head>
<body>

  <div class="container-box">
    <!-- Logout Button -->
    <a href="logout.php" class="btn btn-outline-danger btn-sm logout-btn">
      <i class="bi bi-box-arrow-right"></i> Logout
    </a>

    <h1>Welcome! Choose Your Order Type</h1>

    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4">
      
      <a href="order.php?type=dinein" class="text-decoration-none">
        <div class="order-option card p-4 shadow-sm border-0 text-center">
          <i class="bi bi-cup-hot display-4 text-primary mb-3"></i>
          <div class="order-text">Dine In</div>
        </div>
      </a>

      <a href="order.php?type=takeout" class="text-decoration-none">
        <div class="order-option card p-4 shadow-sm border-0 text-center">
          <i class="bi bi-bag-check display-4 text-success mb-3"></i>
          <div class="order-text">Take Out</div>
        </div>
      </a>

    </div>

    <footer class="mt-4">© <?= date("Y") ?> IZANA Coffee Shop. Crafted with warmth and care.</footer>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
