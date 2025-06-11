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
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center min-vh-100">

  <div class="text-center">
    <h1 class="fw-bold text-primary mb-5">Welcome! Please Choose Order Type</h1>
    <div class="d-flex flex-column flex-md-row justify-content-center align-items-center gap-4">
      
      <a href="order.php?type=dinein" class="text-decoration-none text-dark">
        <div class="card p-4 shadow-sm border-0 text-center" style="min-width: 200px;">
          <i class="bi bi-cup-hot display-4 text-primary mb-3"></i>
          <h3 class="mb-0">Dine In</h3>
        </div>
      </a>

      <a href="order.php?type=takeout" class="text-decoration-none text-dark">
        <div class="card p-4 shadow-sm border-0 text-center" style="min-width: 200px;">
          <i class="bi bi-bag-check display-4 text-success mb-3"></i>
          <h3 class="mb-0">Take Out</h3>
        </div>
      </a>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
